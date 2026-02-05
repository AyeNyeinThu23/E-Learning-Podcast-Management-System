<?php
include 'connection.php';
if(isset($_GET['deCId']))
{
$id=$_GET['deCId'];
$result=mysqli_query($con,"delete from courses where CID='$id'");
if($result){
   header("Location:CourseInfoAdmin.php");
}
else {
die(mysqli_error($con));
}
}else {
   echo "Error deleting Tutor: " . mysqli_error($con);
   }


?>