<?php

include('connect.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/manage_dept.css">
    <title>Department</title>
</head>

<body>
    <?php require_once("navbar.html") ?>
    <?php require_once("sidebar.html") ?>
    <div class="container">


        <table>
            <thead>
                <tr>
                    <th class="lx">Department</th>
                    <th>Update</th>
                   

                </tr>
            </thead>

            <?php

            $select_query = "SELECT * FROM department";
            $result_query = pg_query($conn, $select_query);


            while ($row = pg_fetch_assoc($result_query)) {

                $emp_department_name = $row['department_name'];
                $department_id = $row['department_id'];



                echo "
                <tbody>
                    <tr>
                        <td class='lx'><p>$emp_department_name</p></td>
                        <td>
                        <a href='dept_update.php?department_id=$department_id'>
                                <p class='p-g'>Update</p>
                            </a>
                        </td>
                        
                    </tr>

                </tbody>
            

        ";
        
            }

//dept_delete.php?department_id=$department_id


            ?>
        </table>

    </div>



    <script src="manage.js"></script>
</body>

</html>
