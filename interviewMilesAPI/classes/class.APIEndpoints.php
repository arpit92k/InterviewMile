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
	public function question($method,$verb,$args,$dataObj){
		$que=new QuestionHandler();
		if($method=="POST"&&$verb=="add"&&property_exists($dataObj,'title')){
			$this->_response($que->addQusestion($dataObj));
		}
		else if($method=="GET"&&$verb=="getAll"){
			if(count($args)>0)
				$dataObj->start=$args[0];
			$this->_response($que->listQuestions($dataObj));
		}
		else if($method=="GET"&&$verb=="findByTitle"&&count($args)>0){
			$dataObj->title=$args[0];
			if(count($args==2))
				$dataObj->start=$args[1];
			$this->_response($que->findQuestionsByTitle($dataObj));
		}
		else if($method=="GET"&&$verb=="getByCategory"&&count($args)>0&&is_numeric($args[0])){
			$dataObj->categoryId=intval($args[0]);
			if(count($args)==2)
				$dataObj->start=$args[1];
			$this->_response($que->findQuestionByCategory($dataObj));
		}
		else if($method=="GET"&&$verb="get"&&count($args)>0){
			$dataObj->questionId=$args[0];
			$this->_response($que->getQuestion($dataObj));
		}
		else{
			$res=array();
			$res['error']='Bad Request';
			$this->_response($res,400);
		}
	}
}
?>