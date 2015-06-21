<?php
class UtilityFunctions{
	public static function sendResponce($responce){
		header('Content-Type: application/json');
		echo json_encode($responce);
	}
	public static function  fix($data){
		return htmlentities(trim($data));
	}
	public static function responceBadRequest(){
		$responce['error']="Bad Request";
		UtilityFunctions::sendResponce($responce);
	}
	public static function responceUnauthorised(){
		$responce['error']="Unauthorized operation";
		UtilityFunctions::sendResponce($responce);
	}
	public static function isLoggedIn(){
		return true;
		//return isset($_SESSION['userId']);
	}
	public static function getLoggedinUser(){
		//return $_SESSION['userId'];
		return 1;
	}
}
?>