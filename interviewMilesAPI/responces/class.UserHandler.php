<?php
class UserHandler{
	function login($dataObj){
		$email=UtilityFunctions::fix($dataObj->email);
		$password=UtilityFunctions::fix($dataObj->password);
		$userManager=new UserManager();
		return $userManager->login($email, $password);
	}
	function register($dataObj) {
		$name=UtilityFunctions::fix($dataObj->name);
		$email=UtilityFunctions::fix($dataObj->email);
		$password=UtilityFunctions::fix($dataObj->password);
		$userManager=new UserManager();
		return $userManager->register($name, $email, $password);
	}
	function logout() {
		$userManager=new UserManager();
		return $userManager->logout();
	}
}