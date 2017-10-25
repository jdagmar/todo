<?php

session_start();

$orderByPriority = isset($_GET["sortByPriority"]);

$_SESSION["orderByPriority"] = $orderByPriority; 

header("Location: ..");
exit();