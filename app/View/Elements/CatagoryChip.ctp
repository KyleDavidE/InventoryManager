<a class="chip catagory-chip <?php echo htmlspecialchars($catagory['Catagory']['color']) ?>" href="<?php echo htmlspecialchars($this->Html->url(array('controller'=>'catagories','action' => 'view', $catagory['Catagory']['id'])))?>" data-magic-link-frame="content" data-magic-link-history="push">
		<?php echo htmlspecialchars($catagory['Catagory']['name']) ?>
	</a>