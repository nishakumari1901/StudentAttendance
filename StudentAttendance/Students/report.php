<?php
// Include database connection
require_once 'db_connect.php';

// Set headers to download the file as CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=attendance_report.csv');

// Open output stream
$output = fopen('php://output', 'w');

// Write column headers
fputcsv($output, ['Student ID', 'Student Name', 'Class', 'Subject', 'Date', 'Status']);

// Fetch attendance data from the database
$query = "SELECT users.id, users.username, classes.class_name, subjects.subject_name, attendance.date, attendance.status
          FROM attendance
          JOIN users ON attendance.student_id = users.id
          JOIN classes ON attendance.class_id = classes.id
          JOIN subjects ON attendance.subject_id = subjects.id
          ORDER BY attendance.date DESC";

$result = mysqli_query($conn, $query);

// Write rows to CSV
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}

// Close output stream
fclose($output);
exit;
?>