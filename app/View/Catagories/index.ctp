<ul class="demo-list-item mdl-list">
 
	
	<!-- Here is where we loop through our $posts array, printing out post info -->

	<?php foreach ($catagories as $catagory): ?>
		<li class="mdl-list__item">
			<span class="mdl-list__item-primary-content">
				<?php echo $this->Html->link($catagory['Catagory']['name'],
array('controller' => 'catagories', 'action' => 'view', $catagory['Catagory']['id'])); ?>
			</span>
		</li>
	<?php endforeach; ?>
	<?php unset($catagory); ?>
</table>