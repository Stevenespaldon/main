<?php

$token = $_POST['token'];

$token_hash = hash('sha256', $token);

require 'includes/config.php';

$sql = "SELECT * FROM users 
        WHERE reset_token_hash = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param('s', $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$users = $result->fetch_assoc();

if ($users === null) {
    die('token not found');
}

if (strtotime($users['reset_token_expires_at']) <= time() ) {
    die('token expired');
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql = "UPDATE users 
        SET password = ?, 
            reset_token_hash = NULL, 
            reset_token_expires_at = NULL 
        WHERE user_id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param('si', $password_hash, $users['user_id']);

$stmt->execute();

header("Location: index.php?message=Password has been reset successfully");
exit();
?>
