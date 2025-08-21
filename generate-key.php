<?php
// Simple key generator
$key = 'base64:' . base64_encode(random_bytes(32));
echo "Generated Laravel Key: " . $key . "\n\n";
echo "Add this to your .env file as:\n";
echo "APP_KEY=" . $key;
?>