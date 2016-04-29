<x-page-props data-theme-color="<?php echo  $catagory['Catagory']['color']?>" data-show-back="true" data-title="<?php echo htmlspecialchars($catagory['Catagory']['name']) ?>"></x-page-props>
<?php if($page == 1): ?>
<div class="detail">
	<?php echo $this->Text->autoParagraph($catagory['Catagory']['details']) ?>
</div>
<?php endif ?>
<?php

echo $this->requestAction('/products/items', array('return', 'named' => array('catagory'=>$catagory['Catagory']['id'], 'page' => $page) ));
?>