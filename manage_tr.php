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
    <title>Training</title>
</head>

<body>
    <?php require_once("navbar.html") ?>
    <?php require_once("sidebartr.html") ?>
    <div class="container">
        <div class="op">


            <table>
                <thead>
                    <tr>
                        <th class="ly">Training Program Name</th>

                        <th>Update</th>


                    </tr>
                </thead>
            </table>
            <div class="tbd">
                <table>
                    <?php

                    $select_query = "SELECT DISTINCT * FROM create_training_programs ";

                    $result_query = pg_query($conn, $select_query);


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

                    ?>


                </table>
            </div>
        </div>
    </div>



    <script src="manage.js"></script>
</body>

</html>