<?php

require '../database/PDO.php';
require '../database/functions.php';

orderByPriority($pdo, $_GET["created"]);

header("Location: ..");
exit();