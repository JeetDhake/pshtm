<?php

include('connect.php');
session_start();
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['trainer_id'])) {
    header("location: admin_login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/b9323f08fd.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/library.css">
    <link rel="stylesheet" href="style/sidebar.css">
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



    <div class="containerx">


        <div class="apfx">
            <div class="wrapper">
                <section class="pst">
                    <header>
                        Upload Docs
                    </header>

                    <form action="upload.php" method="POST" enctype="multipart/form-data">

                        <div class="pdetail">
                            <?php
                            if (isset($_SESSION['message'])) {
                                $msg = $_SESSION['message'];
                                echo "<div class='emsg'>
                                        <p>$msg</p>
                                    </div>";
                                unset($_SESSION['message']);
                            }
                            ?>

                            <div class="fld img">
                                <label for="">add (txt, pdf, docx, doc, ppt, pptx, mp4)</label>
                                <label for="img" id="drop">
                                    <input type="file" name="file" id="img" hidden>

                                    <div id="img-view">

                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                        <p>Drag and Drop<br>click here to Upload File</p>
                                    </div>
                                </label>
                            </div>



                            <div class="f">
                                <div class="fld">
                                    <label for="">Book Title</label>
                                    <input type="text" name="title" id="title" placeholder="Book Name - Tag line"
                                        required>

                                </div>
                                <div class="fld">
                                    <label for="">Author</label>
                                    <input type="text" name="author" id="author" placeholder="writer name" required>
                                </div>
                            </div>


                            <div class="fld btn">
                                <input type="submit" value="Upload File" name="submit" id="submit">
                            </div>

                        </div>
                    </form>

                </section>
            </div>
        </div>
    </div>

    <script src="upload.js"></script>
    <script src="manage.js"></script>
</body>

</html>