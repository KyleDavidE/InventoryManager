<a class="chip category-chip <?php echo htmlspecialchars($category['Category']['color']) ?>" href="<?php echo htmlspecialchars($this->Html->url(array('controller'=>'categories','action' => 'view', $category['Category']['id'])))?>" data-magic-link-frame="content" data-magic-link-history="push">
		<?php echo htmlspecialchars($category['Category']['name']) ?>
	</a>