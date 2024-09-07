<?php
include('connect.php');
session_start();
if (!isset($_SESSION['emp_id'])) {
    header("location: user_login.php");
}
$emp_id = $_SESSION['emp_id'];

$sql = "SELECT * FROM employee_records WHERE emp_id = $emp_id";
$res = pg_query($conn, $sql);
while ($row = pg_fetch_assoc($res)) {
    $e_deptid = $row['department_id'];
    $e_jpid = $row['job_post_id'];
}
$sql5 = "SELECT * FROM department WHERE department_id = $e_deptid";
$res5 = pg_query($conn, $sql5);
while ($row5 = pg_fetch_assoc($res5)) {
    $dept = $row5['department_name'];
}

$sql11 = "SELECT * FROM job_post WHERE job_post_id = $e_jpid";
$res11 = pg_query($conn, $sql11);
while ($row11 = pg_fetch_assoc($res11)) {

    $jp = $row11['job_post_name'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/b9323f08fd.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/home.css">

    <title>pshtm</title>
</head>

<body>
    <?php require_once("user_navbar.php") ?>
    <div class="container">
        <div class="wrapper">

            <?php
            $sql1 = "SELECT DISTINCT training_program_id FROM training_relations WHERE department_id = $e_deptid OR job_post_id = $e_jpid";
            $res1 = pg_query($conn, $sql1);
            if ($res1) {
                while ($row1 = pg_fetch_assoc($res1)) {
                    $tr_id = $row1['training_program_id'];

                    $sql2 = "SELECT * FROM create_training_programs WHERE training_program_id = $tr_id";
                    $res2 = pg_query($conn, $sql2);
                    if ($res2) {
                        while ($row2 = pg_fetch_assoc($res2)) {
            ?>


                            <div class="train" id="<?php echo $tr_id; ?>">
                                <div class="cont">
                                    <div class="lf">
                                        <h2><?php echo $row2['name']; ?></h2>
                                        
                                        <p>Description: </p>
                                        <h4><?php echo $row2['training_desc']; ?></h4>
                                    </div>
                                    <div class="rg">
                                        <button onclick ="action('pre', <?php echo $tr_id; ?>)" class="btnx">Pre Exam</button>
                                        <button onclick = "action('post', <?php echo $tr_id; ?>)" class="btnx">Post Exam</button>
                                    </div>
                                </div>
                            </div>


            <?php
                        }
                    }
                }

                if (pg_num_rows($res1) == 0) {
                    echo "No Current Training";
                }
            }
            ?>
        </div>
    </div>
    <script>
        function action(type, tr_id) {
            const emp_id = <?php echo $emp_id; ?>;
            const url = `exam.php?emp_id=${encodeURIComponent(emp_id)}&prepost=${encodeURIComponent(type)}&tr_id=${encodeURIComponent(tr_id)}`;

            window.location.href = url;
        }
    </script>
</body>


</html>