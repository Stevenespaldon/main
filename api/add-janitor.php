<?php
require_once '../includes/config.php';

if (!isLoggedIn() || !isAdmin()) {
    sendJSON(['success' => false, 'message' => 'Unauthorized']);
}

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!is_array($data)) {
        sendJSON(['success' => false, 'message' => 'Invalid input']);
    }

    $first_name = trim($data['first_name'] ?? '');
    $last_name  = trim($data['last_name'] ?? '');
    $email      = trim($data['email'] ?? '');
    $phone      = trim($data['phone'] ?? '');
    $status     = trim($data['status'] ?? 'inactive');

    if ($first_name === '' || $last_name === '' || $email === '') {
        sendJSON(['success' => false, 'message' => 'Missing required fields']);
    }

    // generate employee id using helper if available
    $employee_id = function_exists('generateEmployeeId') ? generateEmployeeId() : ('JAN-' . str_pad((string) rand(1, 99999), 5, '0', STR_PAD_LEFT));

    // default password - consider sending reset link to janitor instead
    $passwordHash = password_hash('password', PASSWORD_DEFAULT);

    $sql = "INSERT INTO janitors (employee_id, first_name, last_name, email, phone, password, status, created_at)
            VALUES (:employee_id, :first_name, :last_name, :email, :phone, :password, :status, NOW())";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':employee_id' => $employee_id,
        ':first_name'  => $first_name,
        ':last_name'   => $last_name,
        ':email'       => $email,
        ':phone'       => $phone,
        ':password'    => $passwordHash,
        ':status'      => $status
    ]);

    $insertId = (int)$pdo->lastInsertId();

    sendJSON(['success' => true, 'message' => 'Janitor added successfully', 'janitor_id' => $insertId]);
} catch (Exception $e) {
    sendJSON(['success' => false, 'message' => $e->getMessage()]);
}
?>