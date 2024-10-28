<?php
include('connect.php');

$searchTerm = $_POST['searchTerm'];



$output = "";
$sql = pg_query($conn, "SELECT * FROM employee_records WHERE emp_first_name ILIKE '%{$searchTerm}%' OR emp_last_name ILIKE '%{$searchTerm}%' OR emp_uid::text = '{$searchTerm}'");
if (pg_num_rows($sql) > 0) {

    while ($row = pg_fetch_assoc($sql)) {
        $emp_uid_ar = $row['emp_uid'];
        $emp_first_name = $row['emp_first_name'];
        $emp_middle_name = $row['emp_middle_name'];
        $emp_last_name = $row['emp_last_name'];


        $output .= "
                     <tbody>
                                            <tr>

                                            <td class='ly'>
                                                <a href='emp_analytics.php?u_id=$emp_uid_ar'>
                                                    <p>$emp_uid_ar</p>
                                                </a>
                                            </td>

                                                <td class='ly'>
                                                    <a href='emp_analytics.php?u_id=$emp_uid_ar'>
                                                        <p>$emp_first_name $emp_middle_name $emp_last_name</p>
                                                    </a>
                                                </td>

                                            </tr>
                        
                                        </tbody>
        ";
    }
} else {
    $output .= '<div class="all"><a href=""><div class="card-container"><h3>No Employee Found</h3></div></a></div>';
}
echo $output;
