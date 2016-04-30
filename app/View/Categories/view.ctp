<x-page-props data-theme-color="<?php echo  $category['Category']['color']?>" data-show-back="true" data-title="<?php echo htmlspecialchars($category['Category']['name']) ?>"></x-page-props>
<?php if($page == 1): ?>
<div class="detail">
	<?php echo $this->Text->autoParagraph($category['Category']['details']) ?>
</div>
<?php endif ?>
<?php

echo $this->requestAction('/products/items', array('return', 'named' => array('category'=>$category['Category']['id'], 'page' => $page) ));
?>