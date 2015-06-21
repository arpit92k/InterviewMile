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
	public function listQuestions($postData){
		$start=0;
		if(isset($postData['start'])){
			$start=intval(UtilityFunctions::fix($postData['start']));
		}
		$questions=new Questions();
		$responce=$questions->getQuestions($start);
		UtilityFunctions::sendResponce($responce);
	}
	/**
	 * 
	 * @param Array $postData
	 */
	public function addQusestion($postData){
		if(isset($postData['title'])&&isset($postData['description'])){
			$title=UtilityFunctions::fix($postData['title']);
			$description=UtilityFunctions::fix($postData['description']);
			$isMCQ=false;
			if(isset($postData['isMCQ']))
				$isMCQ=true;
			$questions=new Questions();
			$responce=$questions->addQuestion($title, $description, UtilityFunctions::getLoggedinUser(),$isMCQ);
			UtilityFunctions::sendResponce($responce);
		}
		else
			UtilityFunctions::responceBadRequest();
	}
	public function findQuestions($postData){
		if(isset($postData['title'])){
			$title=UtilityFunctions::fix($postData['title']);
			$questions=new Questions();
			$responce=$questions->searchQuestions($title);
			UtilityFunctions::sendResponce($responce);
		}
		else
			UtilityFunctions::responceBadRequest();
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