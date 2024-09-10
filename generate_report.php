
<?php

include('connect.php');
session_start();
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['trainer_id'])) {
    header("location: admin_login.php");
}
if (isset($_POST['submit'])) {

    $training_program_id = $_POST['training_program_id'];
    $emp_id = $_POST['emp_id'];
    $employee_performance = $_POST['employee_performance'];

    $questionnaire1_result = $_POST['questionnaire1_result'];
    $questionnaire2_result = $_POST['questionnaire2_result'];

    if ($training_program_id == '' || $emp_id == '' || $employee_performance == '' || $questionnaire1_result == '' || $questionnaire2_result == '') {
        echo "<script>
            alert('enter all fields')
            </script>";
        exit();
    } else {

        $insert = "INSERT INTO employee_reports (emp_id, training_program_id, employee_performance, questionnaire1_result, questionnaire2_result) VALUES ('$emp_id', '$training_program_id', '$employee_performance', '$questionnaire1_result' , '$questionnaire2_result')";
        $result_query = pg_query($conn, $insert);

        if (!$result_query) {
            die("Error: " . pg_last_error($conn));
        }
        else {

            echo "<script>
                alert('Report Generated successfully')
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

    <title>Generate report</title>
</head>

<body>
    <?php require_once("navbar.html") ?>
    <?php require_once("sidebartr.html") ?>

    <div class="container">

        <div class="wrapper" id="">
            <section class="pst">
                <header>
                    Employee Report
                </header>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="pdetail">

                        <div class="fld">

                            <label for="">Training Title</label>
                            <select name="training_program_id">
                                <option value="">Select Training</option>

                                <?php

                                $select_query = "SELECT * FROM create_training_programs";
                                $result_query = pg_query($conn, $select_query);

                                while ($row = pg_fetch_assoc($result_query)) {
                                    $training_program_id = $row['training_program_id'];
                                    $training_name = $row['name'];

                                    echo "<option value='$training_program_id'>$training_name</option>";
                                }

                                ?>
                            </select>
                        </div>

                        <div class="fld">

                        </div>

                        <div class="fld">
                            <label for="">employee</label>
                            <select name="emp_id" id="emp_id">
                                <option value="">Select Employees</option>

                                <?php

                                $select_query = "SELECT * FROM employee_records";
                                $result_query = pg_query($conn, $select_query);

                                while ($row = pg_fetch_assoc($result_query)) {
                                    $employee_first_name = $row['emp_first_name'];
                                    $employee_last_name = $row['emp_last_name'];
                                    $employee_id = $row['emp_id'];

                                    echo "<option value='$employee_id'>$employee_first_name $employee_last_name</option>";
                                }

                                ?>
                            </select>
                        </div>

                        <div class="f">
                            <div class="fld">
                                <label for="">pre_questionnaire result</label>
                                <input type="number" name="questionnaire1_result" id="questionnaire1_result" placeholder="Enter pre_questionnaire result" required>
                            </div>
                            <div class="fld">
                                <label for="">post_questionnaire result</label>
                                <input type="number" name="questionnaire2_result" id="questionnaire2_result" placeholder="Enter post_questionnaire result" required>
                            </div>

                        </div>
                        <div class="fld">
                                <label for="">performance</label>
                                <input type="number" name="employee_performance" id="employee_performance" placeholder="Enter performance" required>
                            </div>
                        
                        <div class="fld btn">
                            <input type="submit" value="Generate Report" name="submit" id="submit">
                        </div>
                    </div>
                </form>
            </section>
        </div>

    </div>
  
    <script src="manage.js"></script>
</body>

</html>