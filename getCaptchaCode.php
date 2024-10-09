<?php
// Command to get the CAPTCHA Code from the Apache log
$captchaCodeCommand = "grep 'CAPTCHA Code' /var/log/apache2/error.log | tail -n 1 | awk -F ': ' '{print \$2}' | awk -F ',' '{print \$1}'";
$captchaCodeOutput = '';
exec($captchaCodeCommand, $captchaCodeOutput);

// The output from exec() is an array, so get the first element
$captchaCode = isset($captchaCodeOutput[0]) ? $captchaCodeOutput[0] : 'default-filename';

// Return the CAPTCHA code as JSON
echo json_encode(['captchaCode' => $captchaCode]);
?>