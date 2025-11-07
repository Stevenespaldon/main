<?php
require_once '../includes/config.php';

if (!isLoggedIn() || !isAdmin()) {
    sendJSON(['success' => false, 'message' => 'Unauthorized']);
}

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['user_id'])) {
        sendJSON(['success' => false, 'message' => 'user_id is required']);
        exit;
    }
    
    $user_id = intval($data['user_id']);

    // First check if tasks table has assigned_to column before deleting
    // For now, we'll skip this if the column doesn't exist in your table

    // Update bins to remove assignment
    $stmt = $conn->prepare("UPDATE bins SET assigned_to = NULL WHERE assigned_to = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    // Delete the janitor
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ? AND role = 'janitor'");
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        sendJSON(['success' => true, 'message' => 'Janitor deleted successfully']);
    } else {
        sendJSON(['success' => false, 'message' => $conn->error]);
    }
} catch (Exception $e) {
    sendJSON(['success' => false, 'message' => $e->getMessage()]);
}
?>
