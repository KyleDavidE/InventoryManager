
<div id="products">
<?php 
$this->Paginator->options(array(
    
));

?>
	<div class="collection z-depth-1">
	<?php 
		if($this->Paginator->hasPrev()) echo $this->element('itemPaginate');
	  ?>
	<?php foreach ($products as $product): ?>
			<div class="collection-item">
				
					<?php echo htmlspecialchars($product['Product']['name']); ?>
					<?php if(!$hasCategory):
						echo $this->element('CategoryChip', array(
   							"category" => $product
						)); 
					 endif ?>
			</div>
		<?php endforeach; ?>
		<?php 
		echo $this->element('itemPaginate');
	  ?>
	 </div>
   
</div>