<?php
include('connect.php');
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location: admin_login.php");
}

$department_id = isset($_GET['department_id']) ? (int)$_GET['department_id'] : null;


if ($department_id !== null) {
    $select_query = "SELECT department_id, department_name FROM department WHERE department_id = $department_id";

    $result_query = pg_query($conn, $select_query);
    if(!$result_query){
        die("There is an error" . pg_last_error($conn));
    }

    if ($result_query && (pg_num_rows($result_query) > 0)) {
        $row = pg_fetch_assoc($result_query);
        $existing_department_name = $row['department_name'];
        $existing_department_id = $row['department_id'];
       
    } else {
        echo "<alert>Department not found.</alert>";
        exit();
    }
} else {
    echo "Department ID is missing.";
    exit();
}


if (isset($_POST['submit'])) {
    
    $department_id = $_POST['department_id'];
    $department_name = pg_escape_string($_POST['department_name']);
    
    
    
    $update_query = "UPDATE department SET 
                    department_id = '$department_id',
                    department_name = '$department_name'   
                 WHERE department_id = $existing_department_id"; 

    $result_update = pg_query($conn, $update_query);

    if ($result_update !== false) {
        echo "<script>alert('Department  updated successfully');</script>";
        header("Location: manage_dept.php");
        exit();
    } else {
        echo "Error updating department information: " . pg_last_error($conn);
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
    <title>Edit Training</title>
</head>
<body>
    <?php require_once("navbar.html") ?>
    <div class="main_div">
        <div class="wrapper"></div>
        <section class="pst">
            <header>Edit Department</header>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="pdetail">
                    <div class="f">
                        <div class="fld fld1">
                            <label for="">Department Id</label>
                            <input type="text" name="department_id" id="first_name" placeholder="Enter Department Id" value="<?php echo $existing_department_id; ?>" required>
                        </div>
                        <div class="fld fld1">
                            <label for="">Department Name</label>
                            <input type="text" name="department_name" id="last_name" placeholder="Enter Department Name" value="<?php echo $existing_department_name; ?>" required>
                        </div>
                    </div>
                    
                     
                   
                   
                    <div class="fld btn">
                        <input type="submit" value="Edit Department" name="submit" id="submit">
                    </div>
                </div>
            </form>
        </section>
    </div>
</body>
</html>
