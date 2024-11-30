<?php
//insert in training report new and training img pending replace code
include('connect.php');
session_start();
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['trainer_id'])) {
    header("location: admin_login.php");
}


if (isset($_POST['submit'])) {

    $training_program_id = $_POST['training_program_id'];

    // $start_date = $_POST['start_date'];
    // $end_date = $_POST['end_date'];

    $attendance = $_POST['attendance'];
    $participation = $_POST['participation'];
    $completion_rate = $_POST['completion_rate'];


    $tr_image = $_FILES['tr_image']['name'];
    $tmp_image = $_FILES['tr_image']['tmp_name'];

    $fileextention = explode('.', $tr_image);
    $fileactext = strtolower(end($fileextention));
    $filenewname = uniqid('', true) . "." . $fileactext;

    if ($training_program_id == '' || $attendance == '' || $completion_rate == '' || $participation == '') {
        echo "<script>
            alert('enter all fields')
            </script>";
        exit();
    } else {
        $today = date('d-m-Y');

        $insert = "INSERT INTO training_reports (training_program_id, attendance, participation, completion_rate, date) VALUES ('$training_program_id', '$attendance', '$participation','$completion_rate','$today')RETURNING training_program_id";
        $result_query = pg_query($conn, $insert);

        if (!$result_query) {
            die("Error : " . pg_last_error($conn));
        }

        $row = pg_fetch_assoc($result_query);

        $training_program_id = $row['training_program_id'];

        move_uploaded_file($tmp_image, "db_img2/$filenewname");

        $insert_img = "INSERT INTO training_images (training_program_id, image)VALUES ($training_program_id,'$filenewname')";
        $result_query2 = pg_query($conn, $insert_img);
        if (!$result_query2) {
            die("Error: " . pg_last_error($conn));
        }
if(isset($_SESSION['admin_id'])){
        $idid = $_SESSION['admin_id'];
        if ($idid == 911) {
            $emp_id = $_POST['employee_id'];
            $query = "SELECT 
            AVG(employee_performance) AS avg_emp_perf,
            AVG(questionnaire1_result) AS avg_que1_res,
            AVG(questionnaire2_result) AS avg_que2_res
          FROM employee_reports WHERE training_program_id = $training_program_id";
            $result_avg = pg_query($conn, $query);
            $avgrow = pg_fetch_assoc($result_avg);

            $avg_p = (int)$avgrow['avg_emp_perf'];
            $avg_1 = (int)$avgrow['avg_que1_res'];
            $avg_2 = (int)$avgrow['avg_que2_res'];


            foreach ($emp_id as $emplist) {
                $insert1 = "INSERT INTO employee_reports (emp_id, training_program_id, employee_performance, questionnaire1_result, questionnaire2_result)
                        VALUES ($emplist, $training_program_id, '$avg_p', '$avg_1', '$avg_2') ";
                $res = pg_query($conn, $insert1);
            }
        }
    }
        if ($result_query && $result_query2) {

            echo "<script>
                alert('Training Ended successfully')
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
    <link rel="stylesheet" href="style/end_tr.css">
    <link rel="stylesheet" href="style/multi-select-tag.css">

    <title>end a training</title>
</head>

<body>
<?php
    if (isset($_SESSION['admin_id'])) {
        require_once("navbar.html");
    }
    elseif (isset($_SESSION['trainer_id'])) {
        require_once("navbar2.html");
    }
    ?>
    <?php require_once("sidebartr.html") ?>

    <div class="container">

        <div class="wrapper" id="">
            <section class="pst">
                <header>
                    Finish Training

                </header>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="pdetail">

                        <div class="fld">

                        </div>

                        <div class="fld">
                            <label for="">Training Title</label>
                            <select name="training_program_id">
                                <option value="">Select Training</option>

                                <?php


                                $select_query = "SELECT s.training_program_id, s.name
FROM create_training_programs s
WHERE s.training_program_id NOT IN (
    SELECT p.training_program_id
    FROM training_reports p
);";
                                $result_query = pg_query($conn, $select_query);

                                while ($row = pg_fetch_assoc($result_query)) {
                                    $training_program_id = $row['training_program_id'];
                                    $training_name = $row['name'];

                                    echo "<option value='$training_program_id'>$training_name</option>";
                                }


                                ?>
                            </select>
                        </div>


                        <!-- <div class="f">
                            <div class="fld">
                                <label for="">Start Date</label>
                                <input type="date" name="start_date" id="start_date" placeholder="Enter No Of Days" required>
                            </div>

                            <div class="fld">
                                <label for="">End Date</label>
                                <input type="date" name="end_date" id="end_date" placeholder="Enter No Of Days" required>
                            </div>

                        </div> -->
                        <?php
                        if(isset($_SESSION['admin_id'])){
                            $idid = $_SESSION['admin_id'];

                            if ($idid == 911) {
                        
                        

                        ?>
                            <div class="fld">
                                <label for="">Auto report Gen</label>
                                <select name="employee_id[]" id="employee_id" multiple>
                                    <option value="">Select Employees</option>

                                    <?php

                                    $select_query = "SELECT * FROM employee_records";
                                    $result_query = pg_query($conn, $select_query);

                                    while ($row = pg_fetch_assoc($result_query)) {
                                        $first_name = $row['emp_first_name'];
                                        $last_name = $row['emp_last_name'];
                                        $emp_id = $row['emp_id'];
                                        $emp_uid = $row['emp_uid'];

                                        echo "<option value='$emp_id'>" . $emp_uid . ": " . $first_name . " " . $last_name . "</option>";
                                    }

                                    ?>
                                </select>
                            </div>
                        <?php
                            }
                        }
                        ?>
                        <div class="f">
                            <div class="fld">
                                <label for="">Attendance</label>
                                <input type="number" name="attendance" id="attendance" placeholder="Enter Attendance in percentage%" required>
                            </div>
                            <div class="fld">
                                <label for="">Participation</label>
                                <input type="number" name="participation" id="participation" placeholder="Enter participation rate%" required>
                            </div>

                        </div>
                        <div class="fld">
                            <label for="">completion rate</label>
                            <input type="number" name="completion_rate" id="completion_rate" placeholder="Enter completion rate%" required>
                        </div>
                        <div class="fld img">
                            <label for="">Post Image</label>
                            <label for="img" id="drop">
                                <input type="file" name="tr_image" accept="image/*" capture="environment" id="img" hidden>

                                <div id="img-view">

                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <p>Drag and Drop<br>click here to Upload Image</p>
                                </div>
                            </label>
                        </div>

                        <div class="fld btn">
                            <input type="submit" value="Finish Training" name="submit" id="submit">
                        </div>
                    </div>
                </form>
            </section>
        </div>

    </div>
    <script src="multi-select-tag.js"></script>
    <script src="employee.js"></script>
    <script>
        new MultiSelectTag('employee_id');
    </script>
    <script src="manage.js"></script>
</body>

</html>