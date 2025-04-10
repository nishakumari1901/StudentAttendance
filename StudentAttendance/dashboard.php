<?php
session_start();
//if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
  //  header("Location: index.html");
    //exit();
//}

include_once 'db.php';
include 'sidebar.php';
// Fetch classes and subjects from the database
$classes = mysqli_query($conn, "SELECT DISTINCT class_name FROM classes");
$subjects = mysqli_query($conn, "SELECT DISTINCT subject_name FROM subjects");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <h2>Welcome, <?php echo isset($_SESSION['username'])? $_SESSION['username']:'Guest Faculty'; ?> (Teacher)</h2>
    
    <form action="mark_attendance.php" method="POST">
        <label for="class">Select Class:</label>
        <select name="class" required>
            <?php while ($row = mysqli_fetch_assoc($classes)) { ?>
                <option value="<?php echo $row['class_name']; ?>"><?php echo $row['class_name']; ?></option>
            <?php } ?>
        </select>

        <label for="subject">Select Subject:</label>
        <select name="subject" required>
            <?php while ($row = mysqli_fetch_assoc($subjects)) { ?>
                <option value="<?php echo $row['subject_name']; ?>"><?php echo $row['subject_name']; ?></option>
            <?php } ?>
        </select>
        
        <button type="submit">Proceed to Mark Attendance
        <a href="mark_attendance.php">
        </button>
            </a>
    </form>
</body>
</html>
