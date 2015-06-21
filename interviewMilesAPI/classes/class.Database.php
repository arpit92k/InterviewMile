<?php
class Database{
	private $link;
	private $connection;
	private $query;
	private $parms;
	public function __construct($db="InterviewMile"){
		$this->link=new DatabaseConnection($db);
		$this->connection=$this->link->getConnection();
	}
	public function setQuery($qry){
		$this->query=$this->connection->prepare($qry);
	}
	public function bindParms($args){
		$this->parms=$args;
		$numParm=count($this->parms);
		$i=1;
		while($i<=$numParm){
			$this->query->bindParam($i,$this->parms[$i-1]);
			$i++;
		}
	}
	public function executeSelectQuery(){
		if($this->query->execute())
			return $this->query;
		else
			die("Something gone wrong".print_r($this->query->errorInfo()));
	}
	public function executeInsertQuery(){
		$id=null;
		try {
			$this->connection->beginTransaction();
			$this->query->execute()or die(print_r($this->query->errorInfo()));
			$id=$this->connection->lastInsertId();
			$this->connection->commit();
		} catch(PDOExecption $e) {
			$this->connection->rollBack();
			die( "Something gone wrong :" . $e->getMessage() . "</br>");
		}
		return intval($id);
	}
	public function executeDeleteQuery(){
		$id=null;
		try {
			$this->connection->beginTransaction();
			$this->query->execute()or die(print_r($this->query->errorInfo()));
			$this->connection->commit();
		} catch(PDOExecption $e) {
			$this->connection->rollBack();
			die( "Something gone wrong :" . $e->getMessage() . "</br>");
		}
	}
	public function __destruct(){
		$this->link->closeConnection();
	}
}
?>