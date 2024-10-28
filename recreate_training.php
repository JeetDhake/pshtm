<?php

include('connect.php');
session_start();
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['trainer_id'])) {
    header("location: admin_login.php");
}
if (isset($_POST['submit'])) {


    $training_program_id = $_POST['training_program_id'];
    $template_training_id = $_POST['template_training_id'];

    $query1 = "SELECT * FROM create_training_programs WHERE training_program_id = $template_training_id";
    $result1 = pg_query($conn, $query1);

    while ($row1 = pg_fetch_assoc($result1)) {
        $tr_desc = $row1['training_desc'];
        $training_name = $row1['name'];
    }

    $dept_id = $_POST['department_id'];
    $job_post_id = $_POST['job_post_id'];
    $emp_id = $_POST['emp_id'];
    $trainer_id = $_POST['trainer_id'];

    $status = "true";
    $check = "SELECT * FROM create_training_programs WHERE training_program_id = $training_program_id";
    $result_check = pg_query($conn, $check);

    if ($training_program_id == '' || $training_name == '' || $tr_desc == '' ||  $dept_id == '' || $job_post_id == '' || $status == '' || $trainer_id == '') {
        echo "<script>
            alert('enter all fields')
            </script>";
        exit();
    } else if (pg_num_rows($result_check) > 0) {
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

        //$template_training_id
        $fquery = "SELECT * FROM questions WHERE training_program_id = $template_training_id";
        $fres = pg_query($conn, $fquery);
        while ($rowf = pg_fetch_assoc($fres)) {

            $q_tx = $rowf['que_text'];
            $input_type = $rowf['ques_type'];
            $ans = $rowf['answer'];
            $opt1 = $rowf['option_1'];
            $opt2 = $rowf['option_2'];
            $opt3 = $rowf['option_3'];
            $opt4 = $rowf['option_4'];

            $insert_q = pg_query($conn, "INSERT INTO questions (que_text, training_program_id, ques_type, answer, option_1, option_2, option_3, option_4) 
            VALUES ( '$q_tx', $training_program_id, '$input_type', '$ans', '$opt1', '$opt2', '$opt3', '$opt4')");
        }


        foreach ($dept_id as $deptlist) {
            foreach ($job_post_id as $joblist) {
                foreach ($emp_id as $empid) {
                    $insert1 = "INSERT INTO training_relations(training_program_id,job_post_id,department_id,employee_id) VALUES ( $training_program_id , $joblist , $deptlist, $empid )";
                    $result_query1 = pg_query($conn, $insert1);
                }
            }
        }

        foreach ($trainer_id as $trainerlist) {
            $insert2 = "INSERT INTO training_trainer_relation(training_program_id,trainer_id) VALUES ( $training_program_id , $trainerlist )";
            $result_query2 = pg_query($conn, $insert2);
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

    <title>recreate training</title>
</head>

<body>
    <?php
    if (isset($_SESSION['admin_id'])) {
        require_once("navbar.html");
    }
    if (isset($_SESSION['trainer_id'])) {
        require_once("navbar2.html");
    }
    ?>
    <?php require_once("navbar.html") ?>
    <?php require_once("sidebartr.html") ?>

    <div class="container">

        <div class="wrapper" id="">
            <section class="pst">
                <header>
                    reCreate Training
                </header>

                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="pdetail">
                        <div class="fld">
                            <label for="">Training Program Id</label>
                            <input type="text" name="training_program_id" id="training_program_id" placeholder="Enter New Training Id" required>
                        </div>

                        <div class="fld">
                            <label for="">Training</label>
                            <select name="template_training_id" id="template_training_id">
                                <option value="">Select Training</option>
                                <?php

                                $select_q = "SELECT DISTINCT training_program_id FROM questions";
                                $result_q = pg_query($conn, $select_q);
                                while ($rowx = pg_fetch_assoc($result_q)) {
                                    $train_id = $rowx['training_program_id'];

                                    $select_q1 = "SELECT * FROM create_training_programs WHERE training_program_id = $train_id";
                                    $result_q1 = pg_query($conn, $select_q1);
                                    while ($rowy = pg_fetch_assoc($result_q1)) {
                                        $name = $rowy['name'];
                                        $id = $rowy['training_program_id'];

                                        echo "<option value='$train_id'>$name</option>";
                                    }
                                }


                                ?>
                            </select>
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
                        <p>The Questionnaire will be same as selected training</p>
                    </div>
       
            </section>
        </div>
        <div class="se">


            <label for="employee_id">Employees:</label>
            <select id="emp_id" name="emp_id[]" multiple>

            </select>


        </div>
        </form>
    </div>
    <script src="multi-select-tag.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
            new MultiSelectTag('department_id', {
                onChange: () => {
                    fetchdata();
                }
            });



            new MultiSelectTag('job_post_id', {
                onChange: () => {
                    fetchdata();
                }
            });
            new MultiSelectTag('trainer_id');
        });
    </script>
    <script src="manage.js"></script>

    <script>
function fetchdata() {
    const departmentSelect = document.getElementById('department_id');
    const selectedDepartments = Array.from(departmentSelect.selectedOptions).map(option => option.value);

    const jobPostSelect = document.getElementById('job_post_id');
    const selectedJobPosts = Array.from(jobPostSelect.selectedOptions).map(option => option.value);

    console.log("Selected Departments:", selectedDepartments);
    console.log("Selected Job Posts:", selectedJobPosts);

    if (selectedDepartments.length === 0 && selectedJobPosts.length === 0) {
        document.getElementById('emp_id').innerHTML = '';
        return;
    }

    var xhr = new XMLHttpRequest();

    xhr.open('POST', 'dptemp.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            try {
                var response = JSON.parse(xhr.responseText);
                console.log("Response Data:", response); 

                const employeeSelect = document.getElementById('emp_id');
                employeeSelect.innerHTML = ''; 

                const employees = response.employees;

                if (Array.isArray(employees) && employees.length > 0) {
                    employees.forEach(employee => {
                        const option = document.createElement('option');
                        option.value = employee.emp_id;
                        option.textContent = `${employee.emp_first_name} ${employee.emp_middle_name} ${employee.emp_last_name}`;
                        employeeSelect.appendChild(option);
                    });
                } else {
                    console.log('No employees found in the response.');
                }
            } catch (e) {
                console.error('Failed to parse JSON response:', e);
                console.log('Raw response:', xhr.responseText); 
            }
        } else {
            console.error('Request failed with status:', xhr.status);
            console.log('Response text:', xhr.responseText); 
        }
    };

    xhr.onerror = function() {
        console.error('Request error');
    };

    var payload = JSON.stringify({
        department_ids: selectedDepartments,
        job_post_ids: selectedJobPosts
    });

    xhr.send(payload);
}

    </script>
</body>

</html>