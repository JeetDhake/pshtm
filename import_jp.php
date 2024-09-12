<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/b9323f08fd.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/sidebar.css">
    <link rel="stylesheet" href="style/library.css">
    <title>xldb_jp</title>
</head>

<body>
    <?php
    require_once("navbar.html");
    require_once("sidebarx.html");
    ?>
    <div class="container">
        <div class="wrapper" id="">
            <section class="pst">
                <header>
                    Import JobPosts
                </header>
                <?php

                if (isset($_SESSION['message'])) {
                    $msg = $_SESSION['message'];
                    echo "<div class='emsg'>
                            <p>'.$msg.'</p>
                        </div>";
                    unset($_SESSION['message']);
                }
                ?>
                <form action="xldb_jp.php" method="POST" enctype="multipart/form-data">


                    <div class="pdetail">

                        <div class="fld img">
                            <label for="">Supported File (csv, xls, xlsx)</label>
                            <label for="img" id="drop">
                                <input type="file" name="import_file" id="img" hidden>

                                <div id="img-view">

                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <p>Drag and Drop<br>click here to Upload File</p>
                                </div>
                            </label>
                        </div>
                        <div class="fld btn">
                            <input type="submit" value="Import File" name="import" id="submit">
                        </div>
                    </div>

                    <!-- <input type="file" name="import_file" id="">
                    <button type="submit" name="import">Import</button> -->
                </form>

                <p>Format: </p>
                <table>
                    <tr>
                        <td>job_post_name</td>
                    </tr>
                </table>

            </section>
        </div>
    </div>

    <script src="manage.js"></script>
    <script src="upload.js"></script>
</body>

</html>