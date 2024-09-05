<?php
include('connect.php');

$employee_id = isset($_GET['emp_id']) ? (int)$_GET['emp_id'] : null;

if ($employee_id !== null) {
    $select_query = "SELECT * FROM employee_records WHERE emp_id = $employee_id";
    $result_query = pg_query($conn, $select_query);

    if ($result_query && pg_num_rows($result_query) > 0) {
        $row = pg_fetch_assoc($result_query);
        $existing_emp_first_name = $row['emp_first_name'];
        $existing_emp_last_name = $row['emp_last_name'];
       
        $existing_emp_email = $row['emp_email'];
        $existing_emp_phone = $row['emp_mobile'];
        $existing_emp_image = $row['emp_image'];
    } else {
        echo "Employee not found.";
        exit();
    }
} else {
    echo "Employee ID is missing.";
    exit();
}

if (isset($_POST['submit'])) {
    $emp_first_name = pg_escape_string($_POST['emp_first_name']);
    $emp_last_name = pg_escape_string($_POST['emp_last_name']);
    $emp_department = $_POST['emp_department_id'];
    $emp_job_post = $_POST['emp_job_post_id'];
    $emp_email = $_POST['emp_email'];
    $emp_phone = $_POST['emp_mobile'];

    $update_query = "UPDATE employee_records SET 
        emp_first_name = '$emp_first_name',
        emp_last_name = '$emp_last_name',
        department_id = '$emp_department',
        job_post_id = '$emp_job_post',
        emp_email = '$emp_email',
        emp_mobile = '$emp_phone'
        WHERE emp_id = $employee_id";

    $result_update = pg_query($conn, $update_query);

    if ($result_update !== false) {
        echo "<script>alert('Employee information updated successfully');</script>";
        header("Location: employee_all.php");
        exit();
    } else {
        echo "Error updating employee information: " . pg_last_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/b9323f08fd.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/edit.css">

    <title>Edit Employee</title>
</head>

<body>
    <?php require_once("navbar.html") ?>
    <div class="apf">
        <div class="wrapper">
        <section class="pst">
            <header>Edit Employee</header>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="pdetail">
                    <div class="f">
                        <div class="fld fld1">
                            <label for="">First Name</label>
                            <input type="text" name="emp_first_name" id="first_name" placeholder="Enter First Name" value="<?php echo $existing_emp_first_name; ?>" required>
                        </div>
                        <div class="fld fld1">
                            <label for="">Last Name</label>
                            <input type="text" name="emp_last_name" id="last_name" placeholder="Enter Last Name" value="<?php echo $existing_emp_last_name; ?>" required>
                        </div>
                    </div>
                    
                    <div class="f">

                                <div class="fld">
                                    <label for="">Department</label>
                                    <select name="emp_department_id">
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
                                    <select name="emp_job_post_id">
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
                            <input type="email" name="emp_email" id="email" placeholder="Email@gmail.com" value="<?php echo $existing_emp_email; ?>" required>
                        </div>
                        <div class="fld">
                            <label for="">Phone</label>
                            <input type="number" name="emp_mobile" id="phone" placeholder="Enter Phone Number" value="<?php echo $existing_emp_phone; ?>" required>
                        </div>
                    </div>
                    <div class="fld btn">
                        <input type="submit" value="Edit Employee" name="submit" id="submit">
                    </div>
                </div>
            </form>
        </section>
    </div>
    </div>
</body>

</html>