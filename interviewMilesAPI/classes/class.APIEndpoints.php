<?php
class APIEndpoints extends API{
	public function category($method,$verb,$args,$dataObj){
		$cat=new CategoryHandler();
		if($method=="POST"&&$verb=='add'&&property_exists($dataObj,'category')){
			$this->_response($cat->addCategory($dataObj));
		}
		else if($method=="GET"&&$verb=="getByID"&&count($args)>0){
			$start=0;
			if(isset($args[1])&&is_numeric($args[1]))
				$start=$args[1];
			$this->_response($cat->getCategoryByID($args[0],$start));
		}
		else if($method=="GET"&&$verb=="findByName"&&count($args)>0){
			$start=0;
			if(isset($args[1])&&is_numeric($args[1]))
				$start=$args[1];
			$this->_response($cat->findCategories($args[0],$start));
		}
		else{
			$res=array();
			$res['error']='Bad Request';
			$this->_response($res,400);
		}
	}
}
?>