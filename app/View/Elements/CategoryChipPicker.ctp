<div class="chip category-chip category-picker-chip <?php echo htmlspecialchars($category['Category']['color']) ?> <?php
if($target['Category']['id'] === $category['Category']['id']) echo 'active';
?>" data-color="<?php echo htmlspecialchars($category['Category']['color']) ?>" value="<?php echo $category['Category']['id'] ?>" >
	<?php echo htmlspecialchars($category['Category']['name']) ?>
</div>