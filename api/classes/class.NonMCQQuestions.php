<?php
/**
   * NonMCQQuestions
   * 
   * @package    classes
   * @subpackage 
   * @author     Arpit <arpit92k@gmail.com>
   */
class NonMCQQuestions extends Questions{
	/**
	 * addQuestion
	 * adds a nonMCQ questions to database
	 *
	 * @param string $title  
	 * @param string $description
	 * @param integer $category_id  
	 * @return string id of inserted category
	 */
	public function addQuestion($title,$description,$owner,$category_id=NULL){
		return parent::addQuestion($title, $description,$owner,$category_id);
	}
	/**
	 * 
	 * @param integer $qusestionId
	 * @param string $answer
	 * @return integer id of inserted answer 
	 */
	public function addAnswer($qusestionId,$answer,$owner){
		$this->link->setQuery("INSERT INTO answers (`questionId`,`answer`,`owner`) VALUES(?,?,?)");
		$this->link->bindParms(array($qid,$ans,$owner));
		return $this->link->executeInsertQuery();
	}
	/**
	 * 
	 * @param integer $qusestionId
	 * @param integer $start
	 * @return ArrayObject array containing 10 answers of given Question starting from $start
	 */
	public function getAnswers($qusestionId,$start=0){
		$result=new ArrayObject();
		$this->link->setQuery("SELECT * FROM answers WHERE qid=? LIMIT $start,10");
		$this->link->bindParms(array($qid));
		$qresult=$this->link->executeSelectQuery();
		while($res=$qresult->fetch()){
			$result->append($res);
		}
		return $result;
	}
} 
?>