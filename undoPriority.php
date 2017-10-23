<?php

require 'PDO.php';
undoPriority($pdo, $_GET["id"]);

header("Location: .");
exit();