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
    };
    var themeColor;
    var selector = "a[data-magic-link-href], a[data-magic-link-history], a[data-magic-link-frame]";
    function debounce(ms,fn){ //quick little debounce function.
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
    function contentUpdated(scope) { //called when any major part of the page is updated
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
                $('.chip.picker-target').removeClass(Object.keys(mdColors).join(' ')).show().addClass(color).find('span').text(self.text());

            });
            if(state){
                console.log('state',state);

                picker.find('.category-picker-chip[value="'+(+state)+'"]').addClass('active');

            }else{
                $('.chip.picker-target').hide();
            }
        });
        $('.remove-category',scope).click(function(){
            setTheme('deep-purple');
            $('.chip.picker-target').removeClass(Object.keys(mdColors).join(' ')).hide().find('span').text('');
            $('input.picker-target').val('').trigger('change');
            $('.category-picker-chip.active').removeClass('active');
        });

        $('.active-icon',scope).on('transitionend',function(e){
            $(this).toggleClass('active',$(this).parent().parent().hasClass('active'));
        }).on('click',function(){

        });
        $('.remove-item',scope).click(function() {
           removeProduct($(this).parent());
        });

        $('.delete-category',scope).click(function(){

            var content = $('#removeModal')[0] || $('<div class="modal" id="removeModal"><div class="modal-content"><h4>Remove "<span></span>"?</h4>'
                +'<p>This action can not be undone.</p></div>'
                +'<div class="modal-footer"><a class="modal-action do-delete modal-close waves-effect btn-flat red-text text-accent-3 ">Delete</a>'
                +'<a class="modal-action modal-close waves-effect btn-flat ">cancel</a></div></div>');
            content = $(content);
            content.find('.do-delete').off('click.delete').on('click.delete',function(){
                $.ajax({
                    dataType:'json',
                    url:document.location.pathname.replace(/view/,'delete'),
                    method:'POST',
                    success:function(){
                        history.go(-1);
                    }
                });
            });
            content.find('span').text($('.page-title').text());

            content.appendTo('body');
            
            content.openModal();

        });
    }

    function magicLinkgo(e) { //magic history.go ie forwards / back link
        e.preventDefault();
        // console.log("MAGIC LINK GO");
        history.go(+this.getAttribute("data-magic-link-go"));
    }
    function undoableAction(text, action, canceled){ //delay an action based on a toast
        var content = $('<span><span class="toast-content"></span><a class="waves-effect waves-light btn-flat text-accent-2 red-text">undo</a></span>');
        content.find('.toast-content').text(text);
        // var doTheAction = true;
        content.find('a').click(function(){
            action = function(){}; //do not do the action ever. (should not be a problem unless the timer runs out during the animation)
            Vel(content.parent()[0], {"opacity": 0, marginTop: '-40px'}, { duration: 375, //Materialize does not give me a remove toast method.
                easing: 'easeOutExpo',
                queue: false,
                complete: function(){
                    this[0].parentNode.removeChild(this[0]);
                }
            });
            canceled();

        });
        Materialize.toast(content, 5000, "", function(){
            action();
        });
    }
    var removing = [];
    
    function removeProduct(el){ 
        var name = $('span',el).text();
        var id = el.data('id');
        el.hide();
        removing.push(id);
        function done(){
            removing.splice(removing.indexOf(id),1);
        }
        undoableAction("deleted "+name,function(){
            $.ajax({
                dataType: "json",
                success: function(data, textStatus) {
                   
                    done();
                    if(removing.length == 0){ //if you are in the process of removing another item, don't reload
                        reload();
                    }
                },
                method: "POST",

                url: '/products/delete/'+id,
               
            });

            el.remove();
          
        },function(){
            el.show();
            done();
        });
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
                [frameId == "content" ? "useGlobal" : frameId, contentHref || href]
            ],

            global: (contentHref || frameId == "content") ? href : null //if no info is given assume that there is no global link and the one given is the scoped link
        }
        updateMagicContent(config);
        if (config.global && useHistory) {
            console.log(config.global);
            history[useHistory == "replace" ? "replaceState" : "pushState"]({
                wasPushed: useHistory != "replace"
            }, document.title, historyReplaceFull[config.global] || config.global);
        }

    }
    $(window).on('popstate', function(e) {
        updateMagicContent({
            global: document.location
        });
    });
    function reload(){
        updateMagicContent({
            global: document.location
        });
    }
    function addJob(job) {

    }
    var contentFrame = $("#content");

    function updateMagicContent(config) { //upply content to part of the frame
        var useGlobal = !config.frames;
        var frames = (config.frames || []).map(function(frame) {
            var jq = $('#' + frame[0]);
            if (jq[0]) {
                return {
                    elem: jq,
                    url: frame[1],
                    id: frame[0]
                };
            } else {
                useGlobal = true;
                return null;
            }

        });
        if (useGlobal) {
            if (!config.global);
            $.ajax({
                dataType: "html",
                success: function(data, textStatus) {
                    contentFrame.html(
                        data

                    );
                    contentUpdated(contentFrame);
                    updatePageMeta();
                },
                url: config.global
            });
        } else {
            frames.map(function(frame) {
                $.ajax({
                    dataType: "html",
                    success: function(data, textStatus) {
                        frame.elem.html(cleanLoadedData(frame.id,data));
                        contentUpdated(frame.elem);
                        updatePageMeta();
                    },
                    url: frame.url
                });
            });
        }
    }
    function cleanLoadedData(frameid,html){ //strip redundant <div>s
        var matchResults = html.match(
                new RegExp('<div id="'+frameid+'>([\s\S]+)</div>','i')
            );
        return matchResults ? matchResults[1] : html;
    }

    var metaThemeColor = $('meta[name="theme-color"]');
    function setTheme(_themeColor){ //set theme color
        themeColor = _themeColor;
        $('.theme-me').removeClass(Object.keys(mdColors).join(' ')).addClass(themeColor);
        metaThemeColor.attr('content', mdColors[themeColor]);

    }
    function updatePageMeta() { //update page meta info (title, color etc)
        var props = $('x-page-props');
        var themeColor = props.data('theme-color') || 'deep-purple';
        setTheme(themeColor);   
        
        var title = props.data('title') || 'Inventory Manager';
        $('.page-title').text(title);
        $('title').text(title + '- Inventory Manager');
        $('.back-button').toggle(!!props.data('show-back'));
    }
    contentUpdated(document);
    updatePageMeta();
    $(document).off('click.chip'); //disable default meterialize behaviors
});