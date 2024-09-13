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

    <link rel="stylesheet" href="style/analytics.css">
    <link rel="stylesheet" href="style/sidebar.css">


    <title>Analytics</title>
</head>

<body>
    <?php require_once("navbar.html") ?>
    <?php require_once("sidebana.html") ?>
    <div class="container">
        <div class="">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Filter data</h4>
                    </div>
                </div>
            </div>

            <div class="one">
                <div class="block">
                    <form action="" method="GET">
                        <div class="card shadow mt-3">
                            <div class="card-header">
                                <h5>Filter</h5>

                                <button type="submit" class="btn">Search</button>

                            </div>
                            <div class="card-body">
                                <h6>Dept List</h6>
                                <hr>
                                <?php


                                $dept_query = "SELECT * FROM department";
                                $dept_query_run  = pg_query($conn, $dept_query);

                                if (pg_num_rows($dept_query_run) > 0) {
                                    while ($deptlist = pg_fetch_assoc($dept_query_run)) { {
                                            $checked = [];
                                            if (isset($_GET['departments'])) {
                                                $checked = $_GET['departments'];
                                            }
                                ?>
                                            <div class="huh">
                                                <input type="checkbox" name="departments[]" value="<?= $deptlist['department_id']; ?>" <?php if (in_array($deptlist['department_id'], $checked)) {
                                                                                                                                            echo "checked";
                                                                                                                                        } ?> />
                                                <?= $deptlist['department_name']; ?>
                                            </div>
                                <?php
                                        }
                                    }
                                } else {
                                    echo "No dept Found";
                                }

                                ?>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="block">
                    <div class="pst">
                        <form action="" method="GET">
                            <div class="fld">
                                <label for="from">from</label>
                                <input type="date" name="start" id="start">
                            </div>
                            <div class="fld">
                                <label for="to">to</label>
                                <input type="date" name="end" id="end">
                            </div>
                            <div class="fld">
                                <button type="submit" class="btn">search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>





            <!-- Brand Items - Products -->
            <div class="block">
                <div class="">
                    <div class="">
                        <table>
                            <thead>
                                <tr>
                                    <th class="ly">Training Program Id</th>
                                    <th class="ly">Training Program Name</th>

                                </tr>
                            </thead>
                        </table>
                        <div class="scr">
                            <table>
                                <?php
                                if (isset($_GET['departments'])) {
                                    $branchecked = [];
                                    $branchecked = $_GET['departments'];
                                    foreach ($branchecked as $rowbrand) {
                                        $gettr = "SELECT DISTINCT training_program_id FROM training_relations WHERE department_id = $rowbrand";
                                        $gettr_run =  pg_query($conn, $gettr);
                                        while ($row = pg_fetch_assoc($gettr_run)) {

                                            $tr_id_ar = $row["training_program_id"];


                                            $products = "SELECT DISTINCT * FROM create_training_programs WHERE training_program_id = $tr_id_ar";
                                            $products_run = pg_query($conn, $products);
                                            if (pg_num_rows($products_run) > 0) {
                                                while ($row = pg_fetch_assoc($products_run)) {
                                                    $training_name = $row['name'];
                                                    $training_id = $row['training_program_id'];
                                                    echo "
                                            <tbody>
                                                <tr>

                                                <td class='ly'>
                                                    <a href='analytics.php?training_program_id=$training_id'>
                                                        <p>$training_id</p>
                                                    </a>
                                                </td>

                                                    <td class='ly'>
                                                        <a href='analytics.php?training_program_id=$training_id'>
                                                            <p>$training_name</p>
                                                        </a>
                                                    </td>

                                                </tr>
                            
                                            </tbody>
                                        
                            
                                    ";
                                                }
                                            }
                                        }
                                    }
                                }


                                if (isset($_GET['start']) && isset($_GET['end'])) {
                                    $st = $_GET['start'];
                                    $en = $_GET['end'];
                                    $trid = array();
                                    $rep = "SELECT training_program_id FROM training_reports WHERE start_date BETWEEN '$st' AND '$en' ";
                                    $reprun = pg_query($conn, $rep);
                                    while ($row = pg_fetch_assoc($reprun)) {

                                        $trid[] = $row['training_program_id'];
                                    }
                                    foreach ($trid as $tri) {
                                        $trs = "SELECT * FROM create_training_programs WHERE training_program_id= $tri";
                                        $tt_run = pg_query($conn, $trs);

                                        while ($row = pg_fetch_assoc($tt_run)) {
                                            $training_namex = $row['name'];
                                            $training_idx = $row['training_program_id'];

                                            echo "
                                            <tbody>
                                                <tr>
                                                <td class='ly'>
                                                <a href='analytics.php?training_program_id=$training_idx'>
                                                    <p>$training_idx</p>
                                                </a>
                                            </td>
                            
                                                    <td class='ly'>
                                                        <a href='analytics.php?training_program_id=$training_idx'>
                                                            <p>$training_namex</p>
                                                        </a>
                                                    </td>
                            
                                                </tr>
                            
                                            </tbody>
                                        
                            
                                    ";
                                        }
                                    }
                                } else {
                                    $products = "SELECT * FROM create_training_programs";
                                    $products_run = pg_query($conn, $products);

                                    while ($row = pg_fetch_assoc($products_run)) {
                                        $training_namex = $row['name'];
                                        $training_idx = $row['training_program_id'];

                                        echo "
                <tbody>
                    <tr>
                    <td class='ly'>
                    <a href='analytics.php?training_program_id=$training_idx'>
                        <p>$training_idx</p>
                    </a>
                </td>

                        <td class='ly'>
                            <a href='analytics.php?training_program_id=$training_idx'>
                                <p>$training_namex</p>
                            </a>
                        </td>

                    </tr>

                </tbody>
            

        ";
                                    }
                                }


                                ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="manage.js"></script>

</body>

</html>