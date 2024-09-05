<?php
include('connect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/view_tr.css">
    <title>Training</title>
</head>

<body>

    <?php require_once("navbar.html") ?>
    <?php require_once("sidebartr.html") ?>

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
        </div>
    </div>

    <script src="manage.js"></script>
</body>

</html>