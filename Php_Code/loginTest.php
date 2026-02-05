<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location:index.php");
 }
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
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
         <?php
        if (isset($_SESSION['error'])) {
            echo '<div class="error-message">'.htmlspecialchars($_SESSION['error']).'</div>';
            unset($_SESSION['error']);  // Clear error after showing it once
        }
         if(isset($_SESSION['emailforcheck'])){
            echo '<div class="error-message">'.htmlspecialchars($_SESSION['emailforcheck']).'</div>';
            unset($_SESSION['emailforcheck']);  // Clear error after showing it once 
         }
        ?>
        <form method="post" action="login.php">
            <label>Email:</label>
            <input type="email" name="email" id="email" required autocomplete="off">

            <label>Password:</label>
            <input type="password" name="password" id="password" required autocomplete="off">

            <label>Login as:</label>
            <select name="role" required>
                <option value="admin">Admin</option>
                <option value="tutor">Tutor</option>
                <option value="learner">Learner</option>
            </select>
            


        <p><a href="register.php" >Sign Up as Learner</a> |
        <a href="registerTutor.php" >Join as Tutor</a></p>
            <input type="submit" value="Login" name="submit" id="submit">
        </form>
    </div>
<?php

include 'connection.php';
if(isset($_POST['submit'])){
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];

// Table selection based on role
$table = "";
if ($role == "admin") {
    $table = "admin";
} elseif ($role == "tutor") {
    $table = "tutor";
} elseif ($role == "learner") {
    $table = "learner";
}
// Step 1: Find user by username
$sql = "SELECT * FROM $table WHERE email=?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$key = "passwordkey@123";

// Step 2: If user exists, check password
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $decryptedPassword = openssl_decrypt($row['password'], "AES-128-ECB", $key);

    if ($password === $decryptedPassword) {
        // ✅ Password correct
        $_SESSION['email'] = $email;
        $_SESSION['real_password'] = $decryptedPassword; // so you can show it later
   
        // Redirect to correct dashboard
        if ($role == "admin") {
            header("Location:admin_dashboard.php");
        } elseif ($role == "tutor") {
            header("Location:tutor_dashboard.php");
        } else {
            header("Location:index.php");
        }
        exit();
    } else {
        $_SESSION['error'] = "Invalid password!";
        header("Location: login.php");
        exit();
    }
} else {
     $_SESSION['error'] = "User not found!";
    header("Location: login.php");
    exit();
}

$stmt->close();
$con->close();
}
?>


</body>
</html>
