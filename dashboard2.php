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
    <script src="https://kit.fontawesome.com/b9323f08fd.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/dashboard.css">

    <title>pshtm</title>
</head>

<body>
    <?php require_once("navbar2.html") ?>


    <div class="container">
        <h3>Analytics</h3>
        <div class="one">
            <div class="block">
                <div class="bx1">
                    <i class="fa-solid fa-chart-column fa-xl"></i>
                    <div class="midl">
                        <div class="lftb">
                            <?php
                            $select_query = "SELECT AVG(completion_rate) AS crxx FROM training_reports WHERE completion_rate > 0";
                            $result = pg_query($conn, $select_query);

                            while ($rowX = pg_fetch_assoc($result)) {
                                $crxx = number_format($rowX['crxx'], 2);

                                if ($crxx == NULL) {
                                    echo '
                            <h2>Completion Rate</h2>
                            <h5>No Data Available</h5>
                            ';
                                } else {
                                    echo '
                            <h2>Completion Rate</h2>
                            <h1>' . $crxx . '</h1>
                            ';
                                }
                            }
                            ?>

                        </div>
                        <div class="rghtb">
                            <svg>
                                <circle cx='38' cy='38' r='36'></circle>
                            </svg>
                            <div class="perc">
                                <p></p>
                            </div>
                        </div>
                    </div>

                </div>
                <small class="mutedtext">Record of All Time</small>
            </div>

            <div class="block">
                <div class="bx2">
                    <i class="fa-regular fa-eye fa-xl"></i>
                    <div class="midl">
                        <div class="lftb">
                            <?php
                            $select_query = "SELECT AVG(employee_performance) AS epxx FROM employee_reports WHERE employee_performance > 0";
                            $result = pg_query($conn, $select_query);

                            while ($rowX = pg_fetch_assoc($result)) {
                                $epavg = number_format($rowX['epxx'], 2);

                                if ($epavg == NULL) {
                                    echo '
                            <h2>Performance</h2>
                            <h5>No Data Available</h5>
                            ';
                                } else {
                                    echo '
                            <h2>Performance</h2>
                            <h1>' . $epavg . '</h1>
                            ';
                                }
                            }
                            ?>

                        </div>
                        <div class="rghtb">
                            <svg>
                                <circle cx='38' cy='38' r='36'></circle>
                            </svg>
                            <div class="perc">
                                <p></p>
                            </div>
                        </div>
                    </div>

                </div>
                <small class="mutedtext">Average employees performace</small>
            </div>

            <div class="block">
                <div class="bx3">
                    <i class="fa-solid fa-rocket fa-xl"></i>
                    <div class="midl">
                        <div class="lftb">
                            <?php
                            $select_query = "SELECT questionnaire1_result, questionnaire2_result FROM employee_reports";
                            $result = pg_query($conn, $select_query);

                            $xx = array();
                            while ($rowX = pg_fetch_assoc($result)) {
                                $qa1 = $rowX['questionnaire1_result'];
                                $qa2 = $rowX['questionnaire2_result'];
                                $av = $qa2 - $qa1;
                                $xx[] = $av;
                            }

                            if (count($xx) == 0) {
                                echo '<h2>Growth Rate</h2>
                        <h5>No Data Available</h5>';
                            } else {
                                $xx1 = array_sum($xx) / count($xx);
                                echo '<h2>Growth Rate</h2>
                        <h1>' .  $xx1 . '</h1>';
                            }

                            ?>

                        </div>
                        <div class="rghtb">
                            <svg>
                                <circle cx='38' cy='38' r='36'></circle>
                            </svg>
                            <div class="perc">
                                <p></p>
                            </div>
                        </div>
                    </div>

                </div>
                <small class="mutedtext">Average growth from pre to post exam</small>
            </div>
        </div>

        <h3>Controls</h3>
        <div class="two">
            <!-- <div class="block1">
                <div class="bx3">

                    <h3>Employees</h3>

                    <div class="linkbtn">
                        <a href="employee_reg.php">
                            <i class="fa-regular fa-address-card"></i><br>
                            <button> Register a Employee </button>
                        </a>

                        <a href="employee_all.php">
                            <i class="fa-regular fa-pen-to-square"></i><br>
                            <button>Edit Employee Details</button>
                        </a>

                        <a href="employee_all.php">
                            <i class="fa-solid fa-trash-arrow-up"></i><br>
                            <button>Deactivate a Employee</button>
                        </a>

                    </div>

                </div>
            </div> -->
            <div class="block1">
                <div class="bx3">
                    <h3>Trainings</h3>

                    <div class="linkbtn">
                        <a href="create_training.php">
                            <i class="fa-regular fa-square-plus"></i><br>
                            <button>Create a Training</button>
                        </a>

                        <a href="add_members.php">
                            <i class="fa-solid fa-right-from-bracket"></i><br>
                            <button>Add Admin/Trainer</button>
                        </a>

                        <a href="manage_tr.php">
                            <i class="fa-solid fa-layer-group"></i><br>
                            <button>Manage Trainings</button>
                        </a>

                    </div>

                </div>
            </div>

        </div>

        <div class="two">
            <div class="block1">
                <div class="bx3">


                    <?php
                    $nm = array();
                    $cr = array();
                    $ep = array();

                    $select_query = "SELECT * FROM training_reports";
                    $result_query = pg_query($conn, $select_query);

                    while ($row = pg_fetch_assoc($result_query)) {
                        $tr_id = $row['training_program_id'];

               
                        $select_query1 = "SELECT name FROM create_training_programs WHERE training_program_id=$tr_id LIMIT 1";
                        $result_query1 = pg_query($conn, $select_query1);
                        $row1 = pg_fetch_assoc($result_query1);
                        if ($row1) {
                            $nm[] = $row1['name'];
                        }


                        $select_query4 = "SELECT AVG(employee_performance) AS alp FROM employee_reports WHERE training_program_id=$tr_id";
                        $result_query4 = pg_query($conn, $select_query4);
                        while ($row4 = pg_fetch_assoc($result_query4)) {
                            $ep[] = $row4['alp'];
                        }

                        $cr[] = $row["completion_rate"];
                    }
                    ?>




                    <div class="chartbox">
                        <canvas id="mychart"></canvas>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                    <script>
                        const nm = <?php echo json_encode($nm); ?>;

                        const ep = <?php echo json_encode($ep); ?>;


                        const data = {
                            labels: nm,
                            datasets: [{
                                label: '# of emp Performance',
                                data: ep,
                                borderWidth: 1
                            }]
                        };

                        const confi = {
                            type: 'bar',
                            data,
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        };




                        const mychart = new Chart(
                            document.getElementById('mychart'),
                            confi
                        );
                    </script>



                </div>
            </div>

            <div class="block1">
                <div class="bx3">
                    <div class="chartbox">
                        <canvas id="mychart2"></canvas>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                    <script>
                        const nm1 = <?php echo json_encode($nm); ?>;
                        const cr = <?php echo json_encode($cr); ?>;

                        const data2 = {
                            labels: nm1,
                            datasets: [{
                                label: '# of Completion rate',
                                data: cr,
                                borderWidth: 1
                            }]
                        };

                        const confi2 = {
                            type: 'line',
                            data: data2,
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        };

                        const mychart2 = new Chart(
                            document.getElementById('mychart2'),
                            confi2
                        );
                    </script>

                </div>
            </div>
        </div>


        <div class="top">
            <h3>Top training Programs</h3>
            <table>
                <thead>
                    <tr>
                        <th class="t1">Training Program</th>
                        <th>Participation</th>
                        <th>Completion rate</th>
                        <th>Performance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $select_query = "SELECT * FROM training_reports ORDER BY completion_rate DESC, participation DESC LIMIT 5";
                    $result_query = pg_query($conn, $select_query);

                    while ($row = pg_fetch_assoc($result_query)) {

                        $tr_id = $row['training_program_id'];
                        $ptx = $row["participation"];
                        $crx = $row["completion_rate"];


                        $select_query1 = "SELECT * FROM create_training_programs WHERE training_program_id=$tr_id";
                        $result_query1 = pg_query($conn, $select_query1);
                        while ($row1 = pg_fetch_assoc($result_query1)) {
                            $nmx = $row1['name'];

                            $select_query3 = "SELECT AVG(employee_performance) AS epx FROM employee_reports WHERE training_program_id=$tr_id";
                            $result_query3 = pg_query($conn, $select_query3);
                            while ($row3 = pg_fetch_assoc($result_query3)) {
                                $epx = $row3['epx'];
                                echo '
                            <tr>
                                <td>' . $nmx . '</td>
                                <td>' . $ptx . '</td>
                                <td>' . $crx . '</td>
                                <td>' . $epx . '</td>
                            </tr>
                            ';
                            }
                        }
                    }
                    ?>

                </tbody>
            </table>
            <a href="">Show all</a>
        </div>



    </div>


</body>

</html>