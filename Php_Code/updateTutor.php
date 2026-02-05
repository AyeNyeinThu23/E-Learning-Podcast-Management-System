<?php
include 'connection.php';
session_start();

$TID = $_SESSION['TID'];
$sql="select * from Tutor where TID='$TID'";
$result=mysqli_query($con,$sql);
$row=mysqli_fetch_array($result);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Personal Info</title>
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
            width:450px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        input[type=file],textarea,input[type=text], input[type=password], select ,input[type=email]{
            width: 90%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
            transition: border 0.3s ease;
        }

        input[type=file]:focus,textarea:focus,input[type=text]:focus, input[type=password]:focus,input[type=email]:focus, select:focus {
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
     <a href="TutorProfile.php" class="back-button">← Back</a>
    <div class="login-container">
        <h2>Update Profile</h2>
        <?php 
        if (isset($_SESSION['emailforcheckInUpdate'])) {
            echo '<div class="error-message">'.htmlspecialchars($_SESSION['emailforcheckInUpdate']).'</div>';
            unset($_SESSION['emailforcheckInUpdate']);  // Clear error after showing it once
        }
        ?>
        <form method="post" action="updateTutor.php">
           <label>Name:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($row['name']);?>" autocomplete="off">

            <label>Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($row['email']);?>" autocomplete="off">

            <label>Password:</label>
            <input type="text" name="password" id="password" value="<?php echo htmlspecialchars($_SESSION['real_password']);?>" autocomplete="off">

            <input type="submit" value="Update" name="submit" id="submit">
        </form>
    </div>

<?php

if(isset($_POST['submit'])) {
    
    $name =  $_POST['name'];
    $email =  $_POST['email'];
    $password = $_POST['password'];
   // Encryption key
    $key = "passwordkey@123";
    $encryptedPassword = openssl_encrypt($password, "AES-128-ECB", $key);
    $decryptedPassword = openssl_decrypt($encryptedPassword, "AES-128-ECB", $key);

    // Check if email is already used by another tutor
    $stmt = $con->prepare("SELECT TID FROM Tutor WHERE email = ? AND TID != ?");
    $stmt->bind_param("si", $email, $TID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $_SESSION['emailforcheckInUpdate'] = "Email is already taken!";
        header("Location:updateTutor.php"); // redirect back to form
        exit();
    }

    // Update tutor info
    $stmt = $con->prepare("UPDATE Tutor SET name = ?, email = ?, password = ? WHERE TID = ?");
    $stmt->bind_param("sssi", $name, $email, $encryptedPassword, $TID);

    if ($stmt->execute()) {
        // Update session variables
        $_SESSION['email'] = $email;
        $_SESSION['real_password'] = $decryptedPassword;
        header("Location:TutorProfile.php");
        exit();
    } else {
        die("Error updating tutor: " . $stmt->error);
    }
}
?>
</body>
</html>
