<?php
session_start();

require 'database/PDO.php';
require 'database/functions.php';
require 'functions/functions.php';

//checks if list is sorted by priority
$orderByPriority = isset($_SESSION["orderByPriority"]) && $_SESSION["orderByPriority"];

//controlls the user input in order to deliver messages 
$newTask = isset($_SESSION["taskAdded"]);
unset($_SESSION["taskAdded"]);

$warning = isset($_SESSION["titleIsNotUniqe"]) && $_SESSION["titleIsNotUniqe"];
unset($_SESSION["titleIsNotUniqe"]);

$error = isset($_SESSION["submitErrors"]) && $_SESSION["submitErrors"];
unset($_SESSION["submitErrors"]);

require 'partials/head.html';
require 'partials/header.html';

//hold the eror messages etc
require 'partials/messages.php';

//the input field where user adds new tasks
require 'partials/user-input-field.php';

//paragraphs that explains icon usage on the page
require 'partials/tips-msg.html';
?>

<div class="tasks">
    <div class="tasks__container">
        <h2 class="tasks__header">Tasks to do</h2>
        
        <!-- loops out the unfinished todos with the newest task first -->
        <?php foreach (getUnfinishedTasks($pdo, $orderByPriority, false) as $i => $task): ?>
                
                <!-- this is the view that renders if your in 'edit mode' ie when you want 
                    to change the title of a task -->
                <?php if(isset($_SESSION["editMode"]) && $_SESSION["editMode"] == $task["id"]): ?>
                    <div class="tasks__content">      
                        
                        <!-- renders the exclamation mark by the task, red if its important
                             and grey if its not set ie not as important-->
                        <div class="tasks__priority">
                            <?php if($task["priority"]): ?>
                                <a  role="button" aria-label="undo high priority" href="actions/undoPriority.php?id=<?= $task["id"]?>">
                                    <img class="icon" alt="red exclamtion mark" src="images/high-priority.svg"/>
                                </a>   
                            <?php else: ?>
                                <a role="button" aria-label="set high priority" href="actions/setPriority.php?id=<?= $task["id"]?>">
                                    <img class="icon" alt="grey exclamation mark" src="images/set-high-priority.svg"/>
                                </a>
                            <?php endif; ?>
                        </div>

                        <!-- holds the title of the task and whom it was created by -->
                        <div class="title-container">
                            <div class="title-row">
                                <form action="actions/saveChanges.php" method="POST" id="submit">
                                <label for="edited-task" aria-hidden="true">New title for the task</label>
                                    <input class="title-row__change-title" type="text" autofocus="autofocus" name="edited-task" value="<?= $task["title"]?>"/>
                                    <input type="hidden" name="id" value="<?= $task["id"]?>" /> 
                                </form>    
                                <span class="title-row__text">added by </span>
                                <img class="icon" alt="user icon" src="images/user.svg"/>
                                <span><?= "" . $task['createdBy']?></span>
                            </div>
                        </div>
                        
                        <!-- the edit section where you can check off/delete/edit -->
                        <div class="manage-task">
                            <a role="button" aria-label="check off" class="manage-task__check-off"  href="actions/checkOffTask.php?id=<?= $task["id"]?>">
                                <img class="icon" alt="empty checkbox" src="images/checkbox.svg"/>
                            </a>
                            <a role="button" aria-label="delete" class="manage-task__delete" href="actions/deleteTask.php?id=<?= $task["id"]?>">
                                <img class="icon" alt="delete icon" src="images/delete.svg"/>
                            </a> 
                            <input role="button" aria-label="save changes" class="icon" type="image" alt="save icon" src="images/save.svg" form="submit">
                        </div>
                    </div>

                <!-- renders the view when task title is set, same as above except but without 
                     the save icon (manage-task) and the inputfield in the title-container -->
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
                            <?php endif; ?>
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

        <!-- a static (shows both in edit mode and regular) section -->
        <div class="bottom-container">

            <!-- if list is ordered by priority the checked checkbox is shown -->
            <div class="order-content">
                <span>Show high priority first</span>
                <?php if ($orderByPriority):?>
                    <a role="button" aria-label="show high priority first" href="actions/sortTasks.php">
                        <img class="icon" alt="checked checkbox" src="images/order-check.svg"/>
                    </a>
                <!-- if list is ordered by date a empty checkbox is shown -->
                <?php else: ?>
                    <a role="button" aria-label="show high priority last" href="actions/sortTasks.php?sortByPriority">
                        <img class="icon" alt="checkbox icon" src="images/checkbox.svg"/>
                    </a>
                <?php endif; ?>
            </div>

            <!-- if user wants to clear the list -->
            <div class="clear-list">
                <span>clear list</span> 
                <a role="button" aria-label="clear list" href="actions/deleteAllUnfinishedTasks.php">
                    <img class="icon" alt="delete all icon" src="images/delete-all.svg"/>
                </a> 
            </div>
        </div>

    </div>

    <div class="tasks__container">
        <h2 class="tasks__header">Finished tasks</h2> 

        <!-- loops out all finished tasks -->
        <?php foreach (getFinishedTasks($pdo) as $i => $task): ?>
            <div class="tasks__content"> 
                <div class="title-row">
                    <span class="title-row_list-item"><?=  $task["title"]?></span>
                    <span class="title-row__text">added by </span>
                    <img class="icon" alt="user icon" src="images/user.svg"/>
                    <span class="title-row__text"><?= "" . $task['createdBy']?></span>
                </div>
                
                <div class="manage-task">
                    <!-- if user wants to undo checkoff icon can be clicked -->
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