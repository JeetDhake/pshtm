<?php

include('connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/b9323f08fd.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/library.css">
    <title>Library</title>
</head>

<body>
    <?php require_once("navbar.html") ?>

    <div class="sidebar">
        <div class="links">
            <a href="upload_file.php">
                <i class="fa-solid fa-house"></i>
                <p>Upload File</p>
            </a>
            <a href="all_files.php">
                <i class="fa-regular fa-compass"></i>
                <p>View Files</p>
            </a>
            <hr>
        </div>
    </div>

    <div class="shelf">
        <h1>Library</h1>
        <div class="lib">
<?php
            $select_query = "SELECT * FROM files";
            $result_query = pg_query($conn, $select_query);
        
            while ($row = pg_fetch_assoc($result_query)) {

                $title = $row['title'];
                $author = $row['author'];

                $name = $row['name'];
                $type = $row['type']; 
                $extention = $row['extention']; 
                $location = $row['location']; 
                $size = $row['size'];
                $mb = $size / (1024 * 1024);
            echo '<div class="bok">
            <i class="fa-regular fa-file-lines"></i>
                <h2>'.$title.'</h2>
                <p>'.$author.'</p>
                <small>size: '.$mb.'mb</small>
                <div class="bt">
                    <a href="'.$location.'">View File</a>
                    <a href="dloadfil.php?file='.$name.'">Download</a>
                </div>
            </div>';
            }

?>
        </div>
    </div>
    <script src="manage.js"></script>
</body>

</html>