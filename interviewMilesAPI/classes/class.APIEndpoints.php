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
		else if ($method=="POST"&&$verb=="addTag"&&property_exists($dataObj,'tagId')&&property_exists($dataObj,'questionId')){
			$this->_response($que->addTag($dataObj));
		}
		else if ($method=="POST"&&$verb=="removeTag"&&property_exists($dataObj,'tagId')&&property_exists($dataObj,'questionId')){
			$this->_response($que->removeTag($dataObj));
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
		else if($method=="GET"&&$verb=="get"&&count($args)>0){
			$dataObj->questionId=$args[0];
			$this->_response($que->getQuestion($dataObj));
		}
		else if($method=="GET"&&$verb=="getTags"&&count($args)>0&&is_numeric($args[0])){
			$dataObj->questionId=$args[0];
			$this->_response($que->getTags($dataObj));
		}
		else{
			$res=array();
			$res['error']='Bad Request';
			$this->_response($res,400);
		}
	}
	public function answer($method,$verb,$args,$dataObj){
		$ans=new AnswerHandler();
		if($method=="GET"&&$verb="get"&&count($args)>0){
			$dataObj->questionId=$args[0];
			$dataObj->start=0;
			if(count($args)>1)
				$dataObj->start=$args[1];
			$this->_response($ans->getAnswers($dataObj));
		}
		else if($method=="POST"&&$verb="add"&&property_exists($dataObj, 'answer')&&property_exists($dataObj, 'questionId')){
			$this->_response($ans->addAnswer($dataObj));
		}
		else{
			$res=array();
			$res['error']='Bad Request';
			$this->_response($res,400);
		}
	}
	public function choice($method,$verb,$args,$dataObj){
		$choice=new MCQChoiceHandler();
		if($method=="GET"&&$verb="get"&&count($args)>0){
			$dataObj->questionId=$args[0];
			$dataObj->start=0;
			if(count($args)>1)
				$dataObj->start=$args[1];
			$this->_response($choice->getChoices($dataObj));
		}
		else if($method=="POST"&&$verb="add"&&property_exists($dataObj, 'choice')&&property_exists($dataObj, 'questionId')){
			$this->_response($choice->addChoice($dataObj));
		}
		else{
			$res=array();
			$res['error']='Bad Request';
			$this->_response($res,400);
		}
	}
	public function user($method,$verb,$args,$dataObj){
		$userhandler=new UserHandler();
		if($method=="POST"&&$verb=="login"&&property_exists($dataObj, 'email')&&property_exists($dataObj, 'password'))
			$this->_response($userhandler->login($dataObj));
		else if($method=="POST"&&$verb=="register"&&property_exists($dataObj, 'name')&&property_exists($dataObj, 'email')&&property_exists($dataObj, 'password'))
			$this->_response($userhandler->register($dataObj));
		else if ($method=='GET'&&$verb=="logout")
			$this->_response($userhandler->logout());
		else{
			$res=array();
			$res['error']='Bad Request';
			$this->_response($res,400);	
		}
	}
}
?>