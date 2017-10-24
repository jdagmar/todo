<?php
session_start();
require 'PDO.php';
require 'utils.php';

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

<form class="user-input" action="addTask.php" method="POST">
    <input class="user-input__new-task" type="text" name="new-task" value="<?= getFormData("new-task"); ?>" placeholder="Add a new task to the list"/>
    <input class="user-input__username" type="text" name="username" value="<?= getFormData("username"); ?>" placeholder="and your name"/>
    <input class="user-input__add-task" type="image" src="images/add.svg">
    <input type="hidden" name="submit"/>
</form>

<div class="tips-msg">
    <p>In a hurry? Set high priority by clicking the <img class="icon" src="images/set-high-priority.svg"/> icon.</p>
    <p>OOPS? If you check off a task by accident click  <img class="icon" src="images/check.svg"/> to undo the task!</p>  
</div>

<div class="tasks">
    <div class="tasks__container">
        <h2 class="tasks__header">Task's to do</h2>      
        <?php foreach (getUnfinishedTasks($pdo, $orderByPriority, $ascending) as $i => $task): ?>
                <?php if(isset($_SESSION["editMode"]) && $_SESSION["editMode"] == $task["id"]):?>
                    <div class="tasks__content">      
                        <div class="tasks__priority">
                            <?php if($task["priority"]): ?>
                                <a href="undoPriority.php?id=<?= $task["id"]?>">
                                    <img class="icon" src="images/high-priority.svg"/>
                                </a>   
                            <?php else: ?>
                                <a href="setPriority.php?id=<?= $task["id"]?>">
                                    <img class="icon" src="images/set-high-priority.svg"/>
                                </a>
                            <?php endif;?>
                        </div>
                    
                        <div class="title-container">
                            <div class="title-row">
                                <form action="saveChanges.php" method="POST" id="submit">
                                    <input class="title-row__change-title" type="text" autofocus="autofocus" name="edited-task" value="<?= $task["title"]?>"/>
                                    <input type="hidden" name="id" value="<?= $task["id"]?>" /> 
                                </form>    
                                <span class="title-row__text">added by </span>
                                <img class="icon" src="images/user.svg"/>
                                <span><?= "" . $task['createdBy']?></span>
                            </div>
                        </div>

                        <div class="manage-task">
                            <a class="manage-task__check-off" href="checkOffTask.php?id=<?= $task["id"]?>">
                                <img class="icon" src="images/checkbox.svg"/>
                            </a>
                            <a class="manage-task__delete" href="deleteTask.php?id=<?= $task["id"]?>">
                                <img class="icon" src="images/delete.svg"/>
                            </a> 
                            <input class="icon" type="image" src="images/save.svg" form="submit">
                        </div>
                    </div>

                <?php else: ?>

                    <div class="tasks__content"> 
                        <div class="tasks__priority">
                            <?php if($task["priority"]): ?>
                                <a href="undoPriority.php?id=<?= $task["id"]?>">
                                    <img class="icon" src="images/high-priority.svg"/>
                                </a>   
                            <?php else: ?>
                                <a href="setPriority.php?id=<?= $task["id"]?>">
                                    <img class="icon" src="images/set-high-priority.svg"/>
                                </a>
                            <?php endif;?>
                        </div>
                
                        <div class="title-container">
                            <div class="title-row">
                                <span class="title-row__list-item"><?=  $task["title"]?></span>
                                <span class="title-row__text">added by </span>
                                <img class="icon" src="images/user.svg"/>
                                <span class="title-row__text"><?= "" . $task['createdBy']?></span>
                            </div>
                        </div>

                        <div class="manage-task">
                            <a href="checkOffTask.php?id=<?= $task["id"]?>">
                                <img class="icon" src="images/checkbox.svg"/>
                            </a>
                            <a  href="deleteTask.php?id=<?= $task["id"]?>">
                                <img class="icon" src="images/delete.svg"/>
                            </a> 
                            <a href="editTitle.php?edit-titleid=<?= $task["id"]?>"> 
                                <img class="icon" src="images/edit.svg"/>
                            </a>
                        </div>
                     </div>   
                <?php endif; ?>
    
        <?php endforeach; ?> 

        <div class="bottom-container">
            <div class="order-content">
                order by priority 

                <a href="?sortByPriority">
                    <img class="icon" src="images/up-arrow.svg"/>
                </a>
                <a href="?sortByPriority&asc">
                    <img class="icon" src="images/down-arrow.svg"/>
                </a>
            </div>
            <div class="clear-list">
                clear list 
                <a href="deleteAllUnfinishedTasks.php">
                    <img class="icon" src="images/delete-all.svg"/>
                </a> 
            </div>
        </div>

    </div>

    <div class="tasks__container">
        <h2 class="tasks__header">Finished task's</h2> 

        <?php foreach (getFinishedTasks($pdo) as $i => $task): ?>
            <div class="tasks__content"> 
                <div class="title-row">
                    <span class="title-row_list-item"><?=  $task["title"]?></span>
                    <span class="title-row__text">added by </span>
                    <img class="icon" src="images/user.svg"/>
                    <span class="title-row__text"><?= "" . $task['createdBy']?></span>
                </div>
                
                <div class="manage-task">
                    <a href="undoCheckOffTask.php?id=<?= $task["id"]?>">
                        <img class="icon" src="images/check.svg"/>
                    </a>
                    <a href="deleteTask.php?id=<?= $task["id"]?>">
                        <img class="icon" src="images/delete.svg"/>
                    </a>                                         
                </div>
            </div>
        <?php endforeach; ?>

        <div class="bottom-container">
            <div class="clear-list">
                clear list 
                <a href="deleteAllFinishedTasks.php">
                    <img class="icon" src="images/delete-all.svg"/>
                </a> 
            </div>
        </div>    
    </div>
</div>

<?php require 'footer.html'; ?>