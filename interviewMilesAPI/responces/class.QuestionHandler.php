<?php
/**
 * 
 * @author arpit
 *
 */
class QuestionHandler{
	/**
	 * 
	 * @param Array $postData
	 */
	public function listQuestions($dataObj){
		$start=0;
		if(property_exists($dataObj,'start')){
			$start=intval(UtilityFunctions::fix($dataObj->start));
		}
		$questions=new Questions();
		$responce=$questions->getQuestions($start);
		return $responce;
	}
	public function getQuestion($data){
		$questionId=intval($data->questionId);
		$questions=new Questions();
		return $questions->getQuestionsById($questionId);
	}
	/**
	 * 
	 * @param Array $data
	 */
	public function addQusestion($data){
		$title=UtilityFunctions::fix($data->title);
		$description='';
		if(property_exists($data, 'description'))
			$description=UtilityFunctions::fix($data->description);
		$isMCQ=false;
		if(property_exists($data, 'isMCQ')&&is_bool($data->isMCQ))
			$isMCQ=$data->isMCQ;
		$categoryId=0;
		if(property_exists($data,'categoryID')){
			$categoryId=intval(UtilityFunctions::fix($data->categoryID));
			$cat=new Categories();
			if(!$cat->isValidCategoryId($categoryId)){
				$responce['error']='Invalid category ID';
				return $responce;
			}
		}
		$difficulty=2.5;
		if(property_exists($data, "difficulty")){
			$difficulty=doubleval($data->difficulty);
			if($difficulty<0 || $difficulty>5)
				$difficulty=2.5;
		}
		$questions=new Questions();
		$responce=$questions->addQuestion($title, $description, UtilityFunctions::getLoggedinUser(),$difficulty,$isMCQ);
		if($categoryId)
			$questions->addtag($responce['questionId'],$categoryId);
		return $responce;
	}
	public function findQuestionsByTitle($data){
		$title=UtilityFunctions::fix($data->title);
		$start=0;
		if(property_exists($data,'start'))
			$start=intval($data->start);
		$questions=new Questions();
		$responce=$questions->searchQuestions($title,$start);
		return $responce;
	}
	public function findQuestionByCategory($dataObj){
		$categoryId=intval($dataObj->categoryId);
		$start=0;
		if(property_exists($dataObj, 'start'))
			$start=intval($dataObj->start);
		$questions=new Questions();
		return $questions->getQuestionsByCategory($categoryId,$start);
	}
	public function addTag($dataObj){
		$questionId=intval($dataObj->questionId);
		$tagId=intval($dataObj->tagId);
		$tags=new Categories();
		$questions=new Questions();
		$responce=array();
		if(!$tags->isValidCategoryId($tagId))
			$responce['error']="Invalid tag ID";
		elseif (!$questions->isValidQuestionId($questionId))
			$responce['error']="Invalid question ID";
		else if($questions->hastag($questionId, $tagId))
			$responce['error']="Tag already added";
		else
			$responce=$questions->addtag($questionId, $tagId);
		
		return $responce;
	}
	public function removeTag($dataObj){
		$questionId=intval($dataObj->questionId);
		$tagId=intval($dataObj->tagId);
		$tags=new Categories();
		$questions=new Questions();
		$responce=array();
		if(!$tags->isValidCategoryId($tagId))
			$responce['error']="Invalid tag ID";
		elseif (!$questions->isValidQuestionId($questionId))
			$responce['error']="Invalid question ID";
		elseif (!$questions->hastag($questionId, $tagId))
			$responce['error']="Tag was never added";
		else
			$responce=$questions->removetag($questionId, $tagId);
		return $responce;
	}
	public function getTags($dataObj){
		$questionId=intval($dataObj->questionId);
		$questions=new Questions();
		$responce=array();
		if($questions->isValidQuestionId($questionId))
			$responce=$questions->getTags($questionId);
		else 
			$responce['error']="Invalid Question ID";
		return $responce;
	}
} 
?>