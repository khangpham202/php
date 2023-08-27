<?php
    require 'database.php';
    unset($_SESSION['Username']);
    session_destroy();
    header("Location: index.php");
?>