<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli('localhost', 'root', '', 'restaurant_db');
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

$reservationId = $_POST['id'] ?? '';

if ($reservationId) {
    $sql = "DELETE FROM reservations WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reservationId);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Failed to delete reservation: ' . $stmt->error]);
    }
    
    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid reservation ID']);
}
$conn->close();
?>
