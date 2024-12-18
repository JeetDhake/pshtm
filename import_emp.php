<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location: admin_login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/b9323f08fd.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/sidebar.css">
    <link rel="stylesheet" href="style/library.css">
    <title>xldb_emp</title>
</head>

<body>
    <?php
    if (isset($_SESSION['admin_id'])) {
        require_once("navbar.html");
    } elseif (isset($_SESSION['trainer_id'])) {
        require_once("navbar2.html");
        $trainer_id = $_SESSION['trainer_id'];
    }
    require_once("sidebarx.html");
    ?>
    <div class="container">
        <div class="wrapper" id="">
            <section class="pst">
                <header>
                    Import Employees
                </header>
                <?php

                if (isset($_SESSION['message'])) {
                    $msg = $_SESSION['message'];
                    echo "<div class='emsg'>
                            <p>$msg</p>
                        </div>";
                    unset($_SESSION['message']);
                }
                ?>
                <form action="xldb_emp.php" method="POST" enctype="multipart/form-data">


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
                        <td>emp_first_name</td>
                        <td>emp_last_name</td>
                        <td>emp_mobile</td>
                        <td>emp_email</td>
                    </tr>
                    <tr>
                        <td>job_post</td>
                        <td>department</td>
                        <td>emp_uid</td>
                        <td>password</td>
                    </tr>
                </table>

            </section>
        </div>
    </div>

    <script src="manage.js"></script>
    <script src="upload.js"></script>
</body>

</html>