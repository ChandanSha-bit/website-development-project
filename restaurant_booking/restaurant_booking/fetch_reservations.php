<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli('localhost', 'root', '', 'restaurant_db');
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Ensure the user is logged in and get the user_id from the session
if (!isset($_SESSION['user_id'])) {
    die(json_encode(['error' => 'User not logged in']));
}

$user_id = $_SESSION['user_id']; // Assuming you stored user_id in session

if ($user_id == 1) {
    $sql = "SELECT id, name, restaurant, reservation_date, reservation_time, guests FROM reservations";
    $stmt = $conn->prepare($sql);
}
else {
    $sql = "SELECT id, name, restaurant, reservation_date, reservation_time, guests FROM reservations WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
}
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die(json_encode(['error' => 'Query failed: ' . $conn->error]));
}

$reservations = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($reservations);

$stmt->close();
$conn->close();
?>
