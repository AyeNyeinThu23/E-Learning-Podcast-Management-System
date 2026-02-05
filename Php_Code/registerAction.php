<?php
include 'connection.php';
session_start();
if(isset($_POST['register'])) {
    $name =  $_POST['name'];
    $email =  $_POST['email'];
    $password =  $_POST['password'];
    $key = "passwordkey@123";
    $encryptedPassword = openssl_encrypt($password, "AES-128-ECB", $key);
    $language = $_POST['language'];
    $decryptedPassword = openssl_decrypt($encryptedPassword, "AES-128-ECB", $key);


    
    $stmt = $con->prepare("SELECT email FROM learner WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $_SESSION['emailforcheck']='You have already registered!';
        header('Location: login.php');
        exit();
    } else {
        // Email does not exist, proceed with insertion
        
        $stmt = $con->prepare("INSERT INTO `learner`(`name`, `password`,`email`,`language`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name,$encryptedPassword,$email,$language);
        
            if ($stmt->execute()) {
                $_SESSION['email'] = $email;
                $_SESSION['real_password'] = $decryptedPassword;
                header("Location:index.php");
                exit();
            } 
         else {
            die("Error inserting user: " . $stmt->error);
        }
    }
}
?>