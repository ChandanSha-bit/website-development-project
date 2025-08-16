<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Table</title>
    <link rel="stylesheet" href="add_reservations.css">
</head>
<body>
    <div class="container">
        <h1><?php echo isset($_GET['id']) ? 'Update Your Reservation' : 'Add Your Reservation'; ?></h1>
        <div class="message success" id="success-message" style="display:none;"></div>
        <div class="message error" id="error-message" style="display:none;"></div> <!-- Error message div -->

        <?php
        include 'includes/db.php';
        session_start(); // Start the session to access user_id
        $user_id = $_SESSION['user_id']; // Retrieve user_id from session

        // Initialize reservation fields
        $reservation_id = '';
        $name = '';
        $email = '';
        $phone = '';
        $restaurant = '';
        $reservation_date = '';
        $reservation_time = '';
        $guests = '';

        // Fetch reservation details if updating
        if (isset($_GET['id'])) {
            $reservation_id = $_GET['id'];
            $sql = "SELECT * FROM reservations WHERE id = $reservation_id AND user_id = '$user_id'"; // Check ownership
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $name = $row['name'];
                $email = $row['email'];
                $phone = $row['phone'];
                $restaurant = $row['restaurant'];
                $reservation_date = $row['reservation_date'];
                $reservation_time = $row['reservation_time'];
                $guests = $row['guests'];
            } else {
                echo "<script>document.getElementById('error-message').innerText = 'No reservation found or access denied.'; document.getElementById('error-message').style.display = 'block';</script>";
            }
        }
        ?>

        <form action="add_reservation.php" method="POST">
            <input type="hidden" name="reservation_id" value="<?php echo $reservation_id; ?>">
            
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required><br>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" required><br>

            <label for="restaurant">Restaurant:</label>
            <select id="restaurant" name="restaurant" required>
                <option value="Spice Symphony" <?php echo $restaurant == 'Spice Symphony' ? 'selected' : ''; ?>>Spice Symphony</option>
                <option value="Urban Eats" <?php echo $restaurant == 'Urban Eats' ? 'selected' : ''; ?>>Urban Eats</option>
                <option value="Sizzle & Grill" <?php echo $restaurant == 'Sizzle & Grill' ? 'selected' : ''; ?>>Sizzle & Grill</option>
            </select><br>

            <label for="date">Reservation Date:</label>
            <input type="date" id="date" name="date" value="<?php echo $reservation_date; ?>" required><br>

            <label for="time">Reservation Time:</label>
            <input type="time" id="time" name="time" value="<?php echo $reservation_time; ?>" required><br>

            <label for="guests">Number of Guests:</label>
            <input type="number" id="guests" name="guests" value="<?php echo $guests; ?>" required><br>

            <div class="buttons">
                <button class="back-button" onclick="window.location.href='index.php'">Back</button>
                <input type="submit" name="submit" value="<?php echo isset($_GET['id']) ? 'Update Reservation' : 'Book Reservation'; ?>">
            </div>
        </form>
    </div>

    <?php
    include "includes/db.php";
    session_start(); // Ensure session is active to access user_id
    $user_id = $_SESSION['user_id']; // Retrieve user_id from session

    if (isset($_POST['submit'])) {
        $reservation_id = $_POST['reservation_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $restaurant = $_POST['restaurant'];
        $reservation_date = $_POST['date'];
        $reservation_time = $_POST['time'];
        $guests = $_POST['guests'];

        // Check for valid user_id
        if (!$user_id) {
            echo "<script>document.getElementById('error-message').innerText = 'User not authenticated.'; document.getElementById('error-message').style.display = 'block';</script>";
        } else {
            if ($reservation_id) {
                // Update reservation
                $sql = "UPDATE reservations SET 
                        name='$name', 
                        email='$email', 
                        phone='$phone', 
                        restaurant='$restaurant', 
                        reservation_date='$reservation_date', 
                        reservation_time='$reservation_time', 
                        guests='$guests' 
                        WHERE id=$reservation_id AND user_id='$user_id'"; // Ensure only the owner can update

                if ($conn->query($sql) === TRUE) {
                    echo "<script>document.getElementById('success-message').innerText = 'Reservation successfully updated!'; document.getElementById('success-message').style.display = 'block';</script>";
                } else {
                    echo "<script>document.getElementById('error-message').innerText = 'Error updating reservation: " . $conn->error . "'; document.getElementById('error-message').style.display = 'block';</script>";
                }
            } else {
                // Insert new reservation
                $sql = "INSERT INTO reservations (user_id, name, email, phone, restaurant, reservation_date, reservation_time, guests)
                        VALUES ('$user_id', '$name', '$email', '$phone', '$restaurant', '$reservation_date', '$reservation_time', '$guests')";

                if ($conn->query($sql) === TRUE) {
                    echo "<script>document.getElementById('success-message').innerText = 'Reservation successfully added!'; document.getElementById('success-message').style.display = 'block';</script>";
                } else {
                    echo "<script>document.getElementById('error-message').innerText = 'Error adding reservation: " . $conn->error . "'; document.getElementById('error-message').style.display = 'block';</script>";
                }
            }
        }
    }

    $conn->close();
    ?>
    <script src="script.js"></script>
</body>
</html>
