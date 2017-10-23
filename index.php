<?php
session_start();
require 'PDO.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$orderByPriority = isset($_GET["sortByPriority"]);
$ascending = isset($_GET["asc"]);

$newTask = false;

if (isset($_SESSION["taskAdded"])){
    $newTask = true;
    unset($_SESSION["taskAdded"]);
}

require 'head.html';
require 'header.html';
require 'messages.php';
?>

<form class="input" action="addTask.php" method="POST">
    <input class="new-task" type="text" name="new-task" value="<?= $_SESSION['formData']['new-task'] ?? '' ?>" placeholder="Add a new task to the list"/>
    <input class="username" type="text" name="username" value="" placeholder="and your name"/>
    <input class="add-task" type="image" src="images/add.svg">
    <input type="hidden" name="submit"/>
</form>

<div class="tips-msg">
    <p>In a hurry? Set high priority by pressing the <img class="set-priority" src="images/set-high-priority.svg"/> icon.</p>
    <p>OOPS! Ff you accidently check off a task, press the  <img class="checked" src="images/check.svg"/> to undo the task!</p>  
</div>

<div class="tasks">
    <div class="unfinished">
        <h2 class="unfinished__header">Task's to do</h2>      
        <?php foreach (getUnfinishedTasks($pdo, $orderByPriority, $ascending) as $i => $task): ?>
            <div class="unfinished__content"> 
            
                <div class="priority">
                <?php if($task["priority"]): ?>
                    <a class="high-priority-icon" href="undoPriority.php?id=<?= $task["id"]?>">
                        <img class="high-priority-icon" src="images/high-priority.svg"/>
                    </a>   
                <?php else: ?>
                    <a class="low-priority-icon" href="setPriority.php?id=<?= $task["id"]?>">
                        <img class="low-priority-icon" src="images/set-high-priority.svg"/>
                    </a>
                <?php endif;?>
                </div>
            
                <div class="title-container">
                    <div class="title">
                        <span class="list-item"><?=  $task["title"]?></span>
                        <span class="added">added by </span>
                        <img class="user" src="images/user.svg"/>
                        <span class="list-item"><?= "" . $task['createdBy']?></span>
                    </div>
                </div>

                <div class="manage-task">
                    <a class="checkbox" href="checkOffTask.php?id=<?= $task["id"]?>">
                        <img class="checkbox" src="images/checkbox.svg"/>
                    </a>
                    <a class="delete-task" href="deleteTask.php?id=<?= $task["id"]?>">
                        <img class="delete" src="images/delete.svg"/>
                    </a> 
                    <a class="edit-task" href="?editTitle"> 
                        <img class="edit-icon" src="images/edit.svg"/>
                    </a>
                </div>
            </div>
        <?php endforeach; ?> 

        <div class="bottom-container">
            <div class="order-content">
                order by priority 

                <a class="sort-high" href="?sortByPriority">
                    <img class="sort-high-icon" src="images/up-arrow.svg"/>
                </a>
                <a class="sort-low" href="?sortByPriority&asc">
                    <img class="sort-low-icon" src="images/down-arrow.svg"/>
                </a>
            </div>
            <div class="delete-all">
                delete all
                <a class="delete-all-tasks" href="deleteAllUnfinishedTasks.php">
                    <img class="icon" src="images/delete-all.svg"/>
                </a> 
            </div>
        </div>
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

<?php require 'footer.html'; ?>