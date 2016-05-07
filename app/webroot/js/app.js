$(function() {
    var mdColors = {
        "red": "#f44336",
        "pink": "#e91e63",
        "purple": "#9c27b0",
        "deep-purple": "#673ab7",
        "indigo": "#3f51b5",
        "blue": "#2196f3",
        "light-blue": "#03a9f4",
        "cyan": "#00bcd4",
        "teal": "#009688",
        "green": "#4caf50",
        "light-green": "#8bc34a",
        "lime": "#cddc39",
        "yellow": "#ffeb3b",
        "amber": "#ffc107",
        "orange": "#ff9800",
        "deep-orange": "#ff5722",
        "brown": "#795548",
        "grey": "#9e9e9e"
    };
    var historyReplaceFull = {
        "/products/index":"/"
    }
    var selector = "a[data-magic-link-href], a[data-magic-link-history], a[data-magic-link-frame]";
    function debounce(ms,fn){
        var lastTimeout = -1;
        return function(){
            clearTimeout(lastTimeout);
            var args = arguments;
            var scope = this;
            lastTimeout = setTimeout(function(){
                fn.apply(scope,args)
            },ms);
        }
    }
    function bindButtons(scope) {
        $(selector, scope).off("click.magicLink").on("click.magicLink", followMagicLink);
        $("a[data-magic-link-go]").off("click.magicLinkGo").on("click.magicLinkGo", magicLinkgo).each(function() {
            this.href = "#" + (this.getAttribute("data-magic-link-go") == 1 ? "forward" : "back"); //1. we need a href for the css to be happy, 2. I like to look at the little preview thing to see what the link does
        });


        $('.color-selector input',scope).on('change', function(){
            if(this.checked){
                setTheme(this.value);
            }
        });
        Materialize.updateTextFields();
        $('[data-autosubmit]',scope).each(function(){
            var self = $(this);
            var findingAction = false;
            function send(){
                if(findingAction) return;
                if(self.data('wait-for-action')){
                    findingAction = true;
                }
                $.ajax({
                    dataType: "json",
                    success: function(data, textStatus) {
                        if(self.data('wait-for-action')){
                            self.data('wait-for-action',false);
                            self.attr("action",data.updateUrl);
                            findingAction = false;
                            history.replaceState( {
                                wasPushed:false
                            }, document.title, data.updateUrl);
                        }
                    },
                    method: "POST",

                    url: self.attr("action"),
                    data:self.serialize()
                });
            }
            self.find('input, textarea').on('change keyup',debounce(250,function(){
                console.log("!SEND!");
                send();
            }));
        });

        $('.category-picker',scope).each(function(){
            var picker = $(this);
            var state = $('input.picker-target').val();
            var chips = picker.find('.category-picker-chip').on('click',function(){
                picker.find('.category-picker-chip.active').removeClass('active');
                var self = $(this);
                self.addClass('active');
                var color = self.data('color');
                setTheme(color);
                $('input.picker-target').val(self.attr('value')).trigger('change');
                $('.chip.picker-target').removeClass(Object.keys(mdColors).join(' ')).addClass(color).text(self.text());
            });
            if(state){
                console.log('state',state);
                picker.find('.category-picker-chip[value="'+(+state)+'"]').addClass('active');
            }
        });
        $('.active-icon',scope).on('transitionend',function(e){
            $(this).toggleClass('active',$(this).parent().parent().hasClass('active'));
        }).on('click',function(){

        });
    }

    function magicLinkgo(e) {
        e.preventDefault();
        // console.log("MAGIC LINK GO");
        history.go(+this.getAttribute("data-magic-link-go"));
    }

    function followMagicLink(e) {

        e.preventDefault();
        var self = $(this);

        var href = self.attr("href");
        var contentHref = self.attr("data-magic-link-href");
        var useHistory = self.data("magic-link-history");

        var frameId = self.attr("data-magic-link-frame");
        var computeGlobal = self.data("magic-link-compute-global");
        if (computeGlobal) {
            console.log("COMPUTE GLOBAL", typeof computeGlobal, useHistory);
            if (typeof computeGlobal == "string") {
                computeGlobal = JSON.parse(computeGlobal);
            }
            contentHref = href;
            href = contentHref.replace(new RegExp(computeGlobal[0], 'i'), computeGlobal[1]);

        }
        var config = {
            frames: [
                [frameId == "content" ? "useGlobal" : frameId, contentHref, contentHref || href]
            ],

            global: (contentHref || frameId == "content") ? href : null //if no info is given assume that there is no global link and the one given is the scoped link
        }
        applyState(config);
        if (config.global && useHistory) {
            console.log(config.global);
            history[useHistory == "replace" ? "replaceState" : "pushState"]({
                wasPushed: useHistory != "replace"
            }, document.title, historyReplaceFull[config.global] || config.global);
        }

    }
    $(window).on('popstate', function(e) {
        applyState({
            global: document.location
        });
    });

    function addJob(job) {

    }
    var contentFrame = $("#content");

    function applyState(state) {
        var useGlobal = !state.frames;
        var frames = (state.frames || []).map(function(frame) {
            var jq = $('#' + frame[0]);
            if (jq[0]) {
                return {
                    elem: jq,
                    url: frame[2]
                };
            } else {
                useGlobal = true;
                return null;
            }

        });
        if (useGlobal) {
            if (!state.global);
            $.ajax({
                dataType: "html",
                success: function(data, textStatus) {
                    contentFrame.html(data);
                    bindButtons(contentFrame);
                    updateTheme();
                },
                url: state.global
            });
        } else {
            frames.map(function(frame) {
                $.ajax({
                    dataType: "html",
                    success: function(data, textStatus) {
                        frame.elem.html(data);
                        bindButtons(frame.elem);
                        updateTheme();
                    },
                    url: frame.url
                });
            });
        }
    }

    var metaThemeColor = $('meta[name="theme-color"]');
    function setTheme(themeColor){
        $('.theme-me').removeClass(Object.keys(mdColors).join(' ')).addClass(themeColor);
        metaThemeColor.attr('content', mdColors[themeColor]);
    }
    function updateTheme() {
        var props = $('x-page-props');
        var themeColor = props.data('theme-color') || 'deep-purple';
        setTheme(themeColor);   
        
        var title = props.data('title') || 'Inventory Manager';
        $('.page-title').text(title);
        $('.back-button').toggle(!!props.data('show-back'))
    }
    bindButtons(document);
    updateTheme();
});