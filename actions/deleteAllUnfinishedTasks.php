<?php

require '../database/PDO.php';
require '../database/functions.php';

deleteAllUnfinishedTasks($pdo);

header("Location: ..");
exit();