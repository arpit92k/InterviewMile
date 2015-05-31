<?php
class Database{
	private $link;
	private $connection;
	private $query;
	private $parms;
	public function __construct($db="interviewX"){
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
	public function executeQuery(){
		if($this->query->execute())
			return $this->query;
		else
			die("Something gone wrong".print_r($this->query->errorInfo()));
	}
	public function __destruct(){
		$this->link->closeConnection();
	}
}
?>