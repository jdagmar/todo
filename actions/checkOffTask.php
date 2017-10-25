<?php

require '../database/PDO.php';
require '../database/functions.php';

checkOffTask($pdo, $_GET["id"]);

header("Location: ..");
exit();