<?php

include('connect.php');
session_start();
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['trainer_id'])) {
    header("location: admin_login.php");
}
$today = date('Y-m-d');
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
            <div class="tbd scrl">

                <table class="tblt">
                    <thead>
                        <tr>
                            <th class="ly">Training Program Name</th>

                            <th>Schedule Date</th>
                            <?php
                            if (isset($_SESSION['trainer_id'])) {
                            ?>
                                <th>start pre exam</th>
                                <th>end pre exam</th>
                                <th>start post exam</th>
                                <th>end post exam</th>
                            <?php
                            }
                            ?>

                        </tr>
                    </thead>



                    <?php

                    $select_query = "SELECT DISTINCT * FROM create_training_programs ORDER BY date DESC";
                    $result_query = pg_query($conn, $select_query);

                    if (isset($_SESSION['admin_id'])) {
                        while ($row = pg_fetch_assoc($result_query)) {
                            $training_name = $row['name'];
                            $training_id = $row['training_program_id'];
                            $sdate = $row['date'];

                            echo "
                <tbody>  
                    <tr>
                        <td class='ly'>
                            <a href='view_tr.php?training_program_id=$training_id'>
                                <p>$training_name</p>
                            </a>
                        </td>

                        <td class='ly'>
                            <a href='view_tr.php?training_program_id=$training_id'>
                                <p>$sdate</p>
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
                        $trainer_id = $_SESSION['trainer_id'];

                        $select_query1 = "SELECT DISTINCT * FROM training_trainer_relation WHERE trainer_id = $trainer_id ";
                        $result_query1 = pg_query($conn, $select_query1);

                        while ($row1 = pg_fetch_assoc($result_query1)) {

                            $training_id = $row1['training_program_id'];

                            $select_query = "SELECT DISTINCT ctp.*
FROM create_training_programs ctp
WHERE ctp.training_program_id = $training_id
  AND NOT EXISTS (
      SELECT 1
      FROM training_reports tr
      WHERE tr.training_program_id = ctp.training_program_id 
      ORDER BY date DESC
  );

";
                            $result_query = pg_query($conn, $select_query);

                            while ($row = pg_fetch_assoc($result_query)) {
                                $training_name = $row['name'];
                                $training_idx = $row['training_program_id'];

                                $sdate1 = $row['date'];
                                $started = "started";
                                $finished = "finished";
                                echo "
                <tbody>  
                    <tr>
                        <td class='ly'>
                            <a href='view_tr.php?training_program_id=$training_idx'>
                                <p>$training_name</p>
                            </a>
                        </td>
                        <td class='ly'>
                            <a href='view_tr.php?training_program_id=$training_id'>
                                <p>$sdate1</p>
                            </a>
                        </td>
                        ";

                    ?>
                                <?php if ($sdate1 == $today) { ?>
                                    <td>
                                        <button id="start-exam-btn" onclick="updateExamStatus(<?php echo $training_idx; ?>, 'started', 'pre');">Start pre Exam</button>
                                    </td>
                                    <td>
                                        <button id="end-exam-btn" onclick="updateExamStatus(<?php echo $training_idx; ?>, 'finished', 'pre');">End pre Exam</button>
                                    </td>
                                    <td>
                                        <button id="start-exam-btn" onclick="updateExamStatus(<?php echo $training_idx; ?>, 'started', 'post');">Start post Exam</button>
                                    </td>
                                    <td>
                                        <button id="end-exam-btn" onclick="updateExamStatus(<?php echo $training_idx; ?>, 'finished', 'post');">End post Exam</button>
                                    </td>
                                <?php } elseif($sdate1 < $today) {?>
                                    <td>
                                        date ended
                                    </td>
                                    <td>date ended</td>
                                    <td>date ended</td>
                                    <td>date ended</td>
                                <?php } elseif($sdate1 > $today) {?>
                                    <td>
                                        yet to start
                                    </td>
                                    <td>yet to start</td>
                                    <td>yet to start</td>
                                    <td>yet to start</td>
                                <?php } ?>
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