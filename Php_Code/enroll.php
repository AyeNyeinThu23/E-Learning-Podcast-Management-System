<?php
include 'connection.php';
session_start();

$email = $_SESSION['email'];
$learner = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM learner WHERE email='$email'"));
$LID = $learner['LID'];

$CID = $_POST['CID']; 


$check = mysqli_query($con, "SELECT * FROM Enrollment WHERE CID='$CID' AND LID='$LID'");
if(mysqli_num_rows($check) == 0){
    $stmt = $con->prepare("CALL EnrollLearner(?, ?)");
    $stmt->bind_param("ii", $LID, $CID);
    $stmt->execute();
    $stmt->close();
    $con->next_result();
}


header("Location: course.php?cid=$CID");
exit();
?>
