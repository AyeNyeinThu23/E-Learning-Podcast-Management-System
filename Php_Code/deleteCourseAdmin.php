<?php

include 'connection.php';

if (isset($_GET['deCId'])) {
    $CID = intval($_GET['deCId']);

    $sql = "DELETE FROM Courses WHERE CID = $CID";
    if (mysqli_query($con, $sql)) {
         header("Location:CourseInfoAdmin.php");
    } else {
        echo "Error deleting course: " . mysqli_error($con);
    }
}
?>
