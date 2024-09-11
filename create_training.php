<?php

include('connect.php');
session_start();
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['trainer_id'])) {
    header("location: admin_login.php");
}
if (isset($_POST['submit'])) {

    $training_program_id = $_POST['training_program_id'];
    $training_name = pg_escape_string($_POST['name']);
    $tr_desc = pg_escape_string($_POST['tr_desc']);

    $dept_id = $_POST['department_id'];
    $job_post_id = $_POST['job_post_id'];

    $trainer_id = $_POST['trainer_id'];

    $status = "true";
    $check = "SELECT * FROM create_training_programs WHERE training_program_id = $training_program_id";
    $result_check = pg_query($conn, $check);
    if ($training_program_id == '' || $training_name == '' || $tr_desc == '' ||  $dept_id == '' || $job_post_id == '' || $status == '' || $trainer_id == '') {
        echo "<script>
            alert('enter all fields')
            </script>";
        exit();
    } else if(pg_num_rows($result_check) > 0){
        echo "<script>
            alert('Id already exists')
            </script>";
    } else {

        $insert = "INSERT INTO create_training_programs (training_program_id, name, training_desc, training_status) VALUES ($training_program_id, '$training_name', '$tr_desc', '$status')RETURNING training_program_id";
        $result_query = pg_query($conn, $insert);

        if (!$result_query) {
            die("Error in create_training_programs query: " . pg_last_error($conn));
        }

        $row = pg_fetch_assoc($result_query);
        $training_program_id = $row['training_program_id'];


        foreach ($dept_id as $deptlist) {
            foreach ($job_post_id as $joblist) {
                $insert1 = "INSERT INTO training_relations(training_program_id,job_post_id,department_id) VALUES ( $training_program_id , $joblist , $deptlist )";
                $result_query1 = pg_query($conn, $insert1);
            }
        }

        foreach ($trainer_id as $trainerlist) {
            $insert2 = "INSERT INTO training_trainer_relation(training_program_id,trainer_id) VALUES ( $training_program_id , $trainerlist )";
            $result_query2 = pg_query($conn, $insert2);
        }

        if (!$result_query1) {
            die("Error in training_relations query: " . pg_last_error($conn));
        }

        if ($result_query && $result_query1 && $result_query2) {

            echo "<script>
                alert('New Training Created successfully')
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
    <link rel="stylesheet" href="style/sidebar.css">
    <link rel="stylesheet" href="style/multi-select-tag.css">

    <title>create training</title>
</head>

<body>
    <?php
if (isset($_SESSION['admin_id'])) {
    require_once("navbar.html");
}
if(isset($_SESSION['trainer_id'])) {
    require_once("navbar2.html");
}
?>
    <?php require_once("sidebartr.html") ?>

    <div class="container">

        <div class="wrapper" id="">
            <section class="pst">
                <header>
                    Create Training
                </header>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="pdetail">
                        <div class="fld">
                            <label for="">Training Program Id</label>
                            <input type="text" name="training_program_id" id="training_program_id" placeholder="Enter Training id" required>
                        </div>

                        <div class="fld">
                            <label for="">Training Title</label>
                            <input type="text" name="name" id="training_name" placeholder="Enter Training Title" required>
                        </div>

                        <div class="fld">
                            <label for="">Training Description</label>
                            <textarea name="tr_desc" id="tr_desc" cols="30" rows="10"></textarea>

                        </div>

                        <div class="fld">
                            <label for="">Department</label>
                            <select name="department_id[]" id="department_id" multiple>
                                <option value="">Select Department</option>

                                <?php

                                $select_query = "SELECT * FROM department";
                                $result_query = pg_query($conn, $select_query);

                                while ($row = pg_fetch_assoc($result_query)) {
                                    $dept_name = $row['department_name'];
                                    $dept_id = $row['department_id'];

                                    echo "<option value='$dept_id'>$dept_name</option>";
                                }

                                ?>
                            </select>
                        </div>

                        <div class="fld">
                            <label for="">Job Post</label>
                            <select name="job_post_id[]" id="job_post_id" multiple>
                                <option value="">Select jobpost</option>

                                <?php

                                $select_query = "SELECT * FROM job_post";
                                $result_query = pg_query($conn, $select_query);

                                while ($row = pg_fetch_assoc($result_query)) {
                                    $job_post_name = $row['job_post_name'];
                                    $job_post_id = $row['job_post_id'];

                                    echo "<option value='$job_post_id'> $job_post_name</option>";
                                }

                                ?>
                            </select>
                        </div>



                        <div class="fld">
                            <label for="">Trainer Name</label>
                            <select name="trainer_id[]" id="trainer_id" multiple>
                                <option value="">Select trainers</option>

                                <?php

                                $select_query = "SELECT * FROM trainer_records";
                                $result_query = pg_query($conn, $select_query);

                                while ($row = pg_fetch_assoc($result_query)) {
                                    $first_name = $row['first_name'];
                                    $last_name = $row['last_name'];
                                    $trainer_id = $row['trainer_id'];

                                    echo "<option value='$trainer_id'>" . $first_name . " " . $last_name . "</option>";
                                }

                                ?>
                            </select>
                        </div>

                        <div class="fld btn">
                            <input type="submit" value="Create Training" name="submit" id="submit">
                        </div>
                    </div>
                </form>
            </section>
        </div>

    </div>
    <script src="multi-select-tag.js"></script>
    <script>
        new MultiSelectTag('department_id');
        new MultiSelectTag('job_post_id');
        new MultiSelectTag('trainer_id');
    </script>
    <script src="manage.js"></script>
</body>

</html>