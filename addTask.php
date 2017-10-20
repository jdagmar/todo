<?php

require 'PDO.php';

addTask($pdo, $_POST["new-task"], $_POST["username"]);

header("Location: .");
exit();