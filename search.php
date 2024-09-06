<?php
include('connect.php');

$searchTerm = $_POST['searchTerm'];



$output="";
$sql = pg_query($conn, "SELECT * FROM employee_records WHERE emp_first_name LIKE '%{$searchTerm}%' OR emp_last_name LIKE '%{$searchTerm}%'");
if (pg_num_rows($sql) > 0) {

        while ($row = pg_fetch_assoc($sql)) {
            $emp_id = $row['emp_id'];
            $emp_first_name = $row['emp_first_name'];
            $emp_last_name = $row['emp_last_name'];
    
            $emp_department_id = $row['department_id'];
            $emp_job_post_id = $row['job_post_id'];
    
            $emp_email = $row['emp_email'];
            $emp_phone = $row['emp_mobile'];
          
    
    
            $select_query1 = "SELECT department_name FROM department WHERE department_id=$emp_department_id";
            $result_query1 = pg_query($conn, $select_query1);
        
            while ($row1 = pg_fetch_assoc($result_query1)) {
                $emp_department = $row1['department_name'];
            }
    
    
            $select_query2 = "SELECT job_post_name FROM job_post WHERE job_post_id=$emp_job_post_id";
            $result_query2 = pg_query($conn, $select_query2);
        
            while ($row2 = pg_fetch_assoc($result_query2)) {
                $emp_job_post = $row2['job_post_name'];
            }



        $output .= '
                    <a href="">
        <div class="card-container">

            <img class="round" src="img/user1.png" alt="user" />
            <h3>' . $emp_first_name . ' ' . $emp_last_name . '</h3>
            <h6>Department: ' . $emp_department . '</h6>
            <h6>Job post: ' . $emp_job_post . '</h6>
            <p>' . $emp_email . ' ' . $emp_phone . '</p>
            <div class="buttons">

                <button class="primary">
                    Edit Details
                </button>
                <button class="primary ghost">
                    Deactivate
                </button>
            </div>
            

        </div>

    </a>

        ';

    }

} else {
    $output .= '<div class="all"><a href=""><div class="card-container"><h3>No Employee Found</h3></div></a></div>';
}
echo $output;

?>