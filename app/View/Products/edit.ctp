<x-page-props data-theme-color="<?php if($product) echo  $product['Category']['color']?>" data-show-back="true" data-title="<?php  if($product) echo htmlspecialchars($product['Product']['name']) ?>"></x-page-props>

<?php

echo $this->Form->create('Product',array('data-autosubmit'=>true,'data-wait-for-action'=>!$product));
echo $this->Form->input('name', array('div'=>array('class'=> "input-field" )));
echo $this->Form->input('details', array('rows' => '1', 'class'=> 'materialize-textarea' , 'div'=>array('class'=> "input-field" )));
echo $this->Form->input('category_id', array('div'=>array('class'=> "input-field"),'type' => 'hidden', 'class' => 'picker-target'));
?><div class="chip picker-target category-chip <?php echo $product && $product['Category']['id'] ? htmlspecialchars($product['Category']['color']) : '' ?>" >
	<span><?php if($product) echo htmlspecialchars($product['Category']['name']); ?></span>
	<i class="material-icons remove-category">close</i>
</div><?php
echo $this->requestAction('/categories/chips', array('return', 'named' => array('picker'=>true ))); 

echo $this->Form->end();
?>