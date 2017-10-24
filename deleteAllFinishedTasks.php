<?php

require 'PDO.php';
deleteAllFinishedTasks($pdo);

header("Location: .");
exit();