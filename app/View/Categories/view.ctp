<x-page-props data-theme-color="<?php echo  $category['Category']['color']?>" data-show-back="true" data-title="<?php echo htmlspecialchars($category['Category']['name']) ?>"></x-page-props>

<?php echo $this->element('detailsBlock',array('item' => $category['Category'])); 
echo $this->requestAction('/products/items', array('return', 'named' => array('category'=>$category['Category']['id'], 'page' => $page) ));
?>