<?php
include 'connection.php';
session_start();
if(isset($_POST['submit'])) {
    $upId=$_POST['upId'];
    $title =  $_POST['title'];
    $language =  $_POST['language'];
    $sql = "UPDATE courses 
                SET Title='$title', language='$language' 
                WHERE CID=$upId";
    

    if(mysqli_query($con, $sql)) {
     
        header("Location:Course_Info.php"); 
        exit;
    } else {
        echo "Error updating lesson: " . mysqli_error($con);
    }

}
?>