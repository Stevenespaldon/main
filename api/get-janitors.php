<?php
require_once '../includes/config.php';

if (!isLoggedIn() || !isAdmin()) {
    sendJSON(['success' => false, 'message' => 'Unauthorized']);
}

try {
    $filter = $_GET['filter'] ?? 'all';
    
    $sql = "SELECT u.user_id, u.first_name, u.last_name, u.email, u.phone, u.status, u.employee_id,
                   COUNT(b.bin_id) as assigned_bins
            FROM users u
            LEFT JOIN bins b ON u.user_id = b.assigned_to
            WHERE u.role = 'janitor'";

    $params = [];
    if ($filter !== 'all') {
        $sql .= " AND u.status = ?";
        $params[] = $filter;
    }

    $sql .= " GROUP BY u.user_id ORDER BY u.first_name ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $janitors = $stmt->fetchAll();

    sendJSON(['success' => true, 'janitors' => $janitors]);
} catch (Exception $e) {
    sendJSON(['success' => false, 'message' => $e->getMessage()]);
}
?>
