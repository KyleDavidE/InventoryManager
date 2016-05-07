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
      // if (!$id) {
      //     throw new NotFoundException(__('Invalid product'));
      // }
      if($id != null){
        $product = $this->Product->findById($id);
      }else{
        $product = null;
      }
      
      // if (!$product) {
      //     throw new NotFoundException(__('Invalid product'));
      // }

      if ($this->request->is(array('post', 'put'))) {
          if($id != null && $product){
            $this->Product->id = $id;
            $this->set('created','no '+ $id);
          }else{
            $this->Product->create();
            $this->set('created','yes');
          }
          if ($this->Product->save($this->request->data)) {
            if($id == null) $id = $this->Product->getLastInsertID();
            $this->set('updateUrl', '/products/edit/'.$id );

            $this->set('_serialize', array('updateUrl'));
          }
          
      }

      if (!$this->request->data) {
          $this->request->data = $product;
          $this->set('product',$product);
      }
  }
  public function delete($id) {
    if ($this->request->is('get')) {
        throw new MethodNotAllowedException();
    }

    if ($this->Product->delete($id)) {
        $this->Flash->success(
            __('The post with id: %s has been deleted.', h($id))
        );
    } else {
        $this->Flash->error(
            __('The post with id: %s could not be deleted.', h($id))
        );
    }
    $this->set('_serialize', array());
  }
}