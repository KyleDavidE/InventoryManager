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
    $this->set('hasCatagory',array_key_exists('catagory',$this->params['named']));
   
    $this->Paginator->settings = $this->paginate;
    if(array_key_exists('catagory',$this->params['named'])){
      $data = $this->Paginator->paginate('Product',array("catagory_id" => $this->params['named']['catagory']));
    }else{
      $data = $this->Paginator->paginate('Product');
    }


    $this->set('products', $data);
  }
}