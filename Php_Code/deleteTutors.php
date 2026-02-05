<?php
include 'connection.php';
if(isset($_GET['deTId']))
{  
    $id=$_GET['deTId'];
    
    // 1. Get all courses assigned to this tutor via TCA
    $course_ids = [];
    $course_result = mysqli_query($con, "SELECT CID FROM TCA WHERE TID = $id");
    while($row = mysqli_fetch_assoc($course_result)) {
        $course_ids[] = $row['CID'];
    }

    if(!empty($course_ids)) {
        $course_ids_str = implode(',', $course_ids);

        // 2. Delete ratings
        mysqli_query($con, "DELETE FROM Ratings WHERE CID IN ($course_ids_str)");

        // 3. Delete enrollments
        mysqli_query($con, "DELETE FROM Enrollment WHERE CID IN ($course_ids_str)");

        // 4. Delete lessons
        mysqli_query($con, "DELETE FROM Lessons WHERE CID IN ($course_ids_str)");

        // 5. Delete TCA links
        mysqli_query($con, "DELETE FROM TCA WHERE CID IN ($course_ids_str)");
    }

    // 6. Finally delete the tutor
    $delete_tutor = mysqli_query($con, "DELETE FROM Tutor WHERE TID = '$id'");

    if($delete_tutor) {
        header("Location:TutorInfo.php");
    } else {
        echo "Error deleting tutor: " . mysqli_error($con);
    }
}
?>