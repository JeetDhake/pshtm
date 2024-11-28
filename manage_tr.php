<?php

include('connect.php');
session_start();
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['trainer_id'])) {
    header("location: admin_login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/manage_tr.css">
    <link rel="stylesheet" href="style/sidebar.css">
    <title>Training</title>
</head>

<body>
    <?php
    if (isset($_SESSION['admin_id'])) {
        require_once("navbar.html");
    } elseif (isset($_SESSION['trainer_id'])) {
        require_once("navbar2.html");
    }
    ?>
    <?php require_once("sidebartr.html") ?>
    <div class="container">
        <div class="op">


            <table>
                <thead>
                    <tr>
                        <th class="ly">Training Program Name</th>

                        <th>Update</th>

                        <th>start pre exam</th>
                        <th>end pre exam</th>
                        <th>start post exam</th>
                        <th>end post exam</th>


                    </tr>
                </thead>
            </table>
            <div class="tbd">
                <table>
                    <?php

                    $select_query = "SELECT DISTINCT * FROM create_training_programs ";
                    $result_query = pg_query($conn, $select_query);

                    if (isset($_SESSION['admin_id'])) {
                        while ($row = pg_fetch_assoc($result_query)) {
                            $training_name = $row['name'];
                            $training_id = $row['training_program_id'];

                            echo "
                <tbody>  
                    <tr>
                        <td class='ly'>
                            <a href='view_tr.php?training_program_id=$training_id'>
                                <p>$training_name</p>
                            </a>
                        </td>
             
                        <td>
                        <a href='training_edit.php?training_program_id=$training_id'>
                                <p class='p-g'>Update</p>
                            </a>
                        </td>
                  
                    </tr>
                </tbody>

        ";
                        }
                    }

                    if (isset($_SESSION['trainer_id'])) {
                        $triner_id = $_SESSION['trainer_id'];

                        $select_query1 = "SELECT DISTINCT * FROM training_trainer_relation WHERE trainer_id = $triner_id";
                        $result_query1 = pg_query($conn, $select_query1);

                        while ($row1 = pg_fetch_assoc($result_query1)) {

                            $training_id = $row1['training_program_id'];

                            $select_query = "SELECT DISTINCT * FROM create_training_programs WHERE training_program_id = $training_id";
                            $result_query = pg_query($conn, $select_query);

                            while ($row = pg_fetch_assoc($result_query)) {
                                $training_name = $row['name'];
                                $training_id = $row['training_program_id'];

                                $started = "started";
                                $finished = "finished";
                                echo "
                <tbody>  
                    <tr>
                        <td class='ly'>
                            <a href='view_tr.php?training_program_id=$training_id'>
                                <p>$training_name</p>
                            </a>
                        </td>
                        "; ?>

                                <td>
                                    <button id="start-exam-btn" onclick="updateExamStatus(<?php echo $training_id; ?>, 'started', 'pre');">Start pre Exam</button>
                                </td>
                                <td>
                                    <button id="end-exam-btn" onclick="updateExamStatus(<?php echo $training_id; ?>, 'finished', 'pre');">End pre Exam</button>
                                </td>
                                <td>
                                    <button id="start-exam-btn" onclick="updateExamStatus(<?php echo $training_id; ?>, 'started', 'post');">Start post Exam</button>
                                </td>
                                <td>
                                    <button id="end-exam-btn" onclick="updateExamStatus(<?php echo $training_id; ?>, 'finished', 'post');">End post Exam</button>
                                </td>

                    <?php
                                echo "
                        <td>
                        <a href='training_edit.php?training_program_id=$training_id'>
                                <p class='p-g'>Update</p>
                            </a>
                        </td>
                  
                    </tr>
                </tbody>

        ";
                            }
                        }
                    }
                    ?>


                </table>
            </div>
        </div>
    </div>

    <script src="manage.js"></script>
    <script>
        function updateExamStatus(tr_id, status, xm) {

            var xhr = new XMLHttpRequest();

            xhr.open("POST", "prxm_stat.php", true);

            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    var response = xhr.responseText.trim();
                    console.log(response)
                    if (response == "success") {
                        alert("Exam " + status);
                    } else {
                        alert("Command fail");
                    }
                } else {
                    alert("Command fail");
                }
            };
            
            xhr.onerror = function() {
                alert("Command fail");
            };

            var data = "tr_id=" + encodeURIComponent(tr_id) + "&status=" + encodeURIComponent(status) + "&xm=" + encodeURIComponent(xm);

            xhr.send(data);

        }
    </script>
</body>

</html>