<?php

require 'PDO.php';
orderByPriority($pdo, $_GET["created"]);

header("Location: .");
exit();