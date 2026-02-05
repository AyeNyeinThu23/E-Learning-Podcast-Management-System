<?php
include 'connection.php';

$key = "passwordkey@123";
$username = "admin2";
$email="admin2@mail.com";
$password = "admin2111";
$encrypted = openssl_encrypt($password, "AES-128-ECB", $key);

$sql = "INSERT INTO admin (name, password, email) VALUES (?, ? , ?)";
$stmt = $con->prepare($sql);
$stmt->bind_param("sss", $username, $encrypted, $email);
$stmt->execute();

echo "admin inserted with encrypted password!";


?>
