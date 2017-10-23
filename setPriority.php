<?php

require 'PDO.php';
setPriority($pdo, $_GET["id"]);

header("Location: .");
exit();