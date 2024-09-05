<?php

include('connect.php');


if (isset($_POST['submit'])) {

    $emp_job_post = pg_escape_string($_POST['job_post_name']);


    if ($emp_job_post == '') {
        echo "<script>
            alert('enter field')
            </script>";
        exit();
    } else {

        $insert = "INSERT INTO job_post (job_post_name) VALUES ('$emp_job_post')RETURNING job_post_id";
        $result_query = pg_query($conn, $insert);

        if(!$result_query){
            die("there is an error in insert query" . pg_last_error($conn));
        }
        
        $row = pg_fetch_assoc($result_query);
        $job_post_id = ['job_post_id'];


        if ($result_query) {

            echo "<script>
                alert('Job post Added successfully')
                </script>";

        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/manage_dept.css">
    <title>Manage_Dept</title>
</head>

<body>
    <?php require_once("navbar.html") ?>
    <?php require_once("sidebar.html") ?>



    <div class="container">

        <div class="wrapper" id="">
            <section class="pst">
                <header>
                    Add New JobPost
                </header>
                <form action="" method="POST" enctype="multipart/form-data">

                    <div class="pdetail">


                        <div class="">
                            <div class="fld">
                                <label for="">Job Role</label>
                                <input type="text" name="job_post_name" id="" placeholder="enter your role"
                                    required>

                            </div>
                        </div>
                        <div class="fld btn">
                            <input type="submit" value="Add Job Post" name="submit" id="submit">
                        </div>
                    </div>
                </form>

            </section>
        </div>

    </div>

    <script src="manage.js"></script>
</body>

</html>