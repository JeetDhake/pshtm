<?php
include('connect.php');
header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$input = json_decode(file_get_contents('php://input'), true);
$department_ids = $input['department_ids'] ?? [];
$job_post_ids = $input['job_post_ids'] ?? [];
$search_term = $input['search_term'] ?? '';

$conditions = [];

if (!empty($department_ids)) {
    $dept_ids = implode(',', array_map('intval', $department_ids));
    $conditions[] = "department_id IN ($dept_ids)";
}

if (!empty($job_post_ids)) {
    $job_ids = implode(',', array_map('intval', $job_post_ids));
    $conditions[] = "job_post_id IN ($job_ids)";
}


// if (!empty($search_term)) {
//     $search_term = pg_escape_string($search_term); 
//     $conditions[] = "emp_uid = $search_term"; // Use emp_id instead of emp_uid if that's correct
// }


$query = "SELECT emp_id, emp_first_name, emp_middle_name, emp_last_name, emp_uid FROM employee_records";

if (!empty($conditions)) {
    $query .= " WHERE " . implode(' OR ', $conditions);  // Use AND to combine all conditions
}

$result = pg_query($conn, $query);

$employees = [];
if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        $employees[] = $row; 
    }


    echo json_encode(['employees' => $employees]);
} else {
 
    echo json_encode(['error' => 'Database query failed: ' . pg_last_error($conn)]);
}
?>
