<?php

$key = "passwordkey@123"; // Keep this safe and hidden
$password = "12345";

// Encrypt before storing
$encrypted = openssl_encrypt($password, "AES-128-ECB", $key);

// Save $encrypted into DB
echo "Encrypted: " . $encrypted;

// Later, to decrypt:
$decrypted = openssl_decrypt($encrypted, "AES-128-ECB", $key);
echo "Original password: " . $decrypted;
?>