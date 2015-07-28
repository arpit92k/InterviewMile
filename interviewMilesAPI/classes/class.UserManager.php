<?php
class UserManager{
	private $link;
	public function __construct(){
		$this->link=new Database();
	}
	public function login($email,$password){
		$email=UtilityFunctions::fix($email);
		$password=md5(UtilityFunctions::fix($password));
		$this->link->setQuery("SELECT password FROM users WHERE email=?");
		$this->link->bindParms(array($email));
		$qresult=$this->link->executeSelectQuery();
		$result=array();
		if($qresult->rowCount()==1){
			$pwd=$qresult->fetch();
			$pwd=$pwd['password'];
			if($password==$pwd){
				$_SESSION['email']=$email;
				return $result['result']="success";
			}
		}
		return $result['result']="failure";
	}
	public function logout() {
		session_destroy();
		$result=array();
		$result['result']='logout sucessfull';
		return $result;
	}
	public function register($name,$email,$password){
		$name=UtilityFunctions::fix($name);
		$email=UtilityFunctions::fix($email);
		$password=md5(UtilityFunctions::fix($password));
		if($email==''||$password==''||$name=='')
			return $result['error']='All values required';
		$result=array();
		$this->link->setQuery("SELECT * FROM users WHERE email=?");
		$this->link->bindParms(array($email));
		$qresult=$this->link->executeSelectQuery();
		if($qresult->rowCount()>0)
			return $result['error']='Duplicate email';
		$this->link->setQuery("INSERT INTO users(`name`,`email`,`password`) values(?,?,?)");
		$this->link->bindParms(array($name,$email,$password));
		$id=$this->link->executeInsertQuery();
		$id=intval($id);
		$result['userId']=$id;
		return $result;
	}
}
?>