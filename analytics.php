<?php

include('connect.php');
session_start();
if (!isset($_SESSION['admin_id'])) {
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
    if (isset($_GET['training_program_id'])) {

        $training_program_id = $_GET['training_program_id'];

        $sql = pg_query($conn, "SELECT * FROM create_training_programs WHERE training_program_id = $training_program_id");
        if (pg_num_rows($sql) > 0) {
                $row = pg_fetch_assoc($sql); 
        }
        $department_id_ar = [];

        $sql5 = pg_query($conn, "SELECT DISTINCT department_id FROM training_relations WHERE training_program_id = $training_program_id");
        while ($row5 = pg_fetch_assoc($sql5)) {
            $department_id_ar[] = $row5["department_id"];
        }
    }
    ?>
    <div class="container">

        <div class="wrapper" id="">
            <section class="pst">
                <header>
                    <h1>
                        <?php echo $row['name']; ?>
                    </h1>
                </header>


                <div class="pdetail">

                    <div class="fld">
                        <h5>Detail:</h5>
                        <h2>
                            <?php echo $row['training_desc']; ?>
                        </h2>
                    </div>

                    <div class="f">

                        <div class="fld">
                            <h5>Department:</h5>
                            <?php
                            foreach ($department_id_ar as $dept_id) {
                                $select_query1 = "SELECT DISTINCT department_name FROM department WHERE department_id=$dept_id";
                                $result_query1 = pg_query($conn, $select_query1);

                                while ($row8 = pg_fetch_assoc($result_query1)) {
                                    $emp_departmentx = $row8['department_name'];
                                    echo '<h3>
                                        '.$emp_departmentx.'
                                        </h3><nobr> ';
                                }
                            }
                            ?>
                            
                        </div>

                    </div>

                    <div class="f fl">

                        <div class="fld">
                            <a href="view_form.php?training_program_id=<?php echo $training_program_id; ?>">
                                <div class="xx">
                                    <h4>Questionnaire</h4>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </section>


            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="xu">

            <?php


        $select_queryx = "SELECT * FROM employee_reports WHERE training_program_id=$training_program_id";
        $result_queryx = pg_query($conn, $select_queryx);

        $q1 = array();
        $q2 = array();
        $emp_p = array();
        $emp_id = array();
        while ($rowx = pg_fetch_assoc($result_queryx)) {

            $emp_p[] = $rowx["employee_performance"];
            $emp_id[] = $rowx["emp_id"];
            $q1[] = $rowx["questionnaire1_result"];
            $q2[] = $rowx["questionnaire2_result"];
 
        }

        // Generate unique IDs for the canvas elements
        $canvas_id1 = "mychart_" . $training_program_id . "_1";
        $canvas_id2 = "mychart_" . $training_program_id . "_2";

        // Print the first chart
        echo '<div class="chartbox">
<canvas id="' . $canvas_id1 . '" class="canva"></canvas>
</div>';
?>
        <script>
var pp1 = <?php echo json_encode($q1); ?>;
var pp2 = <?php echo json_encode($q2); ?>;
var ids = <?php echo json_encode($emp_id); ?>;
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
    document.getElementById("<?php echo $canvas_id1 ?>"),
    confi
);
</script>


<?php
// Print the first chart
        echo '<div class="chartbox">
<canvas id="' . $canvas_id2 . '" class="canva"></canvas>
</div>';
?>
        <script>
var emp_p = <?php echo json_encode($emp_p); ?>;
var ids = <?php echo json_encode($emp_id); ?>;
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
    document.getElementById("<?php echo $canvas_id2 ?>"),
    confi
);
</script>
    </div>
        </div>


    </div>
    <script src="manage.js"></script>

</body>

</html>