<?php
include 'connection.php';
if(isset($_GET['deLId']))
{
$id=$_GET['deLId'];
$result=mysqli_query($con,"delete from learner where LID=$id");
if($result){
   header("Location:UserInfo.php");
}
else {
die(mysqli_error($con));
}
}else {
   echo "Error deleting learner: " . mysqli_error($con);
   }


?>