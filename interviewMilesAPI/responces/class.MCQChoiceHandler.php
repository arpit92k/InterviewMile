<?php
class MCQChoiceHandler{
	public function addChoice($postData){
		$mcqQuestions=new MCQQuestions();
		$questionId=intval(UtilityFunctions::fix($postData->questionId));
		if($mcqQuestions->isValidQuestionId($questionId)&&$mcqQuestions->isMCQ($questionId)){
			$choice=UtilityFunctions::fix($postData->choice);
			$isCorrect=false;
			if(property_exists($postData,'isCorrect')&&is_bool($postData->isCorrect))
				$isCorrect=$postData->isCorrect;
			$owner=UtilityFunctions::getLoggedinUser();
			$result=$mcqQuestions->addChoice($questionId, $choice, $owner, $isCorrect);
			return $result;
		}
		else {
			$responce['error']="Invalid Question ID";
			return $responce;
		}
	}
	public function getChoices($postData){
		$mcqQuestions=new MCQQuestions();
		$questionId=intval(UtilityFunctions::fix($postData->questionId));
		if($mcqQuestions->isValidQuestionId($questionId) && $mcqQuestions->isMCQ($questionId)){
			$start=0;
			if(property_exists($postData,'start'))
				$start=intval($postData->start);
			$responce=$mcqQuestions->getChoices($questionId,$start);
			return $responce;
		}
		else {
			$responce['error']="Invalid Question ID";
			return $responce;
		}
	}
}
?>