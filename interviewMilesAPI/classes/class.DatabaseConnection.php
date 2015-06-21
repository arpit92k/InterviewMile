<?php
class DatabaseConnection{
	private $host;
	private $user;
	private $pass;
	private $db;
	private $link;
	public function __construct( $database="interviewX") {
		$this->db=$database;
		$this->link=NULL;
		$this->host="localhost";
		$this->user="interviewX";
		$this->pass="YFuLjZuBTJq4ZVYZ";
	}
	public function getConnection(){
		if($this->link)
			return $this->link;
		try{
			$this->link = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass,array(PDO::ATTR_PERSISTENT => true));
		}catch (PDOException $e) {
			die("Error!: ".$e->getMessage()."<br/>");
		}
		return $this->link;
	}
	public function closeConnection(){
		if($this->link!=NULL){
			$this->link->query('SELECT pg_terminate_backend(pg_backend_pid());');
			$this->link = NULL;
		}
	}
	public function __destruct(){
		if($this->link!=NULL)
		$this->closeConnection();
	}
}
?>
