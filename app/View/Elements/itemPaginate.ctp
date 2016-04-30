<?php $computeGlobal = $hasCategory ? '["products\\\\/items(.*)\\\\/category:(\\\\d+)","categories/view/$2$1"]' : '["items","index"]' ?>
		<div class="collection-item paginate"><?php 
		if($this->Paginator->hasPrev()) echo $this->Paginator->prev('<i class="material-icons">keyboard_arrow_up</i>', array('escape' => false, 'data-magic-link-frame'=>'products', 'data-magic-link-compute-global' => htmlentities($computeGlobal), 'data-magic-link-history' => "replace", "class" => "waves-effect"));
		if($this->Paginator->hasPrev() || $this->Paginator->hasNext()) echo $this->Paginator->next('<i class="material-icons">keyboard_arrow_down</i>', array('escape' => false, 'data-magic-link-frame'=>'products','data-magic-link-compute-global' => htmlentities($computeGlobal), 'data-magic-link-history' => "replace", "class" => "waves-effect"));
		
	?></div>
	