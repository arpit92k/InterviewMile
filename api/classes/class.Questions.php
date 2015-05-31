<?php
/**
 * Questions
*
* @package    classes
* @subpackage
* @author     Arpit <arpit92k@gmail.com>
*/
class Questions{
	protected $link;
	/**
	 * constructor
	 */
	public function __construct(){
		$this->link=new Database();
	}
	/**
	 *
	 * @param string $title
	 * @param string $description
	 * @param integer $category_id
	 * @return string id of inserted category
	 */
	public function addQuestion($title,$description,$owner,$category_id=NULL,$isMCQ=FALSE){
		$this->link->setQuery("INSERT INTO questions (`categoryId`,`isMCQ`,`title`,`description`,`owner`) VALUES (?,?,?,?,?)");
		$this->link->bindParms(array($category_id,$isMCQ,$title,$description,$owner));
		$result=$this->link->executeInsertQuery();
	}
	/**
	 *
	 * @param number $start
	 * @return ArrayObject contining 10 question staring from $start
	 */
	public function getQuestions($start=0){
		$result=new ArrayObject();
		$this->link->setQuery("SELECT * FROM questions LIMIT $start,10");
		$qresult=$this->link->executeSelectQuery();
		while($res=$qresult->fetch()){
			$result->append($res);
		}
		return $result;
	}
	public function isValidQuestionId($questionId){
		$this->link->setQuery("SELECT * FROM questions WHERE questionId=?");
		$this->link->bindParms(array($questionId));
		$result=$this->link->executeSelectQuery();
		if($result->rowCount())
			return true;
		return false;
	}
	public function isMCQ($questionId){
		$this->link->setQuery("SELECT `isMCQ` FROM questions WHERE questionId=?");
		$this->link->bindParms(array($questionId));
		$result=$this->link->executeSelectQuery();
		if($result->rowCount()){
			$result=$result->fetch();
			$result=intval($result['isMCQ']);
			if($result)
				return true;
		}
		return false;
	}
}
?>