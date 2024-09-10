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
    <link rel="stylesheet" href="style/manage_job.css">
    <link rel="stylesheet" href="style/sidebar.css">
    <title>Department</title>
</head>

<body>
    <?php require_once("navbar.html") ?>
    <?php require_once("sidebar.html") ?>
    <div class="container">

        <div class="op">

            <table>
                <thead>
                    <tr>
                        <th class="ly">Job Post</th>

                        <th>Update</th>


                    </tr>
                </thead>
            </table>
            <div class="tbd">
                <table>
                    <?php

                    $select_query = "SELECT * FROM job_post";
                    $result_query = pg_query($conn, $select_query);


                    while ($row = pg_fetch_assoc($result_query)) {


                        $emp_job_post = $row['job_post_name'];
                        $job_post_id = $row['job_post_id'];

                        echo "
                <tbody>
                    <tr>
                        <td class='ly'><p>$emp_job_post</p></td>
                    
                        <td>
                            <a href=''><a href='job_edit.php?job_post_id=$job_post_id'>
                                <p class='p-g'>Update</p>
                            </a>
                        </td>
                        <td>
                    
                        </td>
                    </tr>

                </tbody>        

        ";
                    }
                    //job_delete.php?job_post_id=$job_post_id
                    ?>
                </table>

            </div>
        </div>

    </div>

    <script src="manage.js"></script>
</body>

</html>