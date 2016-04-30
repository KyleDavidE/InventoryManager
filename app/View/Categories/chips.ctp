<div id="category-chips">
<?php 
if($isPicker):?>
<div class="chip picker-target category-chip <?php echo htmlspecialchars($pickerTarget['Category']['color']) ?>" >
	<?php echo htmlspecialchars($pickerTarget['Category']['name']) ?>
</div>
<?php
endif;
?>

<div class="category-switcher z-depth-1 <?php if($isPicker) echo 'category-picker'?>">

<?php
echo $this->Paginator->prev('<i class="material-icons waves-effect waves-circle">chevron_left</i>', array('escape' => false, 'data-magic-link-frame'=>'category-chips'));

?>

<div class="category-switcher--chips">
<?php foreach ($categories as $category): 
?><?php echo $isPicker ? $this->element('CategoryChipPicker', array(
	"category" => $category,
	"target" => $pickerTarget
)) : $this->element('CategoryChip', array(
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