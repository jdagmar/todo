<form class="user-input" action="actions/addTask.php" method="POST">
    <input class="user-input__new-task" type="text" name="new-task" value="<?= getFormData("new-task"); ?>" placeholder="Add a new task to the list"/>
    <input class="user-input__username" type="text" name="username" value="<?= getFormData("username"); ?>" placeholder="and your name"/>
    <input class="user-input__add-task" type="image" src="images/add.svg">
    <input type="hidden" name="submit"/>
</form>