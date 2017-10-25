<?php

require '../database/PDO.php';
require '../database/functions.php';

deleteAllFinishedTasks($pdo);

header("Location: ..");
exit();