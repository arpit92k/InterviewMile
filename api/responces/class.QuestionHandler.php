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
			$categoryId=null;
			$isMCQ=false;
			if(isset($postData['categoryId'])){
				$categoryId=intval(UtilityFunctions::fix($postData['categoryId']));
				$categories=new Categories();
				if(!$categories->isValidCategoryId($categoryId)){
					$responce['error']="Invalid Category Id";
					UtilityFunctions::sendResponce($responce);
					return;
				}
			}
			if(isset($postData['isMCQ']))
				$isMCQ=true;
			$questions=new Questions();
			$responce=$questions->addQuestion($title, $description,$_SESSION['user']);
			UtilityFunctions::sendResponce($responce);
		}
		else
			UtilityFunctions::responceBadRequest();
	}
} 
?>