<?php
include('connect.php');

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
                            <label for="">Employee id</label>

                            <select name="empid">
                                <option value="">Select employee</option>

                                <?php

                                $select_query = "SELECT * FROM employee_records";
                                $result_query = pg_query($conn, $select_query);

                                while ($row = pg_fetch_assoc($result_query)) {
                                    $emp_first_name = $row['emp_first_name'];
                                    $emp_last_name = $row['emp_last_name'];
                                    $emp_id = $row['emp_id'];

                                    echo "<option value='$emp_id'>" . $emp_first_name . " " . $emp_last_name . "</option>";
                                }

                                ?>
                            </select>
                        </div>


                        <div class="inpbx">
                            <label for="">Select Exam Type</label>
                            <select name="prepost" class="input">
                                <option value="">Select pre | post</option>
                                <option value="pre">pre exam</option>
                                <option value="post">post exam</option>
                            </select>
                        </div>
                    </div>

                    <div class="inpbx btn">
                        <input type="submit" value="Submit" name="submit" id="submit">
                    </div>
                </form>
            </div>
            <a href="manage_tr.php">exit</a>
        </div>
    </div>
    <script>
        function generateMCQ(mq, op1, op2, op3, op4) {

            const questionContainer = document.createElement('div');
            questionContainer.classList.add('mcq-container');

            const userQuestion = mq;

            const question = document.createElement('label');
            question.textContent = userQuestion;

            questionContainer.appendChild(question);

            const a = op1;
            const b = op2;
            const c = op3;
            const d = op4;

            const options = [a, b, c, d];

            options.forEach((option, index) => {

                const label = document.createElement('label');


                const radioBtn = document.createElement('input');
                radioBtn.type = 'radio';

                radioBtn.value = option;
                var mx = "answer[]";
                radioBtn.name = mx;
                label.textContent = option;
                label.appendChild(radioBtn);

                questionContainer.appendChild(label);

            });

            document.getElementById("output1").appendChild(questionContainer);
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
    if (isset($_GET['training_program_id'])) {

        $tr_id = $_GET['training_program_id'];

        $select_query = "SELECT * FROM question_details WHERE training_program_id=$tr_id";
        $result_query = pg_query($conn, $select_query);

        $qids = array();
        $allans = array();
        // $num = "number";
        // $ta = "textarea";
        // $txt = "text";
        $mcq = "mcq";

        $numofques = 0;

        while ($row = pg_fetch_assoc($result_query)) {

            $numofques++;

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
            $mx = $ques_id;
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
                'generateMCQ("' . $mq . '","' . $opt1 . '","' . $opt2 . '","' . $opt3 . '","' . $opt4 . '");',
                '</script>';
            }
        }
    }


    ?>
</body>

</html>
<?php

if (isset($_POST['submit'])) {


    $answers = $_POST['answer'];
    $empid = $_POST['empid'];
    $xam = $_POST['prepost'];

    $ansqueue = array_combine($qids, $allans);
    $xoxo = array_combine($qids, $answers);
    if ($xam == "pre") {
        foreach ($xoxo as $qids => $answers) {

            $insert_x = pg_query($conn, "INSERT INTO pre_student_ans (ques_id, pre_student_ans, emp_id) VALUES ('$qids', '$answers', '$empid')");
        }
    }
    if ($xam == "post") {
        foreach ($xoxo as $qids => $answers) {

            $insert_x = pg_query($conn, "INSERT INTO post_student_ans (ques_id, post_student_ans, emp_id) VALUES ('$qids', '$answers', '$empid')");
        }
    }

    $correct = 0;
    foreach ($qids as $qid) {
        if (isset($ansqueue[$qid]) && isset($xoxo[$qid])) {
            if ($ansqueue[$qid] === $xoxo[$qid]) {
                $correct++;
            }
        }
    }

    if ($xam == "pre") {
        $insert = "INSERT INTO employee_reports (emp_id, training_program_id, questionnaire1_result) 
        VALUES ('$empid', '$tr_id', '$correct')";

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

        $querry_x = "SELECT questionnaire1_result FROM employee_reports WHERE emp_id = $empid AND training_program_id = $tr_id";
        $res_qx = pg_query($conn, $querry_x);
        while ($rowx = pg_fetch_assoc($res_qx)) {
            $preres = $rowx['questionnaire1_result'];
        }
        // $employee_performance = $preres - $correct;

        $total = count($qids);
        $employee_performance = ($correct / $total) * 100;

        $insert = "INSERT INTO employee_reports (employee_performance, questionnaire2_result) 
        VALUES ('$empid', '$tr_id', '$employee_performance', '$correct') 
        WHERE emp_id = $empid AND training_program_id = $tr_id";

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