<?php
include('connect.php');

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
if (isset($_GET['emp_id']) && isset($_GET['prepost'])) {
    $empid = $_GET['emp_id'];
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
                if($flag){
                    
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
                }
                else{
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
    <script>
        // function generateMCQ(mq, op1, op2, op3, op4) {

        //     const questionContainer = document.createElement('div');
        //     questionContainer.classList.add('mcq-container');

        //     const userQuestion = mq;

        //     const question = document.createElement('label');
        //     question.textContent = userQuestion;

        //     questionContainer.appendChild(question);

        //     const a = op1;
        //     const b = op2;
        //     const c = op3;
        //     const d = op4;

        //     const options = [a, b, c, d];

        //     options.forEach((option, index) => {

        //         const label = document.createElement('label');


        //         const radioBtn = document.createElement('input');
        //         radioBtn.type = 'radio';

        //         radioBtn.value = option;
        //         var mx = "answer[]";
        //         radioBtn.name = mx;
        //         label.textContent = option;
        //         label.appendChild(radioBtn);

        //         questionContainer.appendChild(label);

        //     });

        //     document.getElementById("output1").appendChild(questionContainer);
        // }

        function generateMCQ(mq, op1, op2, op3, op4, qid) {
            const questionContainer = document.createElement('div');
            questionContainer.classList.add('mcq-container');

            const questionLabel = document.createElement('label');
            questionLabel.textContent = mq;
            questionContainer.appendChild(questionLabel);

            const options = [op1, op2, op3, op4];
            const val = ['a', 'b', 'c', 'd'];
            let i = 0;
            options.forEach((option, index) => {
                const radioBtn = document.createElement('input');
                radioBtn.type = 'radio';
                radioBtn.id = qid;

                radioBtn.name = qid;
                radioBtn.value = val[i];
                i++;
                const label = document.createElement('label');
                label.htmlFor = radioBtn.id;
                label.textContent = option;

                const optionContainer = document.createElement('div');
                optionContainer.classList.add('option-container');
                optionContainer.appendChild(radioBtn);
                optionContainer.appendChild(label);

                questionContainer.appendChild(optionContainer);
            });

            // Append the question container to the output element
            document.getElementById('output1').appendChild(questionContainer);
        }


        // function createTextArea(lbltax) {

        //     var newdiv = document.createElement("div");
        //     newdiv.classList.add("inpbx");

        //     let lbll = lbltax;

        //     var label = document.createElement("label");
        //     label.innerHTML = lbll + ": ";

        //     var textArea = document.createElement("textarea");
        //     textArea.rows = 20;

        //     var tax = "answer[]";

        //     textArea.name = tax;

        //     newdiv.appendChild(label);
        //     newdiv.appendChild(document.createElement("br"));
        //     newdiv.appendChild(textArea);

        //     document.getElementById("output1").appendChild(newdiv);
        // }

        // function createInputtxt(type, lbltx) {
        //     var newDiv = document.createElement("div");
        //     newDiv.classList.add("inpbx");
        //     var newInput = document.createElement("input");
        //     var tx = "answer[]";
        //     newInput.type = type;

        //     newInput.name = tx;

        //     let lbl = lbltx;

        //     var label = document.createElement("label");
        //     label.innerHTML = lbl + ": ";

        //     newDiv.appendChild(label);
        //     newDiv.appendChild(newInput);
        //     document.getElementById("output1").appendChild(newDiv);
        // }


        // function createInputnum(type, lblnm) {
        //     var newDiv = document.createElement("div");
        //     newDiv.classList.add("inpbx");
        //     var newInput = document.createElement("input");
        //     var nx = "answer[]";

        //     newInput.name = nx;
        //     newInput.type = type;

        //     let lbl = lblnm;

        //     var label = document.createElement("label");
        //     label.innerHTML = lbl + ": ";

        //     newDiv.appendChild(label);
        //     newDiv.appendChild(newInput);
        //     document.getElementById("output1").appendChild(newDiv);
        // }
    </script>
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

    if ($insert_x) {

        echo "<script>
            alert('Form submitted successfully')
          </script>";
        //header("location: .php");
    }
}

?>