<?php
session_start();
require '../database/PDO.php';
require '../database/functions.php';

//checks if the user has put in required data, if no the task will not be added
$errorMissingName = false;
$errorMissingTask = false;

if (empty($_POST["username"])){
    $errorMissingName = true;
}

if (empty($_POST["new-task"])){
    $errorMissingTask = true;
}

$submitErrors = $errorMissingName || $errorMissingTask;
$_SESSION["formData"] = $_POST;
$_SESSION["titleIsNotUniqe"] = false;

if (!$submitErrors){

    //if input data is sufficient the task is added
    if (isTitleUniqe($pdo, $_POST["new-task"])){
        addTask($pdo, $_POST["new-task"], $_POST["username"]);
        $_SESSION["taskAdded"] = true;
        unset($_SESSION["formData"]);
    } else {
        $_SESSION["titleIsNotUniqe"] = true;
    }
} 

$_SESSION["errorMissingName"] = $errorMissingName;
$_SESSION["errorMissingTask"] = $errorMissingTask;
$_SESSION["submitErrors"] = $submitErrors;

header("Location: ..");
exit();