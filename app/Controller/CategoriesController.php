<?php
class CategoriesController extends AppController {
    public $helpers = array('Html', 'Form', 'Js');
    public $components = array('Paginator','RequestHandler');

    public $paginate = array(
        'limit' => 25,
        'order' => array(
            'Category.name' => 'asc'
        )
    );
    
    public function chips() {
        $named = $this->request->params['named'];
    	$this->Paginator->settings = $this->paginate;
    	
    	$data = $this->Paginator->paginate('Category');
    	
        $this->set('categories', $data);
        $this->set('isPicker', false);
        if(array_key_exists('picker',$named)){
            $this->loadModel('Product');
            $product = $this->Product->findById($named['picker']);
            if($product){
                $this->set('isPicker', true);
                $this->set('pickerTarget', $product);
            }
            
        }
    }
    public function view($id = null) {
        $named = $this->request->params['named'];
        if (!$id) {
            throw new NotFoundException(__('Invalid category'));
        }
        $category = $this->Category->findById($id);
        if (!$category) {
            throw new NotFoundException(__('Invalid category'));
        }
        if(array_key_exists('page',$named)){
            $this->set('page',$named['page']);
        }else{
            $this->set('page',1);
        }

        
        $this->set('category',$category);
    }
    public function edit($id = null){
        if (!$id) {
            throw new NotFoundException(__('Invalid category'));
        }

        $category = $this->Category->findById($id);
        if (!$category) {
            throw new NotFoundException(__('Invalid category'));
        }

        if ($this->request->is(array('post', 'put'))) {
            $this->Category->id = $id;
            if ($this->Category->save($this->request->data)) {
                return "DONE";
            }
            
        }

        if (!$this->request->data && $category ) {
            $this->request->data = $category;
            $this->set('category',$category);

        }else{
            $this->set('category', null);
        }
    }


}