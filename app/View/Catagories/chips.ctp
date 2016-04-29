<div id="catagory-chips">
<?php 
$this->Paginator->options(array(
    
));
?>


<div class="catagory-switcher z-depth-1">

<?php
echo $this->Paginator->prev('<i class="material-icons">chevron_left</i>', array('escape' => false, 'data-magic-link-frame'=>'catagory-chips'));

?>

<div class="catagory-switcher--chips">
<?php foreach ($catagories as $catagory): 
?><?php echo $this->element('CatagoryChip', array(
    "catagory" => $catagory
)); ?><?php

	
	endforeach; ?>
	
	<?php unset($catagory); ?>
</div>

<?php
echo $this->Paginator->next('<i class="material-icons">chevron_right</i>', array('escape' => false, 'data-magic-link-frame'=>'catagory-chips'));

?>

</div>

</div>
