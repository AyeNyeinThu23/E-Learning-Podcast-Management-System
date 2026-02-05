<?php
include 'connection.php';
session_start();
$email=$_SESSION['email'];
$result=mysqli_query($con,"SELECT * from learner where email='$email'");
$user=mysqli_fetch_array($result);
$LID=$user['LID'];


if (isset($_POST['ReviewSubmit'])) {
   
    $rating = $_POST["rating"];
    $comment = $_POST["comment"];
    $CID=$_POST["CID"];

    if ($rating >= 1 && $rating <= 5 && $CID > 0 && $LID > 0) {
        
        $sql = "INSERT INTO Ratings (CID, LID, review, rating) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iisi", $CID, $LID, $comment, $rating);

        if ($stmt->execute()) {
            header("Location: course.php?cid=".$CID);
            exit();
        } 
    } else {
        echo "Invalid input. Please try again.";
    }
} 
?>
