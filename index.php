<?php
// Database connection
require_once 'includes/db.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch tours and their main images, price, and duration
$sql = "SELECT tour_id, tour_name, main_image, price, duration, currency_code FROM tours LIMIT 5";
$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Arwa Travel</title>
    <link rel="stylesheet" href="home.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <!-- <img src="logo.png" /> -->
                <p>Arwa Travel</p>
            </div>
            <button class="menu-button" onclick="toggleMenu()">
                <img src="../Photos/menu (1).png" />
            </button>
        </nav>

        <nav class="floating-nav">
            <ul>
                <li><a href="./index.php">Home</a></li>
                <li><a href="./view-all-deals.php">Deals</a></li>
                <li><a href="../About us/aboutus.html">About</a></li>
                <li><a href="https://wa.me/923335511100">Contact Us</a></li>
            </ul>
        </nav>

        <div class="menu-container" id="menu-container">
            <ul>
                <li><a href="./index.php" class="active">Home</a></li>
                <li><a href="./view-all-deals.php">Deals</a></li>
                <li><a href="../About us/aboutus.html">About</a></li>
                <li><a href="https://wa.me/923335511100">Contact Us</a></li>
            </ul>
        </div>
    </header>
    <section class="hero">
        <div class="hero-text">
            <h1>Let's travel and explore</h1>
            <p>Discover amazing places at exclusive deals</p>
            <div class="search-bar">
                <input type="text" placeholder="Keyword" />
                <button>
                    <b class="fas fa-search">Search</b>
                </button>
            </div>
        </div>
    </section>
    <section class="tour-types">
        <h2>Choose Tour Types</h2>
        <p>Choose the tour of your life.</p>
        <div class="tour-grid">
            <a href="./view-all-deals.php?type=1">
                <div class="tour-item">
                    <img src="../Photos/airplane.png" alt="International Tour Icon" />
                    <h3>International Tours</h3>
                </div>
            </a>
            <a href="./view-all-deals.php?type=2">
                <div class="tour-item">
                    <img src="../Photos/skiing.png" alt="Adventure Tour Icon" />
                    <h3>Adventure Tours</h3>
                </div>
            </a>
            <a href="./view-all-deals.php?type=3">
                <div class="tour-item">
                    <img src="../Photos/mountain.png" alt="City Tour Icon" />
                    <h3>Local Tours</h3>
                </div>
            </a>
            <a href="./view-all-deals.php?type=4">
                <div class="tour-item">
                    <img src="../Photos/beach-chair (1).png" alt="Museum Tour Icon" />
                    <h3>Leisure Tours</h3>
                </div>
            </a>
            <a href="./view-all-deals.php?type=5">
                <div class="tour-item">
                    <img src="../Photos/honeymoon.png" alt="Beach Tour Icon" />
                    <h3>Honeymoon Packages</h3>
                </div>
            </a>
            <a href="./view-all-deals.php?type=6">
                <div class="tour-item">
                    <img src="../Photos/hiking.png" alt="Trekking Tour Icon" />
                    <h3>Trekking Tours</h3>
                </div>
            </a>
        </div>
    </section>

    <!-- Top Deals Carousel -->
    <section class="Top-deals-section">
        <h2 class="section-title">Top Deals</h2>
        <div class="carousel-container">
            <div class="carousel" data-card-count="<?php echo $result->num_rows; ?>">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="card">';
                        echo '<div class="card-image">';

                        // Debug the image path
                        error_log("Image path: " . $row['main_image']);

                        // Use the correct path to the uploads directory
                        if (!empty($row['main_image'])) {
                            // Remove any leading slashes and ensure correct path
                            $imagePath = ltrim($row['main_image'], '/');
                            echo '<img src="./' . htmlspecialchars($imagePath) . '" alt="' . htmlspecialchars($row["tour_name"]) . '" />';
                        } else {
                            echo '<p>Image not available</p>';
                        }

                        echo '</div>';
                        echo '<div class="card-content">';
                        echo '<h3>' . htmlspecialchars($row["tour_name"]) . '</h3>';
                        echo '<p>Price: ' . htmlspecialchars($row["price"]) . ' ' . htmlspecialchars($row["currency_code"]) . '</p>'; // Display price with currency code
                        echo '<p>Duration: ' . htmlspecialchars($row["duration"]) . '</p>'; // Display duration
                        echo '<a href="./tour-details.php?id=' . $row["tour_id"] . '">';
                        echo '<button class="learn-more">Learn More</button>';
                        echo '</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No top deals available.</p>';
                }
                ?>
            </div>
            <div class="carousel-dots">
                <!-- Dots will be generated by JavaScript -->
            </div>
        </div>
        <a href="./view-all-deals.php" class="view-all-deals">View All Deals</a>
    </section>
    <script src="home.js"></script>

    <footer>
        <div class="footer-content">
            <div class="footer-contact">
                <h3>Contact us:</h3>
                <p>
                    <a href="tel:+923335511100">+92 333 55 111 00</a> |
                    <a href="mailto:arwatravels@gmail.com">arwatravels@gmail.com</a>
                </p>
            </div>
            <h3>Book Your Flight in 3 Simple Steps</h3>
            <ol class="instructions-list">
                <li>
                    <strong>Select The Tour:</strong>
                    Check our available packages and choose the hotels that best fits your travel plans.
                </li>
                <li>
                    <strong>Contact Us on WhatsApp:</strong>
                    For detailed information and to book, reach out to us via WhatsApp. Our team is here to help!
                </li>
                <li>
                    <strong>Enjoy Your Journey:</strong>
                    Once your booking is confirmed, relax and look forward to your adventure!
                </li>
            </ol>
            <h4>&copy; 2023 Arwa Travel. All rights reserved.</h4>
        </div>
    </footer>

    <script src="home.js"></script>

    <!-- Add this HTML for the floating button -->
    <div class="floating-button" onclick="location.href='https://wa.me/923335511100'">
        <img src="../Photos/booknow-icon.png" alt="Book Now" />
        <span>Book Now</span>
    </div>
</body>

</html>