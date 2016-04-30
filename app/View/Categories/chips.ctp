<div id="category-chips">
<?php 
$this->Paginator->options(array(
    
));
?>


<div class="category-switcher z-depth-1">

<?php
echo $this->Paginator->prev('<i class="material-icons waves-effect waves-circle">chevron_left</i>', array('escape' => false, 'data-magic-link-frame'=>'category-chips'));

?>

<div class="category-switcher--chips">
<?php foreach ($categories as $category): 
?><?php echo $this->element('CategoryChip', array(
    "category" => $category
)); ?><?php

	
	endforeach; ?>
	
	<?php unset($category); ?>
</div>

<?php
echo $this->Paginator->next('<i class="material-icons waves-effect waves-circle">chevron_right</i>', array('escape' => false, 'data-magic-link-frame'=>'category-chips'));

?>

</div>

</div>
