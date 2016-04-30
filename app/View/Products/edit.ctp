<x-page-props data-theme-color="<?php echo  $product['Category']['color']?>" data-show-back="true" data-title="<?php echo htmlspecialchars($product['Product']['name']) ?>"></x-page-props>

<?php

echo $this->Form->create('Product',array('data-autosubmit'=>true));
echo $this->Form->input('name', array('div'=>array('class'=> "input-field" )));
echo $this->Form->input('details', array('rows' => '1', 'class'=> 'materialize-textarea' , 'div'=>array('class'=> "input-field" )));
echo $this->Form->input('category_id', array('div'=>array('class'=> "input-field"),'type' => 'hidden', 'class' => 'picker-target'));
echo $this->requestAction('/categories/chips', array('return', 'named' => array('picker'=>$product['Product']['id'] ))); 
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end();
?>