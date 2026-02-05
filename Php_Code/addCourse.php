<?php
include 'connection.php';
session_start();
$email=$_SESSION['email'];

$resultForTutor=mysqli_query($con,"select * from tutor where email='$email'");
$tutor=mysqli_fetch_array($resultForTutor);
$tid=$tutor["TID"];


?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: none; /* No background color or gradient */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.2);
            width: 320px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        input[type=text], input[type=password], select ,input[type=email]{
            width: 90%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
            transition: border 0.3s ease;
        }

        input[type=text]:focus, input[type=password]:focus,input[type=email]:focus, select:focus {
            border-color: #74ebd5;
        }

        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        label {
            float: left;
            margin-left: 5%;
            font-weight: bold;
            color: #444;
        }
        a:link{ text-decoration: none;color:blue;}
       
        a:hover{
            color:green;
        } 
        .error-message {
            background-color: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            text-align: center;
            font-weight: bold;
        }
    .back-button {
    position: absolute;
    top: 20px;
    left: 20px;
    text-decoration: none;
    color: #333;                 /* Dark text */
    background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent white */
    padding: 8px 14px;
    border-radius: 12px;         /* Rounded edges */
    font-weight: 500;
    font-size: 18px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* subtle shadow */
    transition: all 0.3s ease;
}

.back-button:hover {
    background-color: rgba(255, 255, 255, 1); /* Solid white on hover */
    color: #007BFF;            /* Soft blue text on hover */
    box-shadow: 0 6px 12px rgba(0,0,0,0.15); /* slightly stronger shadow */
    transform: translateY(-2px); /* subtle lift effect */
}

    </style>
</head>
<body>
    <a href="Course_Info.php" class="back-button">← Back</a>
    <div class="login-container">
        
        <h2>Course Infomation</h2>
       
        <form method="post" action="addCourse.php">
            <label>Title:</label>
            <input type="text" name="title" id="title" required autocomplete="off">

            <label>Language:</label>
            <input type="text" name="language" id="language" required autocomplete="off">

            
           
            <input type="submit" value="Create" name="createCourse" id="createCourse">
        </form>
    </div>

<?php
if(isset($_POST['createCourse'])){
$Title = $_POST['title'];
$Language = $_POST['language'];

$sqlCourse=mysqli_query($con,"INSERT INTO Courses (language,Title) VALUES ('$Language','$Title')");

if ($sqlCourse) {
    $CID = mysqli_insert_id($con);
    $resultForTCA=mysqli_query($con,"INSERT INTO TCA(TID, CID) VALUES ('$tid', '$CID')");
    if($resultForTCA){
        header("Location:Course_Info.php");
    }

} else {
        echo "Error adding association: " . mysqli_error($con);
    }

} 
?>


</body>
</html>
