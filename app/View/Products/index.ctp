<?php

echo $this->requestAction('/categories/chips', array('return')); 

echo $this->requestAction('/products/items', array('return', 'named' => $this->request->params['named'] ));

?>