<?php
class ProductsController extends AppController {
  public $helpers = array('Html', 'Form', 'Js');
  public $components = array('Paginator','RequestHandler');

  public $paginate = array(
    'limit' => 15,
    'order' => array(
      'Product.name' => 'asc'
    )
  );
  public function index() {
    

  }
  public function items() {
    $this->set('hasCategory',array_key_exists('category',$this->params['named']));
   
    $this->Paginator->settings = $this->paginate;
    if(array_key_exists('category',$this->params['named'])){
      $data = $this->Paginator->paginate('Product',array("category_id" => $this->params['named']['category']));
    }else{
      $data = $this->Paginator->paginate('Product');
    }


    $this->set('products', $data);
  }
}