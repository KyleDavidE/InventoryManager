<?php
class Category extends AppModel {
	 // public $hasMany = 'Product';
	public function afterFind($results, $primary = false){
		foreach ($results as $key => $val) {
			if (!isset($val['Category']['color'])) {
				$results[$key]['Category']['color'] = 'deep-purple';
			}
		}
		return $results;
	}
}