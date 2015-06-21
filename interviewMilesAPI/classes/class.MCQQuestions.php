<?php
/**
 * 
 * @author arpit
 *
 */
class MCQQuestions extends Questions{
	/**
	 * addQuestion
	 * adds a MCQ questions to database
	 *
	 * @param string $title
	 * @param string $description
	 * @param integer $category_id
	 * @return string id of inserted category
	 */
	public function addQuestion($title,$description,$owner){
		parent::addQuestion($title, $description,$owner,true);
	}
	/**
	 * 
	 * @param integer $questionID
	 * @param string $choice
	 * @param boolean $isCorrect
	 * @return integer id of insterted value
	 */
	public function addChoice($questionID,$choice,$owner,$isCorrect=false){
		$this->link->setQuery("INSERT INTO mcqChoices(`questionId`,`choice`,`isCorrect`,`owner`) VALUES(?,?,?,?)");
		$this->link->bindParms(array($questionID,$choice,$isCorrect,$owner));
		$responce['optionId']=$this->link->executeInsertQuery();
		return $responce;
	}
	/**
	 * 
	 * @param int $questionId
	 * @return array containing choices of given question 
	 */
	public function getChoices($questionId){
		$this->link->setQuery("SELECT * FROM mcqChoices WHERE questionId=?");
		$this->link->bindParms(array($questionId));
		$qresult=$this->link->executeSelectQuery();
		$responce=array();
		while($res=$qresult->fetch()){
			$result=array();
			$result['optionId']=intval($res['optionId']);
			$result['questionId']=intval($res['questionId']);
			$result['choice']=$res['choice'];
			$result['isCorrect']=intval($res['isCorrect'])?true:false;
			$result['owner']=intval($res['owner']);
			array_push($responce,$result);
		}
		return $responce;
	}
}
?>