<?php

// Generate a secure random key
$secretKey = bin2hex(random_bytes(32)); // 64 characters long

echo "Generated JWT Secret Key:\n";
echo $secretKey . "\n\n";
echo "Add this to your .env file as:\n";
echo "JWT_SECRET=" . $secretKey . "\n"; 