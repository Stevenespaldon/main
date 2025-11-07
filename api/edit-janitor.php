<?php
require_once '../includes/config.php';

if (!isLoggedIn() || !isAdmin()) {
    sendJSON(['success' => false, 'message' => 'Unauthorized']);
}

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $user_id = intval($data['user_id']);
    $first_name = $conn->real_escape_string($data['first_name']);
    $last_name = $conn->real_escape_string($data['last_name']);
    $email = $conn->real_escape_string($data['email']);
    $phone = $conn->real_escape_string($data['phone']);
    $status = $conn->real_escape_string($data['status']);

    $sql = "UPDATE users 
            SET first_name = '$first_name', last_name = '$last_name', email = '$email', phone = '$phone', status = '$status'
            WHERE user_id = $user_id AND role = 'janitor'";

    if ($conn->query($sql)) {
        sendJSON(['success' => true, 'message' => 'Janitor updated successfully']);
    } else {
        sendJSON(['success' => false, 'message' => $conn->error]);
    }
} catch (Exception $e) {
    sendJSON(['success' => false, 'message' => $e->getMessage()]);
}
?>
