<?php
    require 'database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        if(isset($_SESSION["Username"]) && $_SESSION["isLogin"]){
           echo("Welcome {$_SESSION['Username']}"."<br />");
           echo '<a href = "./logout.php">Đăng xuất</a>';
        }else{
            echo("Welcome to the page");
            echo '<a href="./login.php">Đăng nhập</a>';
        }
    ?>

    
</body>
</html>