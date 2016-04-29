<?php

echo $this->requestAction('/catagories/chips', array('return')); 

echo $this->requestAction('/products/items', array('return', 'named' => $this->request->params['named'] ));

?>