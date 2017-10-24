<?php
session_start();

if (isset($_GET["edit-titleid"])){ 
    $_SESSION["editMode"] = $_GET["edit-titleid"];
}

header("Location: .");
exit();