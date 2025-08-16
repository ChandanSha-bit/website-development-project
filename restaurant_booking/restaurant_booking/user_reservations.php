<?php
session_start();
include 'includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);


// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Fetch reservations made by the logged-in user
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM reservations WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);
?>

<h2>Your Reservations</h2>
<table>
    <tr>
        <th>Reservation ID</th>
        <th>Date</th>
        <th>Time</th>
        <th>Table Number</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['reservation_date']; ?></td>
        <td><?php echo $row['reservation_time']; ?></td>
        <td><?php echo $row['table_number']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>
