<?php
session_start();
include 'connection.php';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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

        input[type=text], input[type=password],input[type=email], select {
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
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Tutor Registration</h2>
        <form method="post" action="registerTutorAction.php">
             <label>Name:</label>
            <input type="text" name="name" id="name" required autocomplete="off">

            <label>Email:</label>
            <input type="email" name="email" id="email" required autocomplete="off">

            <label>Password:</label>
            <input type="password" name="password" id="password" required autocomplete="off">

            <div><p>If you have already registered! <a href="login.php" >Login Here</a></p></div>
            <input type="submit" value="Join" name="register" id="register">
        </form>
    </div>
    </body>
</html>
