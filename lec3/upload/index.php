<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>upload file</title>
  <style>
    form {
      display: flex;
      flex-direction: column;
    }

    input[type=submit] {
      width: 100px;
      margin-top: 10px;
    }

    table,
    th,
    td {
      border: 1px solid black;
      border-collapse: collapse;
      width: 100vw;
      text-align: center;
    }

    a {
      width: 15px;
      display: inline-block;
      cursor: pointer;
    }
  </style>
</head>

<?php
include("model.php");
date_default_timezone_set("Asia/Bangkok");

if (!file_exists('./upload')) {
  mkdir('./upload', 0777, true);
}

$orderBy = 'asc';
$sortBy = 'name';
$datas = sortByName($orderBy);

if (isset($_GET['orderBy'])) {
  $orderBy = $_GET['orderBy'];
}
if (isset($_GET['sortBy'])) {
  $sortBy = $_GET['sortBy'];
}

function initData()
{
  $fileNames = array_diff(scandir("./upload/"), array('.', '..'));
  $datas = array();

  if (count($fileNames) < 0) return $datas;

  foreach ($fileNames as $name) {
    $uploadDate = filemtime("./upload/" . $name);
    $type = pathinfo("./upload/" . $name)['extension'];
    $size = filesize("./upload/" . $name);

    $data = new Data($name, $type, $uploadDate, $size);
    array_push($datas, $data);
  }

  return $datas;
}


function sortByName($orderBy)
{
  $datas = initData();
  for ($i = 0; $i < count($datas); $i++) {
    for ($j = 0; $j < count($datas) - $i - 1; $j++) {
      //get first letter and convert to number;
      $first = ord(strtolower($datas[$j]->name[0])) - 96;
      $second = ord(strtolower($datas[$j + 1]->name[0])) - 96;

      if ($orderBy == 'asc') {
        if ($first > $second) {
          $temp = $datas[$j];
          $datas[$j] = $datas[$j + 1];
          $datas[$j + 1] = $temp;
        }
      }

      if ($orderBy == 'desc') {
        if ($first < $second) {
          $temp = $datas[$j];
          $datas[$j] = $datas[$j + 1];
          $datas[$j + 1] = $temp;
        }
      }
    }
  }

  return $datas;
}

function sortByUploadDate($orderBy)
{
  $datas = initData();
  for ($i = 0; $i < count($datas); $i++) {
    for ($j = 0; $j < count($datas) - $i - 1; $j++) {
      //get first letter and convert to number;
      $first = $datas[$j]->uploadDate;
      $second = $datas[$j + 1]->uploadDate;

      if ($orderBy == 'asc') {
        if ($first > $second) {
          $temp = $datas[$j];
          $datas[$j] = $datas[$j + 1];
          $datas[$j + 1] = $temp;
        }
      }

      if ($orderBy == 'desc') {
        if ($first < $second) {
          $temp = $datas[$j];
          $datas[$j] = $datas[$j + 1];
          $datas[$j + 1] = $temp;
        }
      }
    }
  }

  return $datas;
}


if ($sortBy == 'name') {
  $datas = sortByName($orderBy);
}

if ($sortBy == 'uploadDate') {
  $datas = sortByUploadDate($orderBy);
}
?>


<body>
  <form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="fileInput">
    <input type="submit" name="submitBtn">
  </form>
  <h1>Các tập tin đã tải lên</h1>
  <table>
    <tr>
      <th>Tên tập tin
        <?php
        if ($orderBy == 'desc') {
          echo '<a href="index.php?sortBy=name&orderBy=asc"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75L12 3m0 0l3.75 3.75M12 3v18" />
          </svg></a>';
        } else if ($orderBy == 'asc') {
          echo '<a href="index.php?sortBy=name&orderBy=desc"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25L12 21m0 0l-3.75-3.75M12 21V3" />
          </svg></a>';
        }
        ?>
      </th>
      <th>Loại</th>
      <th>Ngày tải lên

        <?php
        if ($orderBy == 'desc') {
          echo '<a href="index.php?sortBy=uploadDate&orderBy=asc"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75L12 3m0 0l3.75 3.75M12 3v18" />
          </svg></a>';
        } else if ($orderBy == 'asc') {
          echo '<a href="index.php?sortBy=uploadDate&orderBy=desc"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25L12 21m0 0l-3.75-3.75M12 21V3" />
          </svg></a>';
        }
        ?>
      </th>
      <th>Kích thước</th>
    </tr>
    <?php

    foreach ($datas as $data) {
      echo "<tr>";
      echo "<td>" . $data->name . "</td>";
      echo "<td>" . $data->type . "</td>";
      echo "<td>" . date("H:i:s d/m/Y", $data->uploadDate) . "</td>";
      echo "<td>" . $data->size . " byte" . "</td>";
      echo "</tr>";
    }

    ?>
  </table>
</body>

</html>