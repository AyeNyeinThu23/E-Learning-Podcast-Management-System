<?php
include 'connection.php';
session_start();
if (isset($_POST['upload'])) {
    $Cid = $_GET['cid'];  
    $Title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    $fileName = time() . "_" . basename($_FILES['audio']['name']);
    $targetFilePath = $targetDir . $fileName;
    
 // Check if file is uploaded
    if (!isset($_FILES['audio']) || $_FILES['audio']['error'] != 0) {
        $_SESSION['msg'] = "No file uploaded or file upload error.";
        header("Location: lessons.php?id=$Cid");
        exit;
    }

    if (move_uploaded_file($_FILES['audio']['tmp_name'], $targetFilePath)) {
        $sql = mysqli_query($con, "INSERT INTO Lessons (CID, title, file_path, description) 
                                   VALUES ('$Cid', '$Title', '$targetFilePath', '$description')");
        if ($sql) {
            $_SESSION['msg'] = "Podcast uploaded successfully!";
            header("Location: lessons.php?id=$Cid");
            exit;
        }
        else{
            $_SESSION['msg'] = "Database error: " . mysqli_error($con);
            header("Location: lessons.php?id=$Cid");
            exit;
        }
    } else {
        $_SESSION['msg'] = "Error uploading podcast.";
        header("Location: lessons.php?id=$Cid");
        exit;
    }
}
?>
