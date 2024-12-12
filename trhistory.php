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

    <link rel="stylesheet" href="style/analytics.css">
    <link rel="stylesheet" href="style/sidebar.css">


    <title>Analytics</title>
</head>

<body>
    <?php
    if (isset($_SESSION['admin_id'])) {
        require_once("navbar.html");
    } elseif (isset($_SESSION['trainer_id'])) {
        require_once("navbar2.html");
    }
    ?>
    <?php require_once("sidebana.html");

    ?>
    <div class="containerx">
        <div class="xoxi">

            <table>
                <thead>
                    <tr>
                        <th>Training Program ID</th>
                        <th>Training Program</th>
                        <th>Date</th>
                        <th>Attendance</th>
                        <th>Participation</th>
                        <th>Completion Rate</th>

                        <th>Proof Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_SESSION['admin_id'])) {

                        $tr_infoq = "SELECT * FROM create_training_programs ORDER BY date ASC";
                        $tr_infoq_run  = pg_query($conn, $tr_infoq);

                        if (pg_num_rows($tr_infoq_run) > 0) {
                            while ($ctp = pg_fetch_assoc($tr_infoq_run)) {
                                $aitr_id = $ctp['training_program_id'];
                                $trnmx = $ctp['name'];
                                $tr_datex = $ctp['date'];

                                $reltr_query = "SELECT * FROM training_trainer_relation WHERE training_program_id = $aitr_id";
                                $reltr_query_run  = pg_query($conn, $reltr_query);

                                if (pg_num_rows($reltr_query_run) > 0) {
                                    while ($ttr = pg_fetch_assoc($reltr_query_run)) {
                                        $seltr_id = $ttr['training_program_id'];

                                        $tr_query = "SELECT * FROM training_reports WHERE training_program_id = $seltr_id";
                                        $tr_query_run  = pg_query($conn, $tr_query);

                                        if (pg_num_rows($tr_query_run) > 0) {
                                            while ($trep = pg_fetch_assoc($tr_query_run)) {

                                                $trimg_query = "SELECT * FROM training_images WHERE training_program_id = $seltr_id";
                                                $trimg_query_run  = pg_query($conn, $trimg_query);

                                                if (pg_num_rows($trimg_query_run) > 0) {
                                                    while ($trimgl = pg_fetch_assoc($trimg_query_run)) {
                                                        $trimg = $trimgl['image'];

                    ?>
                                                        <tr>
                                                            <td><?php echo $trep['training_program_id']; ?></td>
                                                            <td><?php echo $trnmx; ?></td>
                                                            <td><?php echo $tr_datex; ?></td>

                                                            <td><?php echo $trep['attendance']; ?></td>
                                                            <td><?php echo $trep['participation']; ?></td>
                                                            <td><?php echo $trep['completion_rate']; ?></td>

                                                            <td class="imgbx"><img src="db_img2/<?php echo $trimg; ?>" alt="Proof" class="proofimg"></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        echo "No training Found";
                    }


                    if (isset($_SESSION['trainer_id'])) {
                        $trainerid = $_SESSION['trainer_id'];

                        $tr_infoq = "SELECT * FROM create_training_programs ORDER BY date ASC";
                        $tr_infoq_run  = pg_query($conn, $tr_infoq);

                        if (pg_num_rows($tr_infoq_run) > 0) {
                            while ($ctp = pg_fetch_assoc($tr_infoq_run)) {
                                $aitr_id = $ctp['training_program_id'];
                                $trnmx = $ctp['name'];
                                $tr_datex = $ctp['date'];

                                $reltr_query = "SELECT * FROM training_trainer_relation WHERE trainer_id = $trainerid AND training_program_id = $aitr_id";
                                $reltr_query_run  = pg_query($conn, $reltr_query);

                                if (pg_num_rows($reltr_query_run) > 0) {
                                    while ($ttr = pg_fetch_assoc($reltr_query_run)) {
                                        $seltr_id = $ttr['training_program_id'];

                                        $tr_query = "SELECT * FROM training_reports WHERE training_program_id = $seltr_id";
                                        $tr_query_run  = pg_query($conn, $tr_query);

                                        if (pg_num_rows($tr_query_run) > 0) {
                                            while ($trep = pg_fetch_assoc($tr_query_run)) {

                                                $trimg_query = "SELECT * FROM training_images WHERE training_program_id = $seltr_id";
                                                $trimg_query_run  = pg_query($conn, $trimg_query);

                                                if (pg_num_rows($trimg_query_run) > 0) {
                                                    while ($trimgl = pg_fetch_assoc($trimg_query_run)) {
                                                        $trimg = $trimgl['image'];

                                                    ?>
                                                        <tr>
                                                            <td><?php echo $trep['training_program_id']; ?></td>
                                                            <td><?php echo $trnmx; ?></td>
                                                            <td><?php echo $tr_datex; ?></td>

                                                            <td><?php echo $trep['attendance']; ?></td>
                                                            <td><?php echo $trep['participation']; ?></td>
                                                            <td><?php echo $trep['completion_rate']; ?></td>

                                                            <td class="imgbx"><img src="db_img2/<?php echo $trimg; ?>" alt="Proof" class="proofimg"></td>
                                                        </tr>
                    <?php
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    ?>

                </tbody>
            </table>

        </div>
    </div>

    <script src="manage.js"></script>

</body>

</html>