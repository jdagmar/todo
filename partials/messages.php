
<?php if ($error): ?>

    <?php if ($_SESSION["errorMissingTask"]): ?>
        <div class="error-msg">
            <p class="error-msg__text">You need to add a task <img class="icon" alt="error icon" src="images/error.svg"></p>
        </div> 
    <?php endif; ?>
    
    <?php if ($_SESSION["errorMissingName"]): ?>
        <div class="error-msg">
            <p class="error-msg__text">You need to add a name <img class="icon" alt="error icon" src="images/error.svg"></p>
        </div> 
    <?php endif; ?>

<?php endif; ?>

<?php if ($warning): ?>
    <div class="warning-msg">
        <p class="warning-msg__text">The task you tried to add is already on the list <img class="icon" alt="warning icon" src="images/warning.svg"></p>
    </div>
<?php endif; ?>    

<?php if ($newTask): ?>
    <div class="added-msg">
        <p class="added-msg__text">A new item was added successfully! <img class="icon" src="images/check.svg"></p>
    </div>
<?php endif; ?>