<?php
    $conn = new mysqli("localhost","root","1","lec4");
    session_start();
    if ($conn->connect_error) {
      print("connect failed" . $conn->connect_error);
    }
?>