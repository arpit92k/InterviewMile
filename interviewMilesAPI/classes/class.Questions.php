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
	public function addQuestion($title,$description,$owner,$isMCQ=FALSE){
		$this->link->setQuery("INSERT INTO questions (`isMCQ`,`title`,`description`,`owner`) VALUES (?,?,?,?)");
		$this->link->bindParms(array($isMCQ,$title,$description,$owner));
		$id=$this->link->executeInsertQuery();
		$responce['questionId']=$id;
		return $responce;
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
		$responce=array();
		while($res=$qresult->fetch()){
			$result=array();
			$result['questionId']=intval($res['questionId']);
			//$result['categoryId']=intval($res['categoryId']);
			$result['isMCQ']=intval($res['isMCQ'])?true:false;
			$result['title']=$res['title'];
			$result['description']=$res['description'];
			$result['owner']=intval($res['owner']);
			array_push($responce,$result);
		}
		return $responce;
	}
	public function getQuestionsById($questionId){
		$result=new ArrayObject();
		$this->link->setQuery("SELECT * FROM questions WHERE questionId = ?");
		$this->link->bindParms(array($questionId));
		$qresult=$this->link->executeSelectQuery();
		$res=$qresult->fetch();
		$result=array();
		$result['questionId']=intval($res['questionId']);
		//$result['categoryId']=intval($res['categoryId']);
		$result['isMCQ']=intval($res['isMCQ'])?true:false;
		$result['title']=$res['title'];
		$result['description']=$res['description'];
		$result['owner']=intval($res['owner']);
		return $result;
	}
	public function getQuestionsByCategory($categoryId,$start=0){
		$result=new ArrayObject();
		$this->link->setQuery("SELECT * FROM questions WHERE questionId in(SELECT questionId FROM `questionCategory` WHERE categoryId=?) LIMIT $start,10");
		$this->link->bindParms(array($categoryId));
		$qresult=$this->link->executeSelectQuery();
		$responce=array();
		while($res=$qresult->fetch()){
			$result=array();
			$result['questionId']=intval($res['questionId']);
			$result['isMCQ']=intval($res['isMCQ'])?true:false;
			$result['title']=$res['title'];
			$result['description']=$res['description'];
			$result['owner']=intval($res['owner']);
			array_push($responce,$result);
		}
		return $responce;
	}
	public function searchQuestions($title,$start=0){
		$result=new ArrayObject();
		$this->link->setQuery("SELECT * FROM questions where title LIKE ? LIMIT $start,10");
		$this->link->bindParms(array("%".$title."%"));
		$qresult=$this->link->executeSelectQuery();
		$responce=array();
		while($res=$qresult->fetch()){
			$result=array();
			$result['questionId']=intval($res['questionId']);
			//$result['categoryId']=intval($res['categoryId']);
			$result['isMCQ']=intval($res['isMCQ'])?true:false;
			$result['title']=$res['title'];
			$result['description']=$res['description'];
			$result['owner']=intval($res['owner']);
			array_push($responce,$result);
		}
		return $responce;
	}
	public function hastag($questionId,$tagId){
		$this->link->setQuery("SELECT * FROM questionCategory where questionId=? and categoryId=?");
		$this->link->bindParms(array($questionId,$tagId));
		$qresult=$this->link->executeSelectQuery();
		if($qresult->rowCount()>0)
			return true;
		return false;
	}
	public function addtag($questionId,$tagId){
		$this->link->setQuery("INSERT INTO questionCategory(`questionId`,`categoryId`) VALUES(?,?)");
		$this->link->bindParms(array($questionId,$tagId));
		$this->link->executeInsertQuery();
		$responce['result']="success";
		return $responce;
	}
	public function removetag($questionId,$tagId){
		$this->link->setQuery("DELETE FROM questionCategory WHERE questionId=? AND categoryId=?");
		$this->link->bindParms(array($questionId,$tagId));
		$this->link->executeDeleteQuery();
		$responce['result']="success";
		return $responce;
	}
	public function getTags($questionId){
		$this->link->setQuery("SELECT * FROM questionCategory where questionId=?");
		$this->link->bindParms(array($questionId));
		$qresult=$this->link->executeSelectQuery();
		$responce=array();
		while($res=$qresult->fetch()){
			$result=array();
			$result['questionId']=intval($res['questionId']);
			$result['tagId']=intval($res['categoryId']);
			$result['tag']=$this->getTagName($result['tagId']);
			array_push($responce,$result);
		}
		return $responce;
	}
	private function getTagName($tagId){
		$this->link->setQuery("SELECT * from categories WHERE categoryId=?");
		$this->link->bindParms(array($tagId));
		$qresult=$this->link->executeSelectQuery();
		if($qresult->rowCount()>0){
			$result=$qresult->fetch();
			return $result['category'];
		}
		return null;
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