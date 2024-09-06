<?php
include('connect.php');
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location: admin_login.php");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/b9323f08fd.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/employee_reg.css">

    <title>pshtm</title>
</head>

<body>
    <?php require_once("navbar.html") ?>
    <?php require_once("sidelist.php") ?>
    <div class="container">


        <div class="apf">
            <div class="wrapper">
                <section class="pst">
                    <header>
                        Add New Employee
                    </header>
                    <?php
                    if (isset($_POST['submit'])) {

                        $emp_uid = $_POST['emp_uid'];

                        $emp_first_name =  pg_escape_string($_POST['emp_first_name']);
                        $emp_last_name =  pg_escape_string($_POST['emp_last_name']);
                        $emp_department =  pg_escape_string($_POST['department_id']);
                        $emp_job_post =  pg_escape_string($_POST['job_post_id']);

                        $emp_email = $_POST['emp_email'];
                        $emp_phone = $_POST['emp_mobile'];

                        // $emp_image = $_FILES['emp_image']['name'];
                        // $tmp_image = $_FILES['emp_image']['tmp_name'];


                        // $fileextention = explode('.', $emp_image);
                        // $fileactext = strtolower(end($fileextention));
                        // $filenewname = uniqid('', true) . "." . $fileactext;

                        $status = "true";

                        $check_id = "SELECT * FROM employee_records WHERE emp_uid = $emp_uid";
                        $res_q = pg_query($conn, $check_id);
                        if ($res_q) {
                            $num_rows = pg_num_rows($res_q);

                            if ($num_rows > 0) {
                                echo "<script>
                                    alert('Employee id already exist')
                                  </script>";
                            } else {



                                if ($emp_first_name == '' or $emp_last_name == '' or $emp_department == '' or $emp_job_post == '' or $emp_email == '' or $emp_phone == '' /*or $emp_image == '' */ or $emp_uid == '') {
                                    echo "<script>
                                    alert('enter all fields')
                                  </script>";
                                    exit();
                                } else {

                                    // move_uploaded_file($tmp_image, "db_img/$filenewname");

                                    $insert_user = "INSERT INTO employee_records (emp_first_name,emp_last_name,department_id,job_post_id,emp_email,emp_mobile,emp_status,emp_uid) VALUES ('$emp_first_name','$emp_last_name','$emp_department','$emp_job_post','$emp_email','$emp_phone','$status','$emp_uid')";

                                    $result_query = pg_query($conn, $insert_user);
                                    if ($result_query) {

                                        echo "<script>
                                    alert('Employee registered successfully')
                                  </script>";
                                    }
                                }
                            }
                        }
                    }

                    ?>
                    <form action="" method="POST" enctype="multipart/form-data">

                        <div class="pdetail">
                            <div class="f">
                                <!-- <div class="fld img">
                                    <label for="">Post Image</label>
                                    <label for="img" id="drop">
                                        <input type="file" name="emp_image" id="img" hidden>

                                        <div id="img-view">

                                            <i class="fa-solid fa-cloud-arrow-up"></i>
                                            <p>Drag and Drop<br>click here to Upload Image</p>
                                        </div>
                                    </label>
                                </div> -->
                                
                                    <div class="fld fld1">
                                        <label for="">Employee_id</label>
                                        <input type="number" name="emp_uid" id="emp_uid" placeholder="id" required>

                                    </div>
                                    <div class="in">
                                    <div class="fld fld1">
                                        <label for="">First Name</label>
                                        <input type="text" name="emp_first_name" id="first_name" placeholder="Enter Frist Name" required>

                                    </div>


                                    <div class="fld fld1">
                                        <label for="">Last Name</label>
                                        <input type="text" name="emp_last_name" id="last_name" placeholder="Enter Last Name" required>

                                    </div>

                                </div>
                            </div>
                            <div class="f">

                                <div class="fld">
                                    <label for="">Department</label>
                                    <select name="department_id">
                                        <option value="">Select Department</option>

                                        <?php

                                        $select_query = "SELECT * FROM department";
                                        $result_query = pg_query($conn, $select_query);

                                        while ($row = pg_fetch_assoc($result_query)) {
                                            $emp_department_name = $row['department_name'];
                                            $emp_department_id = $row['department_id'];

                                            echo "<option value='$emp_department_id'>$emp_department_name</option>";
                                        }

                                        ?>
                                    </select>
                                </div>

                                <div class="fld">
                                    <label for="">Job post</label>
                                    <select name="job_post_id">
                                        <option value="">Select Job_Post</option>

                                        <?php

                                        $select_query = "SELECT * FROM job_post";
                                        $result_query = pg_query($conn, $select_query);

                                        while ($row = pg_fetch_assoc($result_query)) {
                                            $emp_job_post_id = $row['job_post_id'];
                                            $emp_job_post = $row['job_post_name'];

                                            echo "<option value='$emp_job_post_id'>$emp_job_post</option>";
                                        }

                                        ?>
                                    </select>
                                </div>

                            </div>

                            <div class="f">
                                <div class="fld">
                                    <label for="">Email</label>
                                    <input type="email" name="emp_email" id="email" placeholder="Email@gmail.com" required>

                                </div>
                                <div class="fld">
                                    <label for="">Phone</label>
                                    <input type="number" name="emp_mobile" id="phone" placeholder="Enter Phone Number" required>
                                </div>
                            </div>


                            <div class="fld btn">
                                <input type="submit" value="Register Employee" name="submit" id="submit">
                            </div>
                        </div>
                    </form>

                </section>
            </div>
        </div>
    </div>
    <script src="employee.js"></script>
</body>

</html>