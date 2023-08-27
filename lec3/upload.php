<!DOCTYPE html>
<html>

<head>
    <title>Upload File</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 10px;
        }

        a {
            width: 15px;
            cursor: pointer;
            text-decoration: none;
        }

        svg {
            width: 60px;
            height: 30px;
        }
    </style>
</head>

<body>
    <br>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        Select file to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload File" name="submit">
    </form>

    <?php
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    $uploadDirectory = "upload/";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileToUpload"])) {
        $targetFile = $uploadDirectory . basename($_FILES["fileToUpload"]["name"]);
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            echo "File uploaded successfully.";
        } else {
            echo "Error uploading file.";
        }
    }

    $files = scandir($uploadDirectory);
    $files = array_diff($files, array(".", ".."));

    if (isset($_GET["sort"])) {
        $sortType = $_GET["sort"];
        if ($sortType == "name") {
            if (isset($_GET["order"]) && $_GET["order"] == "desc") {
                rsort($files);
            } else {
                sort($files);
            }
        } elseif ($sortType == "date") {
            if (isset($_GET["order"]) && $_GET["order"] == "desc") {
                usort($files, function ($a, $b) use ($uploadDirectory) {
                    return filemtime($uploadDirectory . $a) > filemtime($uploadDirectory . $b);
                });
            } else {
                usort($files, function ($a, $b) use ($uploadDirectory) {
                    return filemtime($uploadDirectory . $a) < filemtime($uploadDirectory . $b);
                });
            }
        }
    }

    echo "<h1>Uploaded Files</h1>";

    echo '<table>
            <tr>
                <th>STT</th>
                <th>
                    <a href="?sort=name&order=' . (isset($_GET["order"]) && $_GET["order"] == "desc" ? "asc" : "desc") . '">
                        Tên tập tin
                        <span style="display: inline-block;">' . (isset($_GET["sort"]) && $_GET["sort"] == "name" ?
        ($_GET["order"] == "desc" ?
            '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75L12 3m0 0l3.75 3.75M12 3v18" />
                                    </svg>'
            : '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25L12 21m0 0l-3.75-3.75M12 21V3" />
                                    </svg>'
        )
        : '') .
        '</span>
                    </a>
                </th>
                <th>Loại tập tin</th>
                <th>
                    <a href="?sort=date&order=' . (isset($_GET["order"]) && $_GET["order"] == "desc" ? "asc" : "desc") . '">
                        Ngày tải lên
                        <span style="display: inline-block;">' . (isset($_GET["sort"]) && $_GET["sort"] == "date" ?
        ($_GET["order"] == "desc" ?
            '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75L12 3m0 0l3.75 3.75M12 3v18" />
                                </svg>'
            : '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25L12 21m0 0l-3.75-3.75M12 21V3" />
                                </svg>'
        )
        : '') .
        '</span>
                    </a>
                </th>
                <th>Kích thước</th>
            </tr>
            ';

    foreach ($files as $index => $file) {
        echo "<tr>
                <td>$index</td>
                <td>$file</td>
                <td>" . mime_content_type($uploadDirectory . $file) . "</td>
                <td>" . date("Y-m-d H:i:s", filemtime($uploadDirectory . $file)) . "</td>
                <td>" . filesize($uploadDirectory . $file) . " bytes</td>
            </tr>";
    }
    echo '</table>';
    ?>

</body>

</html>