<?php

require 'PDO.php';
undoCheckOffTask($pdo, $_GET["id"]);

header("Location: .");
exit();