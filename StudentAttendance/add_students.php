<?php
include_once 'db.php';
include 'sidebar.php'; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roll_no = $_POST['roll_no'];
    $student_name = $_POST['student_name'];
    $class = $_POST['class'];

    $query = "INSERT INTO attendance (roll_no, student_name, class) 
              VALUES ('$roll_no', '$student_name', '$class')";

    if (mysqli_query($conn, $query)) {
        echo "Student added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<h2>Add Student</h2>
<form method="POST">
    Roll No: <input type="text" name="roll_no" required><br>
    Name: <input type="text" name="student_name" required><br>
    Class: <input type="text" name="class" required><br>
    <button type="submit">Add Student</button>
</form>