<?php
class AnswerHandler{
	public function addAnswer($postData){
		if(isset($postData['type'])){
			if($postData['type']=="MCQ"&&isset($postData['questionId'])&&isset($postData['choice'])){
				$mcqQuestions=new MCQQuestions();
				$questionId=intval(UtilityFunctions::fix($postData['questionId']));
				if($mcqQuestions->isValidQuestionId($questionId)&&$mcqQuestions->isMCQ($questionId)){
					$choice=UtilityFunctions::fix($postData['choice']);
					$isCorrect=false;
					if(isset($postData['isCorrect']))
						$isCorrect=true;
					$owner=UtilityFunctions::getLoggedinUser();
					$result=$mcqQuestions->addChoice($questionID, $choice, $owner, $isCorrect);
					UtilityFunctions::sendResponce($result);
					return;
				}
			}
			else if($postData['type']=="nonMCQ"&&isset($postData['answer'])){
				$nonMcqQuestion=new NonMCQQuestions();
				$questionId=intval(UtilityFunctions::fix($postData['questionId']));
				if($nonMcqQuestion->isValidQuestionId($questionId)&&(!$nonMcqQuestion->isMCQ($questionId))){
					$answer=UtilityFunctions::fix($postData['answer']);
					$owner=UtilityFunctions::getLoggedinUser();
					$result=$nonMcqQuestion->addAnswer($qusestionId, $answer, $owner);
					UtilityFunctions::sendResponce($result);
					return;
				}
			}
		}
		UtilityFunctions::responceBadRequest();
	}
	public function getAnswers($postData){
		if(isset($postData['questionId'])){
			$question=new Questions();
			$questionId=UtilityFunctions::fix($postData['questionId']);
			if($question->isValidQuestionId($questionId)){
				if($question->isMCQ($questionId)){
					$question=new MCQQuestions();
					$result=$question->getChoices($questionId);
					UtilityFunctions::sendResponce($result);
					return;
				}
				$start=0;
				if(isset($postData['start']))
					$start=intval(UtilityFunctions::fix($postData['start']));
				$question=new NonMCQQuestions();
				$responce=$question->getAnswers($qusestionId,$start);
				UtilityFunctions::sendResponce($responce);
				return;
			}
		}
		UtilityFunctions::responceBadRequest();
	}
}
?>