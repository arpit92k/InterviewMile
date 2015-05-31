<?php
session_start();
include_once 'classes/class.Database.php';
include_once 'classes/class.DatabaseConnection.php';
include_once 'classes/class.Questions.php';
include_once 'classes/class.MCQQuestions.php';
include_once 'classes/class.NonMCQQuestions.php';
include_once 'classes/class.Categories.php';
include_once 'responces/class.UtilityFunctions.php';
include_once 'responces/class.QuestionHandler.php';
function handleRequest(){
	if(isset($_GET['object'])){
		if(!isset($_GET['query'])){
			UtilityFunctions::responceBadRequest();
			return;
		}
		if($_GET['object']=="question"){
			$questions=new QuestionHandler();
			if($_GET['query']=="add"){
				if(UtilityFunctions::isLoggedIn())
					$questions->addQusestion($_POST);
				else
					UtilityFunctions::responceUnauthorised();
			}
			elseif ($_GET['query']=="get"){
				$questions->listQuestions($_POST);
			}
			else
				UtilityFunctions::responceBadRequest();
		}
		elseif ($_GET['object']=="answer"){
			$answer=new AnswerHandler();
			if($_GET['query']=="get"){
				$answer->getAnswers($_POST);
			}
			elseif($_GET['query']=="add"){
				if(UtilityFunctions::isLoggedIn())
					$answer->addAnswer($_POST);
				else 
					UtilityFunctions::responceUnauthorised();
			}
			else
				UtilityFunctions::responceBadRequest();
		}
		elseif ($_GET['object']=="category"){
			$categories=new CategoryHandler();
			if($_GET['query']=="add"){
				if($_SESSION['user']=="admin"){
					$categories->addCategory($_POST);
				}
				else
					UtilityFunctions::responceUnauthorised();
			}
			elseif ($_GET['query']=="get"){
				$categories->getCategories($postData);
			}
			else
				UtilityFunctions::responceBadRequest();
		}
		else
			UtilityFunctions::responceBadRequest();
	}
	else
		UtilityFunctions::responceBadRequest();
}
handleRequest();
?>