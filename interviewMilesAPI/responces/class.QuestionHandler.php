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
		if(property_exists($data, 'isMCQ'))
			$isMCQ=boolval($data->isMCQ);
		$categoryId=0;
		if(property_exists($data,'categoryID')){
			$categoryId=intval(UtilityFunctions::fix($data->categoryID));
			$cat=new Categories();
			if(!$cat->isValidCategoryId($categoryId)){
				$responce['error']='Invalid category ID';
				return $responce;
			}
		}
		$questions=new Questions();
		$responce=$questions->addQuestion($title, $description, UtilityFunctions::getLoggedinUser(),$isMCQ);
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
	public function addTag($postData){
		if(isset($postData['questionId'])&&isset($postData['tagId'])){
			$questionId=UtilityFunctions::fix($postData['questionId']);
			$tagId=UtilityFunctions::fix($postData['tagId']);
			$tags=new Categories();
			$questions=new Questions();
			if(!$tags->isValidCategoryId($tagId)){
				$responce['error']="Invalid tag ID";
				UtilityFunctions::sendResponce($responce);
			}
			elseif (!$questions->isValidQuestionId($questionId)){
				$responce['error']="Invalid question ID";
				UtilityFunctions::sendResponce($responce);
			}
			else{
				$responce=$questions->addtag($questionId, $tagId);
				UtilityFunctions::sendResponce($responce);
			}
		}
		else{
			UtilityFunctions::responceBadRequest();
		}
	}
	public function removeTag($postData){
		if (isset($postData['questionId'])&&isset($postData['tagId'])){
			$questionId=UtilityFunctions::fix($postData['questionId']);
			$tagId=UtilityFunctions::fix($postData['tagId']);
			$tags=new Categories();
			$questions=new Questions();
			if(!$tags->isValidCategoryId($tagId)){
				$responce['error']="Invalid tag ID";
				UtilityFunctions::sendResponce($responce);
			}
			elseif (!$questions->isValidQuestionId($questionId)){
				$responce['error']="Invalid question ID";
				UtilityFunctions::sendResponce($responce);
			}
			else{
				$responce=$questions->removetag($questionId, $tagId);
				UtilityFunctions::sendResponce($responce);
			}
		}
		else {
			UtilityFunctions::responceBadRequest();
		}
	}
	public function getTags($postData){
		if(isset($postData['questionId'])){
			$questionId=UtilityFunctions::fix($postData['questionId']);
			$questions=new Questions();
			if($questions->isValidQuestionId($questionId)){
				$responce=$questions->getTags($questionId);
				UtilityFunctions::sendResponce($responce);
			}
			else {
				$responce['error']="Invalid Question ID";
				UtilityFunctions::sendResponce($responce);
			}
		}
		else 
			UtilityFunctions::responceBadRequest();
	}
} 
?>