<?php

include 'connection.php';

if (isset($_GET['DLId'])) {
    $LID = intval($_GET['DLId']);

$sqlLesson = mysqli_query($con, "SELECT * FROM lessons WHERE LessonID='$LID'");
$Lesson=mysqli_fetch_array($sqlLesson);
$cid=$Lesson["CID"];

    $sql = "DELETE FROM Lessons WHERE LessonID = $LID";
    if (mysqli_query($con, $sql)) {
         header("Location:lessons.php?id=$cid");
    } else {
        echo "Error deleting course: " . mysqli_error($con);
    }
}
?>