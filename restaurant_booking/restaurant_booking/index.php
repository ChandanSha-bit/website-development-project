<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Table Booking</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="logo">SpiceHub</div>
        <?php if (isset($_SESSION['username'])): ?>
            <p class="greeting">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
            <button id="myReservationsBtn">My Reservations</button>
            <a href="add_reservation.php"><button class="book-table">Book Your Table</button></a>
            <a href="logout.php" class="logout-link">Logout</a>
        <?php else: ?>
            <button id="loginBtn">Login</button>
            <a href="register.php"><button class="sign-up">Sign Up</button></a>
        <?php endif; ?>
    </header>

    <div id="reservationsModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
        <div style="background-color: white; padding: 20px; border-radius: 8px; max-width: 600px; margin: 100px auto;">
            <h3>All Reservations</h3>
            <div id="reservationsContainer"></div>
            <button onclick="closeModal()">Close</button>
        </div>
    </div>

    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Login</h2>
            <form action="login.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                
                <input type="submit" name="login" value="Login" class="submit-btn">
            </form>
            <p>Don't have an account? <a href="register.php">Sign Up</a></p>
        </div>
    </div>


    <div class="banner-collection">
        <div class="myBanner">
            <img src="assets/banner-1.png" alt="Banner 1" style="width: 100%">
        </div>
        <div class="myBanner">
            <img src="assets/banner-2.png" alt="Banner 2" style="width: 100%">
        </div>
        <div class="myBanner">
            <img src="assets/banner-3.png" alt="Banner 3" style="width: 100%">
        </div>
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>

    <div class="timing">
        <p class="title">Hi Foodie, Dine Anytime!</p>
        <div class="blocks">
            <div class="block">
                <img src="assets/lunch.png" alt="Lunch">
                <p>Lunch</p>
            </div>
            <div class="block">
                <img src="assets/dinner.avif" alt="Dinner">
                <p>Dinner</p>
            </div>
            <div class="block">
                <img src="assets/fastfood.webp" alt="Fast Food">
                <p>Fast Food</p>
            </div>
            <div class="block">
                <img src="assets/location-icon-clipart.png" alt="Near Me">
                <p>Near Me</p>
            </div>
            <div class="block">
                <img src="assets/breakfast.png" alt="Breakfast">
                <p>Breakfast</p>
            </div>
        </div>
    </div>

    <section id="featured-restaurants">
        <p class="title">Top-Rated Restaurants Near You</p>
        <div class="restaurant-cards">
            <div class="restaurant-card">
                <img src="assets/restaurant-1.jpeg" alt="Restaurant 1">
                <div class="content">
                    <p class="hotel-name">Spice Symphony</p>
                    <p class="hotel-address">Camp Area, Pune</p>
                    <p class="rating">4.2</p>
                </div>
            </div>
            <div class="restaurant-card">
                <img src="assets/restaurant-2.jpeg" alt="Restaurant 2">
                <div class="content">
                    <p class="hotel-name">Urban Eats</p>
                    <p class="hotel-address">Pune Bund Garden, Pune</p>
                    <p class="rating">5.0</p>
                </div>
            </div>
            <div class="restaurant-card">
                <img src="assets/restaurant-3.jpg" alt="Restaurant 3">
                <div class="content">
                    <p class="hotel-name">Sizzle & Grill</p>
                    <p class="hotel-address">Koregaon Park, Pune</p>
                    <p class="rating">4.5</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bottom-cover">
        <div class="cover-content">
            <p>Discover the best restaurants around you. Reserve your table now!</p>
        </div>
    </section>                  
</body>
</html>
