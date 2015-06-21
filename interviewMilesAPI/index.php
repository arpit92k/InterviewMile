<?php
include_once 'classes/class.API.php';
include_once 'classes/class.APIEndpoints.php';
include_once 'classes/class.Database.php';
include_once 'classes/class.DatabaseConnection.php';
include_once 'classes/class.Categories.php';
include_once 'classes/class.Questions.php';
include_once 'classes/class.MCQQuestions.php';
include_once 'classes/class.NonMCQQuestions.php';
include_once 'responces/class.AnswerHandler.php';
include_once 'responces/class.CategoryHandler.php';
include_once 'responces/class.QuestionHandler.php';
include_once 'responces/class.UtilityFunctions.php';

$api=new APIEndpoints($_REQUEST['request']);

//$postdata = file_get_contents("php://input");
//$obj=json_decode($postdata);
?>