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
include_once 'responces/class.AnswerHandler.php';
include_once 'responces/class.CategoryHandler.php';
include_once 'responces/MCQChoiceHandler.php';
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
			elseif ($_GET['query']=="find"){
				$questions->findQuestions($_POST);
			}
			else{
				UtilityFunctions::responceBadRequest();
			}
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
		elseif ($_GET['object']=="choice"){
			$choice=new MCQChoiceHandler();
			if ($_GET['query']=="get")
				$choice->getChoices($_POST);
			elseif ($_GET['query']=="add"){
				if (UtilityFunctions::isLoggedIn())
					$choice->addChoice($_POST);
				else 
					UtilityFunctions::responceUnauthorised();
			}
			else
				UtilityFunctions::responceBadRequest();
		}
		elseif ($_GET['object']=="category"){
			$categories=new CategoryHandler();
			if($_GET['query']=="add"){
				if(UtilityFunctions::getLoggedinUser()==1){
					$categories->addCategory($_POST);
				}
				else
					UtilityFunctions::responceUnauthorised();
			}
			elseif ($_GET['query']=="get"){
				$categories->getCategories($_POST);
			}
			elseif ($_GET['query']=="find"){
				$categories->findCategories($_POST);
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