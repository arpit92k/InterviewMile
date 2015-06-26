<?php
class AnswerHandler{
	public function addAnswer($data){
		$nonMcqQuestion=new NonMCQQuestions();
		$questionId=intval(UtilityFunctions::fix($data->questionId));
		if($nonMcqQuestion->isValidQuestionId($questionId)&&(!$nonMcqQuestion->isMCQ($questionId))){
			$answer=UtilityFunctions::fix($data->answer);
			$owner=UtilityFunctions::getLoggedinUser();
			$result=$nonMcqQuestion->addAnswer($questionId, $answer, $owner);
			return $result;
		}
		else {
			$responce['error']="Invalid Question ID";
			return $responce;
		}
	}
	public function getAnswers($data){
		$questionId=intval(UtilityFunctions::fix($data->questionId));		
		$question=new NonMCQQuestions();
		if($question->isValidQuestionId($questionId)&&(!$question->isMCQ($questionId))){
			$start=0;
			if(property_exists($data,'start'))
				$start=intval(UtilityFunctions::fix($data->start));
			$question=new NonMCQQuestions();
			$responce=$question->getAnswers($questionId,$start);
			return $responce;
		}
		else{
			$responce['error']="Invalid Question ID";
			return $responce;
		}
		
	}
}
?>