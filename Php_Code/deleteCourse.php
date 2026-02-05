<?php

include 'connection.php';

if (isset($_GET['deId'])) {
    $CID = intval($_GET['deId']);

    $sql = "DELETE FROM Courses WHERE CID = $CID";
    if (mysqli_query($con, $sql)) {
         header("Location:Course_Info.php");
    } else {
        echo "Error deleting course: " . mysqli_error($con);
    }
}
?>