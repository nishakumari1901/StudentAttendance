<?php
include_once 'db.php';
include 'sidebar.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roll_no = $_POST['roll_no'];

    $query = "DELETE FROM attendance WHERE roll_no='$roll_no'";

    if (mysqli_query($conn, $query)) {
        echo "Student removed successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<h2>Remove Student</h2>
<form method="POST">
    Roll No to Delete: <input type="text" name="roll_no" required><br>
    <button type="submit">Delete Student</button>
</form>