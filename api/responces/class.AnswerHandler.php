<?php
class AnswerHandler{
	public function addAnswer($postData){
		if(isset($postData['questionId']) && isset($postData['answer'])){
			$nonMcqQuestion=new NonMCQQuestions();
			$questionId=intval(UtilityFunctions::fix($postData['questionId']));
			if($nonMcqQuestion->isValidQuestionId($questionId)&&(!$nonMcqQuestion->isMCQ($questionId))){
				$answer=UtilityFunctions::fix($postData['answer']);
				$owner=UtilityFunctions::getLoggedinUser();
				$result=$nonMcqQuestion->addAnswer($questionId, $answer, $owner);
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
	public function getAnswers($postData){
		if(isset($postData['questionId'])){
			$question=new NonMCQQuestions();
			$questionId=UtilityFunctions::fix($postData['questionId']);
			if($question->isValidQuestionId($questionId)&&(!$question->isMCQ($questionId))){
				$start=0;
				if(isset($postData['start']))
					$start=intval(UtilityFunctions::fix($postData['start']));
				$question=new NonMCQQuestions();
				$responce=$question->getAnswers($questionId,$start);
				UtilityFunctions::sendResponce($responce);
			}
			else{
				$responce['error']="Invalid Question ID";
				UtilityFunctions::sendResponce($responce);
			}
		}
		else
			UtilityFunctions::responceBadRequest();
	}
}
?>