<?php
session_start();

require '../database/PDO.php';
require '../database/functions.php';

saveChanges($pdo, $_POST["edited-task"], $_POST["id"]);

unset($_SESSION["editMode"]);

header("Location: ..");
exit();