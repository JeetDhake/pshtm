<?php
include('connect.php');
session_start();
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['trainer_id']) && !isset($_SESSION['emp_id'])) {
    header("location: user_login.php");
}

$emp_id = $_GET['emp_id'];
$training_program_id = $_GET['training_program_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/b9323f08fd.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/view_form.css">

    <title>View Form</title>
</head>

<body>

    <div class="bxp container">
        <div class="console">
            <div class="outin">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div id="output1" class="outp1">
                        <div class="inpbx">
                            <label for="">Employee name</label>

                            <?php
                            $select_query = "SELECT * FROM employee_records WHERE emp_id = $emp_id";
                            $result_query = pg_query($conn, $select_query);

                            while ($row = pg_fetch_assoc($result_query)) {
                                $emp_first_name = $row['emp_first_name'];
                                $emp_last_name = $row['emp_last_name'];
                                $emp_id = $row['emp_id'];

                                echo "<p>" . $emp_first_name . " " . $emp_last_name . "</p>";
                            }

                            ?>

                        </div>
                        <div class="inpbx">
                            <label for="">Employee id</label>

                            <?php
                            $select_query = "SELECT * FROM employee_records WHERE emp_id = $emp_id";
                            $result_query = pg_query($conn, $select_query);

                            while ($row = pg_fetch_assoc($result_query)) {
                                $emp_first_name = $row['emp_first_name'];
                                $emp_last_name = $row['emp_last_name'];
                                $emp_uid = $row['emp_uid'];

                                echo "<p>" . $emp_uid . "</p>";
                            }

                            ?>

                        </div>

                        <?php
    if (isset($_GET['training_program_id'])) {

        $tr_id = $_GET['training_program_id'];

        $select_query = "SELECT * FROM questions WHERE training_program_id=$tr_id";
        $result_query = pg_query($conn, $select_query);

        while ($row = pg_fetch_assoc($result_query)) {

            $tr_id = $row['training_program_id'];
            $ques_id = $row['ques_id'];
            $question = $row['que_text'];

            $opt_tx1 = $row['option_1'];
            $opt_tx2 = $row['option_2'];
            $opt_tx3 = $row['option_3'];
            $opt_tx4 = $row['option_4']; 

            $sql = "SELECT * FROM post_student_ans WHERE emp_id=$emp_id AND ques_id = $ques_id";
            $result = pg_query($conn, $sql);

            while ($rowx = pg_fetch_assoc($result)) {
                $answer = $rowx['post_student_ans'];
            

                echo '
                <div class="inpbx">
                    <label for="">' . $question . '</label>
                    <p> a) ' . $opt_tx1 . '</p>
                    <p> b) ' . $opt_tx2 . '</p>
                    <p> c) ' . $opt_tx3 . '</p>
                    <p> d) ' . $opt_tx4 . '</p>
                    <br>
                    <p>User Answer: ' . $answer . '</p>
                </div>
                ';
            }
        }
    }

    ?>

                    </div>

                </form>
            </div>

        </div>
    </div>

</body>

</html>