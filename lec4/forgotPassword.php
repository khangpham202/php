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
        <input type="submit" value="Lấy lại mật khẩu">
    </form>

    <a href="./login.php">Quay lại</a>
</body>

</html>

<?php
require 'database.php';
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $randomcode = (rand(1, 100));
    $sql = "UPDATE account SET code='$randomcode' WHERE username = '$username'";
    $sql1 = "SELECT * from account where username = '$username';";
    $result = $conn->query($sql);
    $result1 = $conn->query($sql1);

    if ($result1->num_rows == 0) {
        echo "tên đăng nhập không đúng";
    } else {
        $conn->query($sql) === TRUE ? header('Location:./forgotPwdPage.php') : "";
    }
}

?>