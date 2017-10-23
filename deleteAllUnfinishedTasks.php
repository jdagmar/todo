<?php

require 'PDO.php';
deleteAllUnfinishedTasks($pdo);

header("Location: .");
exit();