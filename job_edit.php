<?php
include('connect.php');


$job_post_id = isset($_GET['job_post_id']) ? (int)$_GET['job_post_id'] : null;


if ($job_post_id !== null) {
    $select_query = "SELECT job_post_name, job_post_id FROM job_post WHERE job_post_id=$job_post_id";

    $result_query = pg_query($conn, $select_query);

    if ($result_query && pg_num_rows($result_query) > 0) {
        $row = pg_fetch_assoc($result_query);
        $existing_job_post_name = $row['job_post_name'];
        $existing_job_post_id = $row['job_post_id'];   
       
    } else {
        echo "Job Post not found.";
        exit();
    }
} else {
    echo "Job Post ID is missing.";
    exit();
}


if (isset($_POST['submit'])) {
    $job_post_name = pg_escape_string($_POST['job_post_name']);
    $job_post_id = $_POST['job_post_id'];

   
    

    
    $update_query = "UPDATE job_post
    SET job_post_name = '$job_post_name'  
    WHERE job_post_id = $job_post_id";


    $result_update = pg_query($conn, $update_query);

    if ($result_update !== false) {
        echo "<script>alert('Training records updated successfully');</script>";
        header("Location: manage_job.php");
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
    <title>Edit Training</title>
</head>
<body>
    <?php require_once("navbar.html") ?>
    <div class="main_div">
        <div class="wrapper"></div>
        <section class="pst">
            <header>Edit Job Post</header>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="pdetail">
                    <div class="">
                        
                        <div class="fld fld1">
                            <label for="">Job Post Name</label>
                            <input type="text" name="job_post_name" id="last_name" placeholder="Enter Job Post Name" value="<?php echo $existing_job_post_name; ?>" required>
                        </div>
                    </div>
                     
                    <div class="f">
                        
                        
                    </div>

                   
                    <div class="fld btn">
                        <input type="submit" value="Edit Job Post" name="submit" id="submit">
                    </div>
                </div>
            </form>
        </section>
    </div>
</body>
</html>
