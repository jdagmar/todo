<?php

require 'PDO.php';
deleteTask($pdo, $_GET["id"]);

header("Location: .");
exit();