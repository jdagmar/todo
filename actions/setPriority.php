<?php

require '../database/PDO.php';
require '../database/functions.php';

setPriority($pdo, $_GET["id"]);

header("Location: ..");
exit();