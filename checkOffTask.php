<?php

require 'PDO.php';
checkOffTask($pdo, $_GET["id"]);

header("Location: .");
exit();