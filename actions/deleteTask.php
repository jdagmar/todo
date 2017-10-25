<?php

require '../database/PDO.php';
require '../database/functions.php';

deleteTask($pdo, $_GET["id"]);

header("Location: ..");
exit();