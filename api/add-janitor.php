<?php
require_once '../includes/config.php';

if (!isLoggedIn() || !isAdmin()) {
    sendJSON(['success' => false, 'message' => 'Unauthorized']);
}

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $first_name = $conn->real_escape_string($data['first_name']);
    $last_name = $conn->real_escape_string($data['last_name']);
    $email = $conn->real_escape_string($data['email']);
    $phone = $conn->real_escape_string($data['phone']);
    $status = $conn->real_escape_string($data['status']);
    $password = password_hash('password', PASSWORD_DEFAULT);
    $employee_id = 'JAN-' . str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);

    $sql = "INSERT INTO users (employee_id, first_name, last_name, email, phone, password, role, status) 
            VALUES ('$employee_id', '$first_name', '$last_name', '$email', '$phone', '$password', 'janitor', '$status')";

    if ($conn->query($sql)) {
        sendJSON(['success' => true, 'message' => 'Janitor added successfully', 'user_id' => $conn->insert_id]);
    } else {
        sendJSON(['success' => false, 'message' => $conn->error]);
    }
} catch (Exception $e) {
    sendJSON(['success' => false, 'message' => $e->getMessage()]);
}
?>
