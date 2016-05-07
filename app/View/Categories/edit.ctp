<x-page-props data-theme-color="<?php echo  $category ? $category['Category']['color'] : 'blue' ?>" data-show-back="true" data-title="<?php echo htmlspecialchars($category ? $category['Category']['name'] : '') ?>"></x-page-props>

<?php

echo $this->Form->create('Category',array('data-autosubmit'=>true,'data-wait-for-action'=>!$category));
echo $this->Form->input('name', array('div'=>array('class'=> "input-field" )));
echo $this->Form->input('details', array('rows' => '1', 'class'=> 'materialize-textarea' , 'div'=>array('class'=> "input-field" )));
?><div class="color-selector"><?php

foreach(Configure::read('mdColors') as $color ){

echo $this->Form->radio('color',array(
		$color=>array('name'=>false) 
	),
	array('legend'=>false,'label'=>array('class'=>$color),'id'=>'color-'.$color, "hiddenField" => false)
);
}?></div><?php
echo $this->Form->end();
?>