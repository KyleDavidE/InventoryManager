<?php
class CatagoriesController extends AppController {
    public $helpers = array('Html', 'Form', 'Js');
    public $components = array('Paginator','RequestHandler');

    public $paginate = array(
        'limit' => 25,
        'order' => array(
            'Catagory.name' => 'asc'
        )
    );
    
    public function chips() {
    	$this->Paginator->settings = $this->paginate;
    	
    	$data = $this->Paginator->paginate('Catagory');
    	
        $this->set('catagories', $data);
    }
    public function view($id = null) {
        $named = $this->request->params['named'];
        if (!$id) {
            throw new NotFoundException(__('Invalid catagory'));
        }
        $catagory = $this->Catagory->findById($id);
        if (!$catagory) {
            throw new NotFoundException(__('Invalid catagory'));
        }
        if(array_key_exists('page',$named)){
            $this->set('page',$named['page']);
        }else{
            $this->set('page',1);
        }

        
        $this->set('catagory',$catagory);
    }
    public function edit($id = null){
        if (!$id) {
            throw new NotFoundException(__('Invalid catagory'));
        }

        $catagory = $this->Catagory->findById($id);
        if (!$catagory) {
            throw new NotFoundException(__('Invalid catagory'));
        }

        if ($this->request->is(array('post', 'put'))) {
            $this->Catagory->id = $id;
            if ($this->Catagory->save($this->request->data)) {
                // $this->Flash->success(__('Your post has been updated.'));
                return "DONE";
            }
            // $this->Flash->error(__('Unable to update your post.'));
        }

        if (!$this->request->data) {
            $this->request->data = $catagory;
            $this->set('catagory',$catagory);
        }
    }

}