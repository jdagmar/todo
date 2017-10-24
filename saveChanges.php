<?php
session_start();

require 'PDO.php';
saveChanges($pdo, $_POST["edited-task"], $_POST["id"]);

unset($_SESSION["editMode"]);

header("Location: .");
exit();