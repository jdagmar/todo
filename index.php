<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

session_start();

require 'database/PDO.php';
require 'database/functions.php';
require 'functions/functions.php';

$orderByPriority = isset($_SESSION["orderByPriority"]) && $_SESSION["orderByPriority"];

$newTask = isset($_SESSION["taskAdded"]);
unset($_SESSION["taskAdded"]);

$warning = isset($_SESSION["titleIsNotUniqe"]) && $_SESSION["titleIsNotUniqe"];
unset($_SESSION["titleIsNotUniqe"]);

$error = isset($_SESSION["submitErrors"]) && $_SESSION["submitErrors"];
unset($_SESSION["submitErrors"]);


require 'partials/head.html';
require 'partials/header.html';

require 'partials/messages.php';

require 'partials/user-input-field.php';
require 'partials/tips-msg.html';
?>

<div class="tasks">
    <div class="tasks__container">
        <h2 class="tasks__header">Task's to do</h2>      
        <?php foreach (getUnfinishedTasks($pdo, $orderByPriority, false) as $i => $task): ?>
                <?php if(isset($_SESSION["editMode"]) && $_SESSION["editMode"] == $task["id"]):?>
                    <div class="tasks__content">      
                        <div class="tasks__priority">
                            <?php if($task["priority"]): ?>
                                <a  role="button" aria-label="undo high priority" href="actions/undoPriority.php?id=<?= $task["id"]?>">
                                    <img class="icon" alt="red exclamtion mark" src="images/high-priority.svg"/>
                                </a>   
                            <?php else: ?>
                                <a role="button" aria-label="set high priority" href="actions/setPriority.php?id=<?= $task["id"]?>">
                                    <img class="icon" alt="grey exclamation mark" src="images/set-high-priority.svg"/>
                                </a>
                            <?php endif;?>
                        </div>
                    
                        <div class="title-container">
                            <div class="title-row">
                                <form action="actions/saveChanges.php" method="POST" id="submit">
                                    <input class="title-row__change-title" type="text" autofocus="autofocus" name="edited-task" value="<?= $task["title"]?>"/>
                                    <input type="hidden" name="id" value="<?= $task["id"]?>" /> 
                                </form>    
                                <span class="title-row__text">added by </span>
                                <img class="icon" alt="user icon" src="images/user.svg"/>
                                <span><?= "" . $task['createdBy']?></span>
                            </div>
                        </div>

                        <div class="manage-task">
                            <a role="button" aria-label="check off" class="manage-task__check-off"  href="actions/checkOffTask.php?id=<?= $task["id"]?>">
                                <img class="icon" alt="empty checkbox" src="images/checkbox.svg"/>
                            </a>
                            <a role="button" aria-label="delete" class="manage-task__delete" href="actions/deleteTask.php?id=<?= $task["id"]?>">
                                <img class="icon" alt="delete icon" src="images/delete.svg"/>
                            </a> 
                            <input aria-label="save" class="icon" type="image" alt="save icon" src="images/save.svg" form="submit">
                        </div>
                    </div>

                <?php else: ?>

                    <div class="tasks__content"> 
                        <div class="tasks__priority">
                            <?php if($task["priority"]): ?>
                                <a role="button" aria-label="undo high priority" href="actions/undoPriority.php?id=<?= $task["id"]?>">
                                    <img class="icon" alt="red exclamation mark" src="images/high-priority.svg"/>
                                </a>   
                            <?php else: ?>
                                <a role="button" aria-label="set high priority" href="actions/setPriority.php?id=<?= $task["id"]?>">
                                    <img class="icon" alt="grey exclamation mark" src="images/set-high-priority.svg"/>
                                </a>
                            <?php endif;?>
                        </div>
                
                        <div class="title-container">
                            <div class="title-row">
                                <span class="title-row__list-item"><?=  $task["title"]?></span>
                                <span class="title-row__text">added by </span>
                                <img class="icon" alt="user icon" src="images/user.svg"/>
                                <span class="title-row__text"><?= "" . $task['createdBy']?></span>
                            </div>
                        </div>

                        <div class="manage-task">
                            <a role="button" aria-label="check off task" href="actions/checkOffTask.php?id=<?= $task["id"]?>">
                                <img class="icon" alt="empty checkbox" src="images/checkbox.svg"/>
                            </a>
                            <a role="button" aria-label="delete" href="actions/deleteTask.php?id=<?= $task["id"]?>">
                                <img class="icon" alt="delete icon" src="images/delete.svg"/>
                            </a> 
                            <a role="button" aria-label="edit" href="actions/editTitle.php?edit-titleid=<?= $task["id"]?>"> 
                                <img class="icon" alt="edit icon" src="images/edit.svg"/>
                            </a>
                        </div>
                     </div>   
                <?php endif; ?>
    
        <?php endforeach; ?> 

        <div class="bottom-container">
            <div class="order-content">
                <span>Sort by priority</span>
                <?php if ($orderByPriority):?>
                    <a role="button" aria-label="show high priority first" href="actions/sortTasks.php">
                        <img class="icon" alt="checked checkbox" src="images/order-check.svg"/>
                    </a>
                <?php else: ?>
                    <a role="button" aria-label="show high priority last" href="actions/sortTasks.php?sortByPriority">
                        <img class="icon" alt="checkbox icon" src="images/checkbox.svg"/>
                    </a>
                <?php endif ?>
            </div>
            <div class="clear-list">
                <span>clear list</span> 
                <a role="button" aria-label="clear list" href="actions/deleteAllUnfinishedTasks.php">
                    <img class="icon" alt="delete all icon" src="images/delete-all.svg"/>
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
                    <img class="icon" alt="user icon" src="images/user.svg"/>
                    <span class="title-row__text"><?= "" . $task['createdBy']?></span>
                </div>
                
                <div class="manage-task">
                    <a role="button" aria-label="undo check off" href="actions/undoCheckOffTask.php?id=<?= $task["id"]?>">
                        <img class="icon" alt="green check icon" src="images/check.svg"/>
                    </a>
                    <a role="button" href="actions/deleteTask.php?id=<?= $task["id"]?>">
                        <img aria-label="delete" class="icon" alt="delete icon" src="images/delete.svg"/>
                    </a>                                         
                </div>
            </div>
        <?php endforeach; ?>

        <div class="bottom-container">
            <div class="clear-list">
                <span>clear list</span>
                <a role="button" aria-label="clear list" href="actions/deleteAllFinishedTasks.php">
                    <img class="icon" alt="delete all icon" src="images/delete-all.svg"/>
                </a> 
            </div>
        </div>    

    </div>
</div>

<?php require 'partials/footer.html'; ?>