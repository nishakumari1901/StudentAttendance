<?php
session_start();
include_once 'db.php';

// Ensure only teachers can access this page
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    echo "<script>alert('Access denied! Only teachers can generate reports.'); window.location.href='dashboard.html';</script>";
    exit();
}

$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$attendance_records = mysqli_query($conn, "SELECT users.username, attendance.status FROM attendance JOIN users ON attendance.student_id = users.id WHERE attendance.date = '$date'");
?>

<!DOCTYPE html><html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="report-container">
        <h2>Attendance Report for <?php echo $date; ?></h2>
        <table>
            <tr>
                <th>Student Name</th>
                <th>Status</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($attendance_records)) { ?>
                <tr>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                </tr>
            <?php } ?>
        </table>
        <button onclick="window.location.href='download_report.php?date=<?php echo $date; ?>'">Download Report</button>
        <button onclick="window.location.href='dashboard.html'">Back to Dashboard</button>
    </div>
</body>
</html>