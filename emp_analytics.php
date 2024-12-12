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
    <link rel="stylesheet" href="style/sidebar.css">
    <link rel="stylesheet" href="style/analytics.css">

    <title>Analytics</title>
</head>

<body>
    <?php require_once("navbar.html") ?>
    <?php require_once("sidebana.html") ?>

    <?php
    if (isset($_GET['u_id'])) {

        $u_id = $_GET['u_id'];

        $sql = pg_query($conn, "SELECT * FROM employee_records WHERE emp_uid = $u_id");
        if (pg_num_rows($sql) > 0) {
            $row = pg_fetch_assoc($sql);
        }
        $emp_id = $row['emp_id'];
    }
    ?>
    <div class="container">

        <div class="wrapper" id="">
            <section class="pst">
                <header>
                    <h4>
                        <?php echo $row['emp_first_name'] . " " . $row['emp_middle_name'] . " " . $row['emp_last_name']; ?>
                    </h4>
                </header>

                <div class="pdetail">

                    <div class="fld">

                        <h3>
                            <?php echo "ID: " . $row['emp_uid']; ?>
                        </h3>
                    </div>
                    <div class="tab-buttons">
                        <!-- <button class="tab-button active" onclick="showTab('tab1')">Table</button> -->
                        <!-- <button class="tab-button" onclick="showTab('tab2')">Charts</button> -->
                    </div>

                </div>
            </section>

            <!-- <div id="tab2" class="tab-panel">

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                <div class="xu">

                    <?php


                    //                     $select_queryx = "SELECT * FROM employee_reports WHERE emp_id=$emp_id";
                    //                     $result_queryx = pg_query($conn, $select_queryx);

                    //                     $q1 = array();
                    //                     $q2 = array();
                    //                     $emp_p = array();
                    //                     $emp_id = array();
                    //                     while ($rowx = pg_fetch_assoc($result_queryx)) {

                    //                         $emp_p[] = $rowx["employee_performance"];
                    //                         $emp_id[] = $rowx["emp_id"];
                    //                         $q1[] = $rowx["questionnaire1_result"];
                    //                         $q2[] = $rowx["questionnaire2_result"];
                    //                     }
                    //                     $emp_uid = array();
                    //                     foreach ($emp_id as $empid) {
                    //                         $s_query = "SELECT * FROM employee_records WHERE emp_id=$empid";
                    //                         $r_query = pg_query($conn, $s_query);
                    //                         while ($rowy = pg_fetch_assoc($r_query)) {
                    //                             $emp_uid[] = $rowy['emp_uid'];
                    //                         }
                    //                     }

                    //                     $canvas_id1 = "mychart_" . $training_program_id . "_1";
                    //                     $canvas_id2 = "mychart_" . $training_program_id . "_2";


                    //                     echo '<div class = "chart-wrapper"><div class="chartbox">
                    // <canvas id="' . $canvas_id1 . '" class="canva"></canvas>
                    // </div></div>';
                    ?>
                    <script>
                        var pp1 = <?php //echo json_encode($q1); 
                                    ?>;
                        var pp2 = <?php //echo json_encode($q2); 
                                    ?>;
                        var ids = <?php //echo json_encode($emp_uid); 
                                    ?>;
                        var data = {
                            labels: ids,
                            datasets: [{
                                    label: "Per",
                                    data: pp1,
                                    borderWidth: 1
                                },
                                {
                                    label: "Post",
                                    data: pp2,
                                    borderWidth: 1
                                }
                            ]
                        };
                        var confi = {
                            type: "bar",
                            data: data,
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        };
                        var mychart1 = new Chart(
                            document.getElementById("<?php //echo $canvas_id1 
                                                        ?>"),
                            confi
                        );
                    </script>


                    <?php
                    // Print the first chart
                    //echo '<div class = "chart-wrapper"><div class="chartbox">
                    //<canvas id="' . $canvas_id2 . '" class="canva"></canvas>
                    //</div></div>';
                    ?>
                    <script>
                        var emp_p = <?php //echo json_encode($emp_p); 
                                    ?>;
                        var ids = <?php //echo json_encode($emp_uid); 
                                    ?>;
                        var data = {
                            labels: ids,
                            datasets: [{
                                label: "Per",
                                data: emp_p,
                                borderWidth: 1
                            }]
                        };
                        var confi = {
                            type: "line",
                            data: data,
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        };
                        var mychart2 = new Chart(
                            document.getElementById("<?php //echo $canvas_id2 
                                                        ?>"),
                            confi
                        );
                    </script>
                </div>
            </div> -->

            <div id="tab1" class="tab-panel active scrx">
                <table id="dataTable">
                    <thead>
                        <tr>
                            <th>training_id</th>
                            <th>$training_name</th>
                            <th>emp_performance</th>
                            <th>emp_pre_res</th>
                            <th>emp_post_res</th>
                        </tr>
                    </thead>

                        <?php

                        $select_qx = "SELECT * FROM employee_reports WHERE emp_id = $emp_id";
                        $result_qx = pg_query($conn, $select_qx);
                        while ($rox = pg_fetch_assoc($result_qx)) {

                            $emp_performance = round($rox['employee_performance'], 1);
                            $emp_pre_res = round($rox['questionnaire1_result'], 1);
                            $emp_post_res = round($rox['questionnaire2_result'], 1);
                            $training_program_id = $rox['training_program_id'];

                            $select_qxx = "SELECT * FROM create_training_programs WHERE training_program_id = $training_program_id";
                            $result_qxx = pg_query($conn, $select_qxx);
                            while ($roxx = pg_fetch_assoc($result_qxx)) {
                                $trnm = $roxx['name'];
                            }


                            echo "
                            <tbody>
                                <tr>
                                    <td>$training_program_id</td>
                                    <td>$trnm</td>
                                    <td>$emp_performance</td>
                                    <td>$emp_pre_res</td>
                                    <td>$emp_post_res</td>
                                </tr>
                            </tbody>";
                        }


                        ?>

                </table>
                

            </div>
            <button id="exportButton">Export to CSV</button>
        </div>

    </div>
    <script src="tab.js"></script>
    <script src="manage.js"></script>
    <script src="export_csv.js"></script>

</body>

</html>