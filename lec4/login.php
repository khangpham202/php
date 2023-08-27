
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <label for="">Username</label>
        <input type="text" name="username"><br> 
        <label for="">Password</label>
        <input type="password" name="password"><br>
        <input type="submit" value="Đăng nhập">
        <a href="./forgotPassword.php">Quên mật khẩu</a>
    </form> 
</body>
</html>

<?php
    require 'database.php';
    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $pwd = $_POST['password'];
        $sql = "SELECT * from account where username = '$username' AND password = '$pwd';";

        $result = $conn->query($sql);
       
        if($result->num_rows == 0){
            echo '<script language="javascript">';
            echo 'alert("Tên đăng nhập hoặc mật khẩu sai")';
            echo '</script>';
        }else{
            $_SESSION["Username"] = $username;
            $_SESSION["isLogin"] = true;
            
            header('Location:./index.php');
        }
    }

?>

