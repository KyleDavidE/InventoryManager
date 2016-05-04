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
  public function view($id = null) {
      $named = $this->request->params['named'];
      if (!$id) {
          throw new NotFoundException(__('Invalid product'));
      }
      $product = $this->Product->findById($id);
      if (!$product) {
          throw new NotFoundException(__('Invalid product'));
      }
     
      $this->set('product',$product);
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
  public function edit($id = null){
      if (!$id) {
          throw new NotFoundException(__('Invalid product'));
      }

      $product = $this->Product->findById($id);
      if (!$product) {
          throw new NotFoundException(__('Invalid product'));
      }

      if ($this->request->is(array('post', 'put'))) {
          $this->Product->id = $id;
          if ($this->Product->save($this->request->data)) {
              
              return "DONE";
          }
          
      }

      if (!$this->request->data) {
          $this->request->data = $product;
          $this->set('product',$product);
      }
  }
}