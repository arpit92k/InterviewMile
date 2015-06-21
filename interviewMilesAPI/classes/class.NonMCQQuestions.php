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
	public function addQuestion($title,$description,$owner){
		return parent::addQuestion($title, $description,$owner);
	}
	/**
	 * 
	 * @param integer $qusestionId
	 * @param string $answer
	 * @return integer id of inserted answer 
	 */
	public function addAnswer($questionId,$answer,$owner){
		$this->link->setQuery("INSERT INTO answers (`questionId`,`answer`,`owner`) VALUES(?,?,?)");
		$this->link->bindParms(array($questionId,$answer,$owner));
		$responce['answerId']=$this->link->executeInsertQuery();
		return $responce;
	}
	/**
	 * 
	 * @param integer $qusestionId
	 * @param integer $start
	 * @return ArrayObject array containing 10 answers of given Question starting from $start
	 */
	public function getAnswers($qusestionId,$start=0){
		$result=new ArrayObject();
		$this->link->setQuery("SELECT * FROM answers WHERE questionId=? LIMIT $start,10");
		$this->link->bindParms(array($qusestionId));
		$qresult=$this->link->executeSelectQuery();
		$responce=array();
		while($res=$qresult->fetch()){
			$result=array();
			$result['answerId']=intval($res['answerId']);
			$result['questionId']=intval($res['questionId']);
			$result['answer']=$res['answer'];
			$result['owner']=intval($res['owner']);
			array_push($responce,$result);
		}
		return $responce;
	}
} 
?>