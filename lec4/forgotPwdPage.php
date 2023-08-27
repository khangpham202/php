<?php
require 'database.php';
if (isset($_POST['code']) && isset($_POST['password']) && isset($_POST['confirmPWD'])) {
    $code = $_POST['code'];
    $pwd = $_POST['password'];
    $confirmPWD = $_POST['confirmPWD'];
    $sql = "SELECT * from account where code = '$code';";
    $result = $conn->query($sql);
    if ($code == '' || $pwd == '' || $confirmPWD == '') {
        echo "Không được bỏ trống";
    } elseif ($pwd != $confirmPWD) {
        echo 'Mật khẩu xác nhận chưa trùng';
    } elseif ($result->num_rows == 0) {
        echo "mã code không đúng";
    } else {
        $sql = "UPDATE account SET password='$pwd' WHERE code = $code";
        $result = $conn->query($sql);
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Đổi mật khẩu thành công");</script>';
            echo '<script>window.location.href = "login.php";</script>';
        } else {
            echo "update thất bại";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="post">
        <label for="">Code</label>
        <input type="text" name="code"><br>
        <label for="">New password</label>
        <input type="password" name="password"><br>
        <label for="">Confirmed password</label>
        <input type="password" name="confirmPWD"><br>
        <input type="submit" value="Đổi mật khẩu">
    </form>

</body>

</html>