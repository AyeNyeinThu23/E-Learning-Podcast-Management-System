<?php
include 'connection.php';


if(isset($_POST['submit'])){
$id=$_GET['upId']; 

$sqlLesson = mysqli_query($con, "SELECT * FROM lessons WHERE LessonID='$id'");
$Lesson=mysqli_fetch_array($sqlLesson);
$cid=$Lesson["CID"];

     
    $title=$_POST['title'];
    $description = $_POST['description'];

   // Handle file upload (optional)
    $file_path = ''; // keep empty by default
    if(isset($_FILES['audio']) && $_FILES['audio']['error'] == 0) {
        $uploadDir = 'uploads/'; // make sure this folder exists and is writable
        $fileName = basename($_FILES['audio']['name']);
        $targetFile = $uploadDir . time() . '_' . $fileName; // unique filename

        if(move_uploaded_file($_FILES['audio']['tmp_name'], $targetFile)) {
            $file_path = mysqli_real_escape_string($con, $targetFile);
        } else {
            echo "Error uploading audio file.";
            exit;
        }
    }

    // Build SQL query
    if($file_path != '') {
        // Update with new file
        $sql = "UPDATE lessons 
                SET title='$title', description='$description', file_path='$file_path' 
                WHERE LessonID=$id";
    } else {
        // Update without changing file
        $sql = "UPDATE lessons 
                SET title='$title', description='$description' 
                WHERE LessonID=$id";
    }

    if(mysqli_query($con, $sql)) {
     
        header("Location:lessons.php?id=$cid"); 
        exit;
    } else {
        echo "Error updating lesson: " . mysqli_error($con);
    }
} else {
    echo "Invalid request.";
}
?>