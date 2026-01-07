<?php
// Database connection
require_once 'includes/db.php';

// Check connection
$tour_id = $_GET['id']; // Get tour ID from URL
$sql = "SELECT *, currency_code FROM tours WHERE tour_id = $tour_id";
$result = $conn->query($sql);
$tour = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($tour['tour_name']); ?> - Tour Details</title>
    <link rel="stylesheet" href="tour-details.css">
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
                <li><a href="../Home/home.php">Home</a></li>
                <li><a href="../View All Deals/view-all-deals.php">Deals</a></li>
                <li><a href="../About us/aboutus.html">About</a></li>
                <li><a href="https://wa.me/923335511100">Contact Us</a></li>
            </ul>
        </nav>

        <div class="menu-container" id="menu-container">
            <ul>
                <li><a href="../Home/home.php">Home</a></li>
                <li><a href="../View All Deals/view-all-deals.php">Deals</a></li>
                <li><a href="../About us/aboutus.html">About</a></li>
                <li><a href="https://wa.me/923335511100">Contact Us</a></li>
            </ul>
        </div>
    </header>
    <script src="tour-details.js"></script>

    <main>
        <div class="hero">
            <h1><?php echo htmlspecialchars($tour['tour_name']); ?></h1>
            <p><?php echo htmlspecialchars(isset($tour['duration']) ?
                    $tour['duration'] : 'Duration not available.'); ?></p> <!-- Check if duration exists -->
        </div>

        <div class="container">
            <div class="gallery">
                <img src="./<?php echo htmlspecialchars($tour['main_image']); ?>" alt="<?php echo htmlspecialchars($tour['tour_name']); ?> - Image 1">
                <img src="./<?php echo htmlspecialchars($tour['image2']); ?>" alt="<?php echo htmlspecialchars($tour['tour_name']); ?> - Image 2">
                <img src="./<?php echo htmlspecialchars($tour['image3']); ?>" alt="<?php echo htmlspecialchars($tour['tour_name']); ?> - Image 3">
            </div>

            <!-- <section id="departure-return" class="section">
                <h2>Departure & Return Information</h2>
                <p><strong>Departure:</strong> <?php echo htmlspecialchars($tour['departure']); ?></p>
                <p><strong>Return:</strong> <?php echo htmlspecialchars($tour['return_time']); ?></p>
            </section> -->

            <section id="accommodation" class="section">
                <h2>Place to Stay</h2>
                <p><?php echo htmlspecialchars($tour['accommodation']); ?></p>
            </section>

            <section id="price" class="section">
                <h2>Cost</h2>
                <p><?php echo htmlspecialchars($tour['price']) . ' ' . htmlspecialchars($tour['currency_code']); ?></p>
            </section>

            <section id="meals" class="section">
                <h2>Meals Provided</h2>
                <p><?php echo htmlspecialchars($tour['meals_provided']); ?></p>
            </section>

            <section id="documents" class="section">
                <h2>Required Documents</h2>
                <ul>
                    <?php
                    // Check if required_documents is not empty
                    if (!empty($tour['required_documents'])) {
                        // Split the documents by comma and display each one
                        $documents = explode(',', $tour['required_documents']);
                        foreach ($documents as $document) {
                            echo '<li>' . htmlspecialchars(trim($document)) . '</li>'; // Trim whitespace and escape HTML
                        }
                    } else {
                        echo '<li>No documents required.</li>'; // Fallback message if no documents are found
                    }
                    ?>
                </ul>
            </section>

            <section id="things-to-bring" class="section">
                <h2>Things to Bring</h2>
                <ul>
                    <li>Comfortable clothes and swimwear</li>
                    <li>Beach towel and flip-flops</li>
                    <li>Personal toiletries</li>
                    <li>Camera for capturing memories</li>
                    <li>Snacks and a reusable water bottle</li>
                </ul>
            </section>

            <section id="precautions" class="section">
                <h2>Precautions</h2>
                <ul>
                    <li>Wear sunscreen and stay hydrated.</li>
                    <li>Follow local guidelines for beach safety.</li>
                    <li>Bring any necessary medications.</li>
                    <li>Wear appropriate footwear for outdoor activities.</li>
                </ul>
            </section>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Arwa Travels. All rights reserved.</p>
    </footer>
    <div class="floating-button" onclick="location.href='https://wa.me/923335511100'">
        <img src="../Photos/booknow-icon.png" alt="Book Now" />
        <span>Book Now</span>
    </div>
</body>

</html>