<?php
include_once 'classes/class.database.php';
include_once 'classes/class.databaseConnection.php';
$database=new Database();
$database->setQuery("INSERT INTO categories(`category`) VALUES (?)");
$database->bindParms(array("base category"));
print_r($database->executeInsertQuery());
echo "aks";
?>