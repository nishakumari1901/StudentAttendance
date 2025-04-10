<?php
session_start();
include_once 'db.php';
include 'sidebar.php';
$class = $_POST['class'] ?? '';
$subject = $_POST['subject'] ?? '';
$date = date('Y-m-d');

//$attendance = mysqli_query($conn, "SELECT roll_no, username FROM users WHERE role='student' AND class='$class'");
$query = "SELECT a.roll_no, a.student_name,
    (SELECT COUNT(DISTINCT date) FROM attendance_records 
     WHERE class='$class' AND subject='$subject') AS total_classes,
    (SELECT COUNT(*) FROM attendance_records 
     WHERE roll_no=a.roll_no AND class='$class' 
     AND subject='$subject' AND status='Present') AS total_present
FROM attendance a 
WHERE a.class='$class'";
$attendance=mysqli_query($conn, $query);
if (!$attendance) {
    die("Query Failed: ".mysqli_error($conn)."|SQL:".$query);
}
?>

<!DOCTYPE html><html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="mark_attendance.css">
</head>
<body>
<div class="main-content">
    <h2>Mark Attendance for <?php echo "$class - $subject on $date"; ?></h2>
    <form action="save_attendance.php" method="POST">
    <input type="hidden" name="class" value="<?php echo $class; ?>">
    <input type="hidden" name="subject" value="<?php echo $subject; ?>">
    <input type="hidden" name="date" value="<?php echo $date; ?>">
    <div class="btn">
    <button type="submit">Save Attendance</button>
    </div>
        <table  border="2" align=center>
            <caption>Daily Attendance</caption>
            <tr>
                <th>Roll No</th>
                <th>Student Name</th>
                <?php for ($i = 1; $i <= 31; $i++) echo "<th>$i</th>"; ?>
                <th>Total Class</th>
                <th>Total Present</th>
                <th>Total Absent</th>
                <th>Percentage</th>
            </tr>
            <?php 
            while ($row = mysqli_fetch_assoc($attendance)) { ?>
        <tr>
            <td><?php echo $row['roll_no']; ?></td>
            <td><?php echo $row['student_name']; ?></td>
            <?php for ($i = 1; $i <= 31; $i++) 
            echo "<td><input type='checkbox' name='attendance[{$row['roll_no']}][$i]' value='Present'></td>"; ?>
            <td><?php echo $row['total_classes']; ?></td>
            <td><?php echo $row['total_present']; ?></td>
            <td><?php echo $row['total_classes'] - $row['total_present']; ?></td>
    <td><?php echo ($row['total_classes'] > 0) ? round(($row['total_present'] / $row['total_classes']) * 100, 2) . '%' : '0%'; ?></td>
        </tr>
        <?php } ?>
    </table>
    </div>
    
</form>

</body>
</html>