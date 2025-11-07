<?php

$email = $_POST['email'];

require 'includes/config.php';

$sql = "SELECT user_id FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Email address not found in our system.']);
    exit;
}

$token = bin2hex(random_bytes(16));

$token_hash = hash('sha256', $token);

$expiry = date('Y-m-d H:i:s', time() + 60 * 30); // 30 minutes from now

$sql = "UPDATE users 
SET reset_token_hash = ?, 
    reset_token_expires_at = ? 
    WHERE email = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $token_hash, $expiry, $email);

$stmt->execute();

if ($conn->affected_rows) {
    
    $mail = require 'mailer.php';

    $mail->setFrom("nevetsespaldon@gmail.com", "Smart Trashbin Support");
    $mail->addAddress($email);
    $mail->Subject = 'Password Reset Request';
    $mail->Body = <<<END
    <h2>Password Reset Request</h2>
    <p>Click the link below to reset your password. This link will expire in 30 minutes.</p>
    <p><a href="http://localhost/IncompleteTrashbin-main/reset-password.php?token=$token">Reset Password</a></p>
    <p>If you didn't request a password reset, please ignore this email.</p>
    END;

    try {
        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Password reset link has been sent to your email.']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send email. Please try again later.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Unable to process reset request. Please try again.']);
}
?>
