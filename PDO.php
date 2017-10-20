<?php
$pdo = new PDO (
    "mysql:host=localhost;dbname=todo;charset=utf8",
    "root",
    "root"
);

 
function getUnfinishedTasks($pdo){
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE completed = false");  
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    return $tasks;
}

function getFinishedTasks($pdo){
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE completed = true");  
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $tasks; 
}

function addTask($pdo, $title, $createdBy){
    $stmt = $pdo->prepare("INSERT INTO tasks (title, createdBy) VALUES (:title, :createdBy)");  
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":createdBy", $createdBy);    
    $stmt->execute();
}

function deleteTask($pdo, $id){
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");  
    $stmt->bindParam(":id", $id);
    $stmt->execute();
}

function checkOffTask($pdo, $id) {
    $stmt = $pdo->prepare("UPDATE tasks SET completed = true WHERE id = :id"); 
    $stmt->bindParam(":id", $id);
    $stmt->execute();
}

function undoCheckOffTask($pdo, $id){
    $stmt = $pdo->prepare("UPDATE tasks SET completed = false WHERE id = :id"); 
    $stmt->bindParam(":id", $id);
    $stmt->execute();
}


 
  
