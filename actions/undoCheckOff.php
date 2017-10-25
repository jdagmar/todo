<?php

require '../database/PDO.php';
require '../database/functions.php';

undoCheckOffTask($pdo, $_GET["id"]);

header("Location: ..");
exit();