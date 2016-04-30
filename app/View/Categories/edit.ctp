<x-page-props data-theme-color="<?php echo  $category['Category']['color']?>" data-show-back="true" data-title="<?php echo htmlspecialchars($category['Category']['name']) ?>"></x-page-props>

<?php

echo $this->Form->create('Category',array('data-autosubmit'=>true));
echo $this->Form->input('name', array('div'=>array('class'=> "input-field" )));
echo $this->Form->input('details', array('rows' => '1', 'class'=> 'materialize-textarea' , 'div'=>array('class'=> "input-field" )));
?><div class="color-selector"><?php

foreach(Configure::read('mdColors') as $color ){

echo $this->Form->radio('color',array(

	$color=>array('name'=>false) 
	)
,
array('legend'=>false,'label'=>array('class'=>$color),'id'=>'color-'.$color)
);
}?></div><?php
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end();
?>