<?php
$pdo = new PDO (
    "mysql:host=localhost;dbname=todo;charset=utf8",
    "root",
    "root"
);

function getUnfinishedTasks($pdo, $orderByPriority, $ascending){
    $stmt = null;
    $asc = "DESC";

    if ($ascending) {
        $asc = "ASC";
    }

    if ($orderByPriority){
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE completed = false ORDER BY priority $asc, created $asc");
    }

    else {
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE completed = false ORDER BY created $asc");  
    }

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

function isTitleUniqe($pdo, $title){
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE title = :title");  
    $stmt->bindParam(":title", $title);
    $stmt->execute();   
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($tasks) == 0) {
        return true;
    } else {
        return false;
    }
    
}

function deleteTask($pdo, $id){
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");  
    $stmt->bindParam(":id", $id);
    $stmt->execute();
}

function deleteAllUnfinishedTasks($pdo){
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE completed = false");  
    $stmt->execute();
}

function deleteAllFinishedTasks($pdo){
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE completed = true");  
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

function setPriority($pdo, $id){
    $stmt = $pdo->prepare("UPDATE tasks SET priority = true WHERE id = :id"); 
    $stmt->bindParam(":id", $id);
    $stmt->execute();
}

function undoPriority($pdo, $id) {
    $stmt = $pdo->prepare("UPDATE tasks SET priority = false WHERE id = :id"); 
    $stmt->bindParam(":id", $id);
    $stmt->execute();
}

function saveChanges($pdo, $title, $id){
    $stmt = $pdo->prepare("UPDATE tasks SET title = :title WHERE id = :id"); 
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
}