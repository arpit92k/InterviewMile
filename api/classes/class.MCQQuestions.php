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
	public function addQuestion($title,$description,$owner,$category_id=NULL){
		parent::addQuestion($title, $description,$category_id,true);
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
		return $this->link->executeInsertQuery();
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
		while($res=$qresult->fetch()){
			$result->append($res);
		}
		return $result;
	}
}
?>