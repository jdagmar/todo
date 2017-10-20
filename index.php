<?php
require 'PDO.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600|PT+Sans:400,400i,700" rel="stylesheet">
    <title>TODO</title>
</head>
<body>

<main>
<header> 
    <h1>What to do?</h1>
</header> 

<form class="input" action="addTask.php" method="POST">
    <input class="new-task" type="text" name="new-task" placeholder="Add a new task to the list"/>
    <input class="username" type="text" name="username" placeholder="and your name"/>
    <input class="add-task" type="image" src="images/add.svg">
</form>

<div class="tasks">
    <div class="unfinished">
        <h2 class="unfinished__header">Task's to do</h2> 
      
        <?php foreach (getUnfinishedTasks($pdo) as $i => $task): ?>
            <div class="unfinished__content"> 
                <div >
                    <span class="list-item"><?=  $task["title"]?></span>
                    <span class="added">added by </span>
                    <img class="user" src="images/user.svg"/>
                    <span class="list-item"><?= "" . $task['createdBy']?></span>
                </div>
                
                <div>
                    <a class="checkbox" href="checkOffTask.php?id=<?= $task["id"]?>">
                        <img class="checkbox" src="images/checkbox.svg"/>
                    </a>
                    <a class="delete-task" href="deleteTask.php?id=<?= $task["id"]?>">
                        <img class="delete" src="images/delete.svg"/>
                    </a> 
                </div>
            </div>
        <?php endforeach; ?> 
    </div>

    <div class="finished">
        <h2 class="finished__header">Finished task's</h2> 

        <?php foreach (getFinishedTasks($pdo) as $i => $task): ?>

        <div class="finished__content"> 
                <div>
                    <span class="list-item"><?=  $task["title"]?></span>
                    <span class="added">added by </span>
                    <img class="user" src="images/user.svg"/>
                    <span class="list-item"><?= "" . $task['createdBy']?></span>
                </div>
                
                <div>
                    <a class="undo-task" href="undoCheckOffTask.php?id=<?= $task["id"]?>">
                        <img src="images/check.svg"/>
                    </a>
                    <a class="delete-task" href="deleteTask.php?id=<?= $task["id"]?>">
                        <img src="images/delete.svg"/>
                    </a> 
                </div>
            </div>
        <div>
        <?php endforeach; ?>
    </div>
</div>
</main>
</body>
</html>