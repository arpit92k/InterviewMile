<?php
class MCQChoiceHandler{
	public function addChoice($postData){
		if(isset($postData['questionId'])&&isset($postData['choice'])){
			$mcqQuestions=new MCQQuestions();
			$questionId=intval(UtilityFunctions::fix($postData['questionId']));
			if($mcqQuestions->isValidQuestionId($questionId)&&$mcqQuestions->isMCQ($questionId)){
				$choice=UtilityFunctions::fix($postData['choice']);
				$isCorrect=false;
				if(isset($postData['isCorrect']))
					$isCorrect=true;
				$owner=UtilityFunctions::getLoggedinUser();
				$result=$mcqQuestions->addChoice($questionId, $choice, $owner, $isCorrect);
				UtilityFunctions::sendResponce($result);
			}
			else {
				$responce['error']="Invalid Question ID";
				UtilityFunctions::sendResponce($responce);
			}
		}
		else
			UtilityFunctions::responceBadRequest();
	}
	public function getChoices($postData){
		if(isset($postData['questionId'])){
			$mcqQuestions=new MCQQuestions();
			$questionId=intval(UtilityFunctions::fix($postData['questionId']));
			if($mcqQuestions->isValidQuestionId($questionId) && $mcqQuestions->isMCQ($questionId)){
				$responce=$mcqQuestions->getChoices($questionId);
				UtilityFunctions::sendResponce($responce);
				return;
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