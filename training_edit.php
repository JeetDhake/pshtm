<?php
include('connect.php');

session_start();
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['trainer_id'])) {
    header("location: admin_login.php");
}

$tr_id = $_GET['training_program_id'];

$insert = "SELECT * FROM create_training_programs WHERE training_program_id=$tr_id";
$result_query = pg_query($conn, $insert);

while($rowx = pg_fetch_assoc($result_query)){
    $tr_id_old = $rowx['training_program_id'];
    $tr_name_old = $rowx['name'];
    $tr_desc_old = $rowx['training_desc'];
}

if (isset($_POST['submit'])) {

    $training_name_nw = pg_escape_string($_POST['name']);
    $tr_desc_nw = pg_escape_string($_POST['tr_desc']);



    $status = "true";
    if ($training_name_nw == '' || $tr_desc_nw == '' ) {
        echo "<script>
            alert('enter all fields')
            </script>";
        exit();
    } else {

        $insert = "UPDATE create_training_programs SET name='$training_name_nw', training_desc='$tr_desc_nw' WHERE training_program_id = $tr_id_old ";
        $result_query = pg_query($conn, $insert);

        if (!$result_query) {
            die("Error in create_training_programs query: " . pg_last_error($conn));
        }
        else{
            echo "<script>
            alert('Updated Successfully')
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
    <link rel="stylesheet" href="style/multi-select-tag.css">

    <title>Update training</title>
</head>

<body>
    <?php require_once("navbar.html") ?>
    <?php require_once("sidebartr.html") ?>

    <div class="container">

        <div class="wrapper" id="">
            <section class="pst">
                <header>
                    Update Training 
                </header>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="pdetail">

                        <div class="fld">
                            <label for="">Training Title</label>
                            <input type="text" name="name" id="training_name" placeholder="Enter Training Title" value="<?php echo $tr_name_old; ?>" required>
                        </div>

                        <div class="fld">
                            <label for="">Training Description</label>
                            <textarea name="tr_desc" id="tr_desc" cols="30" rows="10"  placeholder="<?php echo $tr_desc_old; ?>" value="<?php echo $tr_desc_old; ?>"></textarea>

                        </div>


                        <div class="fld btn">
                            <input type="submit" value="Update Training" name="submit" id="submit">
                        </div>
                    </div>
                </form>
            </section>
        </div>

    </div>
    <script src="multi-select-tag.js"></script>
    <script>
        new MultiSelectTag('department_id')
        new MultiSelectTag('job_post_id')
        new MultiSelectTag('trainer_id')
    </script>
    <script src="manage.js"></script>
</body>

</html>