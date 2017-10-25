<?php

require '../database/PDO.php';
require '../database/functions.php';

undoPriority($pdo, $_GET["id"]);

header("Location: ..");
exit();