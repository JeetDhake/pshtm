<?php
include('connect.php');
session_start();
if (!isset($_SESSION['emp_id'])) {
    header("location: user_login.php");
}
$empid = $_SESSION['emp_id'];

if (isset($_GET['tr_id'])) {
    $tr_id = $_GET['tr_id'];
    $sqlx = pg_query($conn, "SELECT * FROM create_training_programs WHERE training_program_id = $tr_id");
    if (pg_num_rows($sqlx) > 0) {
        $rowx = pg_fetch_assoc($sqlx);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/b9323f08fd.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/view_form.css">

    <title>Exam Form</title>
</head>

<body>
    <?php
    $flag = false;
    if (isset($_GET['prepost'])) {

        $xam = $_GET['prepost'];

        if ($xam == "post") {
            $sqly = "SELECT * FROM employee_reports WHERE employee_performance IS NULL AND emp_id = $empid AND training_program_id = $tr_id";
            $resy = pg_query($conn, $sqly);
            if (pg_num_rows($resy) > 0) {
                //can give post
                $flag = true;
            }
        }

        if ($xam == "pre") {
            $sqly = "SELECT COUNT(*) AS total FROM employee_reports WHERE emp_id = $empid AND training_program_id = $tr_id";
            $resy = pg_query($conn, $sqly);

            $rowy = pg_fetch_assoc($resy);
            if ($rowy['total'] == 0) {
                //can give pre
                $flag = true;
            }
        }
    }
    ?>
    <div class="bxp container">
        <div class="console">
            <div class="outin">
                <?php
                if ($flag) {

                ?>

                    <form action="" method="POST" enctype="multipart/form-data">
                        <div id="output1" class="outp1">
                            <div class="inpbx">
                                <label for=""><?php echo $rowx['name']; ?></label>
                            </div>
                            <!-- <div class="inpbx">
                            <label for="">Employee id</label>

                            <select name="empid">
                                <option value="">Select employee</option>

                                <?php

                                // $select_query = "SELECT * FROM employee_records";
                                // $result_query = pg_query($conn, $select_query);

                                // while ($row = pg_fetch_assoc($result_query)) {
                                //     $emp_first_name = $row['emp_first_name'];
                                //     $emp_last_name = $row['emp_last_name'];
                                //     $emp_id = $row['emp_id'];

                                //     echo "<option value='$emp_id'>" . $emp_first_name . " " . $emp_last_name . "</option>";
                                // }

                                ?>
                            </select>
                        </div> -->


                            <!-- <div class="inpbx">
                            <label for="">Select Exam Type</label>
                            <select name="prepost" class="input">
                                <option value="">Select pre | post</option>
                                <option value="pre">pre exam</option>
                                <option value="post">post exam</option>
                            </select>
                        </div> -->
                        </div>

                        <div class="inpbx btn">
                            <input type="submit" value="Submit" name="submit" id="submit">
                        </div>
                    </form>
                <?php
                } else {
                ?>
                    <div class="inpbx">
                        <label for="">Already Responded Or Not Eligible</label>

                    </div>
                <?php
                }
                ?>
            </div>
            <a href="home_page.php">Exit</a>
        </div>
    </div>
    <script src="gen.js"></script>
        
  
    <?php

    if (isset($_GET['tr_id'])) {

        $select_query = "SELECT * FROM questions WHERE training_program_id=$tr_id";
        $result_query = pg_query($conn, $select_query);

        $qids = array();
        $allans = array();
        // $num = "number";
        // $ta = "textarea";
        // $txt = "text";
        $mcq = "mcq";



        while ($row = pg_fetch_assoc($result_query)) {



            $tr_id = $row['training_program_id'];
            $ques_id = $row['ques_id'];

            $question = $row['que_text'];
            $input_type = $row['ques_type'];
            $opt1 = $row['option_1'];
            $opt2 = $row['option_2'];
            $opt3 = $row['option_3'];
            $opt4 = $row['option_4'];

            $rigans = $row['answer'];

            $allans[] = $rigans;
            $qids[] = $ques_id;

            // $nx = $tx = $tax = $mx = $ques_id;
            // $mx = $ques_id;
            // $lblnm = $question;
            // $lbltx = $question;
            // $lbltax = $question;
            $mq = $question;

            // if ($input_type == $num) {
            //     echo '<script type="text/javascript">',
            //     'createInputnum("' . $input_type . '", "' . $lblnm . '");',
            //     '</script>';
            // }
            // if ($input_type == $ta) {
            //     echo '<script type="text/javascript">',
            //     'createTextArea("' . $lbltax . '");',
            //     '</script>';
            // }
            // if ($input_type == $txt) {
            //     echo '<script type="text/javascript">',
            //     'createInputtxt("' . $input_type . '", "' . $lbltx . '");',
            //     '</script>';
            // }
            if ($input_type == $mcq) {
                echo '<script type="text/javascript">',
                'generateMCQ("' . $mq . '","' . $opt1 . '","' . $opt2 . '","' . $opt3 . '","' . $opt4 . '","' . $ques_id . '");',
                '</script>';
            }
        }
    }


    ?>
</body>

</html>
<?php



if (isset($_POST['submit'])) {

    // $ansqueue = array_combine($qids, $allans);
    // $xoxo = array_combine($qids, $answers);
    if ($xam == "pre") {
        foreach ($_POST as $qids => $answer) {
            if (intval($qids)) {
                $insert_x = pg_query($conn, "INSERT INTO pre_student_ans (ques_id, emp_id, pre_student_ans) VALUES ($qids, $empid, '$answer')");
            }
        }
    }
    if ($xam == "post") {
        foreach ($_POST as $qids => $answer) {
            if (intval($qids)) {
                $insert_x = pg_query($conn, "INSERT INTO post_student_ans (ques_id, emp_id, post_student_ans) VALUES ($qids, $empid, '$answer')");
            }
        }
    }

    // $correct = 0;
    // foreach ($qids as $qid) {
    //     if (isset($ansqueue[$qid]) && isset($xoxo[$qid])) {
    //         if ($ansqueue[$qid] === $xoxo[$qid]) {
    //             $correct++;
    //         }
    //     }
    // }

    if ($xam == "pre") {

        $res_q = "SELECT COUNT(*) AS right_ans_count
FROM pre_student_ans psa
JOIN questions qu ON psa.ques_id = qu.ques_id
WHERE psa.pre_student_ans = qu.answer
AND psa.emp_id = $empid
";
        $re_day = pg_query($conn, $res_q);
        while ($ca = pg_fetch_assoc($re_day)) {
            $caa = $ca['right_ans_count'];
        }
        $tot_q = "SELECT COUNT(*) AS ans_count
FROM pre_student_ans psa
JOIN questions qu ON psa.ques_id = qu.ques_id
WHERE psa.ques_id = qu.ques_id
AND psa.emp_id = $empid
";
        $tac = pg_query($conn, $tot_q);
        while ($tt = pg_fetch_assoc($tac)) {
            $total = $tt['ans_count'];
        }

        $per = ($caa / $total) * 100;

        $insert = "INSERT INTO employee_reports (emp_id, training_program_id, questionnaire1_result) 
        VALUES ('$empid', '$tr_id', '$per')";

        $result_query = pg_query($conn, $insert);

        if (!$result_query) {
            die("Error: " . pg_last_error($conn));
        } else {

            echo "<script>
                alert('Report Generated successfully')
                </script>";
        }
    }


    if ($xam == "post") {

        $res_q1 = "SELECT COUNT(*) AS right_ans_count
        FROM post_student_ans psa
        JOIN questions qu ON psa.ques_id = qu.ques_id
        WHERE psa.post_student_ans = qu.answer
        AND psa.emp_id = $empid
        ";
        $re_day1 = pg_query($conn, $res_q1);
        while ($ca1 = pg_fetch_assoc($re_day1)) {
            $caa1 = $ca1['right_ans_count'];
        }
        $tot_q1 = "SELECT COUNT(*) AS ans_count
        FROM post_student_ans psa
        JOIN questions qu ON psa.ques_id = qu.ques_id
        WHERE psa.ques_id = qu.ques_id
        AND psa.emp_id = $empid
        ";
        $tac1 = pg_query($conn, $tot_q1);
        while ($tt1 = pg_fetch_assoc($tac1)) {
            $total1 = $tt1['ans_count'];
        }

        $per1 = ($caa1 / $total1) * 100;


        $q_q = "SELECT * FROM employee_reports WHERE emp_id = $empid";
        $res_q_q = pg_query($conn, $q_q);
        while ($row_q = pg_fetch_assoc($res_q_q)) {
            $res11 = $row_q['questionnaire1_result'];
        }

        $emp_pnum = $per1 - $res11;
        $grow = ($emp_pnum / $per1) * 100;

        $insert = "UPDATE employee_reports SET employee_performance = '$grow', questionnaire2_result = '$per1'
        WHERE emp_id = '$empid' AND training_program_id = $tr_id";

        $result_query = pg_query($conn, $insert);

        if (!$result_query) {
            die("Error: " . pg_last_error($conn));
        } else {

            echo "<script>
                alert('Report Generated successfully')
                </script>";
        }
    }

    if ($insert_x && $result_query) {

        echo "<script>
            alert('Form submitted successfully')
            window.location.href = 'home_page.php';
          </script>";
        // header("location: home_page.php");
        exit;
        
    }
    
}

?>