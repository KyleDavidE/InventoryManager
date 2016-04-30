<ul class="demo-list-item mdl-list">
 
	
	<!-- Here is where we loop through our $posts array, printing out post info -->

	<?php foreach ($categories as $category): ?>
		<li class="mdl-list__item">
			<span class="mdl-list__item-primary-content">
				<?php echo $this->Html->link($category['Category']['name'],
array('controller' => 'categories', 'action' => 'view', $category['Category']['id'])); ?>
			</span>
		</li>
	<?php endforeach; ?>
	<?php unset($category); ?>
</table>