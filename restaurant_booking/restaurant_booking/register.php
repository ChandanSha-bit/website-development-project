<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="register.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h1>User Registration</h1>

        <!-- Message Box -->
        <div id="message-box" style="display:none;"></div>

        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <input type="submit" name="submit" value="Register" class="submit-btn">
        </form>
        <p class="login-link">Already have an account? <a href="login.php">Login here</a></p>
    </div>

    <?php
    session_start();
    include 'includes/db.php';
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $message = ""; // Initialize message variable

    if (isset($_POST['submit'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        
        // Check if username already exists
        $query = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $message = "Username already taken. Please choose another.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new user into the database
            $insert_query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
            if (mysqli_query($conn, $insert_query)) {
                $message = "Registration successful! You can now <a href='index.php'>login</a>.";
            } else {
                $message = "Error: " . mysqli_error($conn);
            }
        }
    }

    // If there's a message, display it in JavaScript
    if ($message) {
        // Use htmlspecialchars to prevent breaking the HTML/JavaScript context
        $escaped_message = str_replace("'", "\\'", $message);
        echo "<script>
                document.getElementById('message-box').innerHTML = '$escaped_message';
                document.getElementById('message-box').style.display = 'block';
              </script>";
    }

    $conn->close();
    ?>
</body>
</html>
