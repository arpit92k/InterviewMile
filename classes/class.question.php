<?php
class Question{
	private $link;
	public function __construct(){
		$this->link=new Database();
	}
	public function addQuestion($qsn){
		$this->link->setQuery("insert into questions (`qsn`) values (?)");
		$this->link->bindParms(array($qsn));
		$this->link->executeQuery();
		return 0;
	}
	public function getQuestions($start=0){
		$result=new ArrayObject();
		$this->link->setQuery("select * from questions limit $start,10");
		$qresult=$this->link->executeQuery();
		while($res=$qresult->fetch()){
			$result->append($res);
		}
		return $result;
	}
	public function addAnswer($qid,$ans){
		$this->link->setQuery("insert into answers (`qid`,`answer`) values(?,?)");
		$ans=array($qid,$ans);
		$this->link->bindParms($ans);
		$this->link->executeQuery();
	}
	public function getAnswers($qid,$start=0){
		$result=new ArrayObject();
		$this->link->setQuery("select * from answers where qid=? limit $start,10");
		$this->link->bindParms(array($qid));
		$qresult=$this->link->executeQuery();
		while($res=$qresult->fetch()){
			$result->append($res);
		}
		return $result;
	}
	public function addExplanation($qid,$ex){
		$this->link->setQuery("insert into explanations (`qid`,`explanation`) values(?,?)");
		$exp=array($qid,$ex);
		$this->link->bindParms($exp);
		$this->link->executeQuery();
	}
	public function getExplanation($qid,$start=0){
		$result=new ArrayObject();
		$this->link->setQuery("select * from explanations where qid=? limit $start,10");
		$this->link->bindParms(array($qid));
		$qresult=$this->link->executeQuery();
		while($res=$qresult->fetch()){
			$result->append($res);
		}
		return $result;
	}
	public function addComment($qid,$comment,$pcid=0){
		$this->link->setQuery("insert into comments (`qid`,`pcid`,`comment`) values(?,?,?)");
		$comment=array($qid,$pcid,$comment);
		$this->link->bindParms($comment);
		$this->link->executeQuery();
	}
	public function getComments($qid,$pcid=0,$start=0){
		$result=new ArrayObject();
		$this->link->setQuery("select * from comments where qid=? and pcid=? limit $start,10");
		$comment=array($qid,$pcid);
		$this->link->bindParms($comment);
		$qresult=$this->link->executeQuery();
		while($res=$qresult->fetch()){
			$result->append($res);
		}
		return $result;
	}
} 
?>