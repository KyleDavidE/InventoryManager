
<div id="products">
<?php 
$this->Paginator->options(array(
    
));

?>
	<div class="collection z-depth-1">
	<?php 
		if($this->Paginator->hasPrev()) echo $this->element('itemPaginate');
		foreach ($products as $product): ?>
		<div class="collection-item">
				<span><?php echo htmlspecialchars($product['Product']['name']); ?></span>
				<?php if(!$hasCategory):
					echo $this->element('CategoryChip', array(
							"category" => $product
					)); 
				 endif ?>
				
				<a href="<?php echo htmlspecialchars($this->Html->url(array('action' => 'edit', $product['Product']['id'])))?>" data-magic-link-frame="content" data-magic-link-history="push" class="waves-effect waves-circle item-button"> 
					<i class="material-icons">edit</i>
				</a>
		</div>
	<?php endforeach; ?>
	<?php 
		echo $this->element('itemPaginate');
	?>
	 </div>
   
</div>