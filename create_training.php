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

    $emp_idx = isset($_POST['emp_id']) ? $_POST['emp_id'] : [];
    if (empty($emp_idx)) {
        echo "<script>alert('Please select at least one employee');</script>";
        // header("location: create_training.php");
        exit();
    }

    $unique_numbers = array_unique($emp_idx);

    $emp_id = array_values($unique_numbers);
    
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
        exit();
    } else {
        pg_query($conn, "BEGIN");

        try {
            $insert = "INSERT INTO create_training_programs (training_program_id, name, training_desc, training_status) VALUES ($training_program_id, '$training_name', '$tr_desc', '$status')RETURNING training_program_id";
            $result_query = pg_query($conn, $insert);

            if (!$result_query) {
                throw new Exception("Error in create_training_programs query: " . pg_last_error($conn));
            }

            $row = pg_fetch_assoc($result_query);
            $training_program_id = $row['training_program_id'];

            if (!empty($_POST['emp_id'])) {
                foreach ($dept_id as $deptlist) {
                    foreach ($job_post_id as $joblist) {
                        foreach ($emp_id as $empid) {
                            $insert1 = "INSERT INTO training_relations(training_program_id,job_post_id,department_id,employee_id) VALUES ( $training_program_id , $joblist , $deptlist, $empid )";
                            $result_query1 = pg_query($conn, $insert1);
                            if (!$result_query1) {
                                throw new Exception("Error in training_relations query: " . pg_last_error($conn));
                            }
                        }
                    }
                }
            }

            foreach ($trainer_id as $trainerlist) {
                $insert2 = "INSERT INTO training_trainer_relation(training_program_id,trainer_id) VALUES ( $training_program_id , $trainerlist )";
                $result_query2 = pg_query($conn, $insert2);
                if (!$result_query2) {
                    throw new Exception("Error in training_trainer_relation query: " . pg_last_error($conn));
                }
            }

            if (!$result_query1) {
                die("Error in training_relations query: " . pg_last_error($conn));
            }
            pg_query($conn, "COMMIT");

            echo "<script>
                alert('New Training Created successfully')
            </script>";
        } catch (Exception $e) {

            pg_query($conn, "ROLLBACK");
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
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
    <title>Create Training</title>
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
    <?php require_once("sidebartr.html") ?>

    <div class="container">
        <div class="wrapperx">
            <section class="pst">
                <header>Create Training</header>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="outform">

                        <div class="pdetail pdx">
                            <div class="fld">
                                <label for="training_program_id">Training Program Id</label>
                                <input type="number" name="training_program_id" id="training_program_id" placeholder="Enter Training id" required>
                            </div>

                            <div class="fld">
                                <label for="training_name">Training Title</label>
                                <input type="text" name="name" id="training_name" placeholder="Enter Training Title" required>
                            </div>

                            <div class="fld">
                                <label for="tr_desc">Training Description</label>
                                <textarea name="tr_desc" id="tr_desc" cols="30" rows="10"></textarea>
                            </div>

                            <div class="fld">
                                <label for="department_id">Department</label>
                                <select name="department_id[]" id="department_id" onchange="fetchdata()" multiple required>

                                    <?php
                                    $select_query = "SELECT * FROM department";
                                    $result_query = pg_query($conn, $select_query);
                                    while ($row = pg_fetch_assoc($result_query)) {
                                        echo "<option value='{$row['department_id']}'>{$row['department_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="fld">
                                <label for="job_post_id">Job Post</label>
                                <select name="job_post_id[]" id="job_post_id" onchange="fetchdata()" multiple required>

                                    <?php
                                    $select_query = "SELECT * FROM job_post";
                                    $result_query = pg_query($conn, $select_query);
                                    while ($row = pg_fetch_assoc($result_query)) {
                                        echo "<option value='{$row['job_post_id']}'>{$row['job_post_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="fld">
                                <label for="trainer_id">Trainer Name</label>
                                <select name="trainer_id[]" id="trainer_id" multiple required>

                                    <?php
                                    $select_query = "SELECT * FROM trainer_records";
                                    $result_query = pg_query($conn, $select_query);
                                    while ($row = pg_fetch_assoc($result_query)) {
                                        echo "<option value='{$row['trainer_id']}'>" . $row['first_name'] . " " . $row['last_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="fld btn">
                                <input type="submit" value="Create Training" name="submit">
                            </div>
                        </div>
                        <div class="outro">
                            <div class="se">
                                <!-- <div class="fld">
                                <label for="employee_search">Search Employees</label>
                                <input type="number" id="employee_search" placeholder="Search by name" onkeyup="searchEmployees()">
                            </div> -->

                                <label for="employee_id">Employees:</label>
                                <div id="employee_checkbox_container"></div>
                            </div>
                            <div class="si">

                                <label for="emp_id">Employee</label>
                                <select name="emp_id[]" id="emp_id" multiple>

                                    <?php
                                    $select_query = "SELECT * FROM employee_records";
                                    $result_query = pg_query($conn, $select_query);
                                    while ($row = pg_fetch_assoc($result_query)) {
                                        echo "<option value='{$row['emp_id']}'>" . $row['emp_uid'] . " : " . $row['emp_first_name'] . " " . $row['emp_middle_name'] . " " . $row['emp_last_name'] . "</option>";
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>

                    </div>
                </form>
            </section>
        </div>
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

            new MultiSelectTag('emp_id');

        });
    </script>
    <script src="manage.js"></script>
    <script>
        function fetchdata() {
            const departmentSelect = document.getElementById('department_id');
            const selectedDepartments = Array.from(departmentSelect.selectedOptions).map(option => option.value);

            const jobPostSelect = document.getElementById('job_post_id');
            const selectedJobPosts = Array.from(jobPostSelect.selectedOptions).map(option => option.value);



            if (selectedDepartments.length === 0 && selectedJobPosts.length === 0 && !searchQuery) {
                document.getElementById('employee_checkbox_container').innerHTML = ''; // Clear employee checkboxes
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'dptemp.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        const employeeCheckboxContainer = document.getElementById('employee_checkbox_container');
                        employeeCheckboxContainer.innerHTML = '';


                        const selectAllCheckbox = document.createElement('input');
                        selectAllCheckbox.type = 'checkbox';
                        selectAllCheckbox.id = 'select_all_employees';
                        selectAllCheckbox.addEventListener('change', function() {
                            const checkboxes = document.querySelectorAll('.employee_checkbox');
                            checkboxes.forEach(checkbox => checkbox.checked = selectAllCheckbox.checked);
                        });
                        employeeCheckboxContainer.appendChild(selectAllCheckbox);
                        employeeCheckboxContainer.appendChild(document.createTextNode(" Select All"));
                        employeeCheckboxContainer.appendChild(document.createElement('br'));
                        employeeCheckboxContainer.appendChild(document.createElement('br'));


                        response.employees.forEach(employee => {
                            const checkboxWrapper = document.createElement('div');
                            const checkbox = document.createElement('input');
                            checkbox.type = 'checkbox';
                            checkbox.name = 'emp_id[]';
                            checkbox.value = employee.emp_id;
                            checkbox.classList.add('employee_checkbox');

                            const label = document.createElement('label');
                            label.textContent = `${employee.emp_first_name} ${employee.emp_middle_name} ${employee.emp_last_name} : ${employee.emp_uid}`;

                            checkboxWrapper.appendChild(checkbox);
                            checkboxWrapper.appendChild(label);
                            employeeCheckboxContainer.appendChild(checkboxWrapper);
                        });
                    } catch (e) {
                        console.error('Failed to parse JSON response:', e);
                    }
                }
            };

            xhr.onerror = function() {
                console.error('Request error');
            };

            // Sending selected departments, job posts, and search term to the server
            var payload = JSON.stringify({
                department_ids: selectedDepartments,
                job_post_ids: selectedJobPosts,

            });

            xhr.send(payload);
        }
    </script>

</body>

</html>