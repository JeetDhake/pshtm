<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
</head>

<body>
                <form action="import_xldb.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="import_file" id="">
                    <button type="submit" name="import">Import</button>
                </form>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
                ?>

</body>

</html>