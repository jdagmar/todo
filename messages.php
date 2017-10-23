
<?php if (isset($_SESSION["submitErrors"]) && $_SESSION["submitErrors"]): ?>

    <?php if ($_SESSION["errorMissingTask"]): ?>
        <div class="error-msg">
            <p class="error__text">You need to add a task <img class="error" src="images/error.svg"></p>
        </div> 
    <?php endif; ?>
    
    <?php if ($_SESSION["errorMissingName"]): ?>
        <div class="error-msg">
            <p class="error__text">You need to add a name <img class="error" src="images/error.svg"></p>
        </div> 
    <?php endif; ?>

<?php endif; ?>

<?php if (isset($_SESSION["titleIsNotUniqe"]) && $_SESSION["titleIsNotUniqe"]): ?>

    <?php if($_SESSION["titleIsNotUniqe"]): ?>
        <div class="warning-msg">
            <p class="warning__text">There allready is a task like this in the list <img class="icon" src="images/warning.svg"></p>
        </div>
    <?php endif; ?>

<?php endif; ?>    

<?php if ($newTask): ?>
    <div class="added-msg">
        <p class="added-msg__text">A new item was added successfully!</p>
    </div>
<?php endif; ?>