
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dang ky mon hoc</title>
  <style>
    table,
    th,
    td {
      border: 3px solid red;
      border-collapse: collapse;
      width: 800px;
      text-align: center;
    }
  </style>
</head>

<body>
  <table>
    <tr>
      <th>MSSV</th>
      <th>Họ Tên</th>
      <th>Kỳ</th>
      <th>Đăng ký</th>
    </tr>
    <?php
    $conn = new mysqli("localhost","root","123456a@","pka_s");

    if ($conn->connect_error) {
      die("connect failed" . $conn->connect_error);
    }

    $sql = "SELECT sinhvien.maSV,Hoten,Ky,tenMH FROM sinhvien,dangky,monhoc WHERE sinhvien.maSV = dangky.maSV and dangky.maMH = monhoc.maMH";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["maSV"] . "</td>";
        echo "<td>" . $row["Hoten"] . "</td>";
        echo "<td>" . $row["Ky"] . "</td>";
        echo "<td>" . $row["tenMH"] . "</td>";
        echo "</tr>";
      }
    } else {
      echo "0 results";
    }
    ?>
  </table>


</body>

</html>