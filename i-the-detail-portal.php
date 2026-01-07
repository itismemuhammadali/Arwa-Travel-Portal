<?php
session_start(); // Start the session

// Database connection
$servername = "server64.web-hosting.com";
$username = "arwasoyk";
$password = "http://S0hail-t@riq/";
$dbname = "arwasoyk_ARWA_TRAVELS";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch currencies from the database
$sql_currencies = "SELECT currency_code, currency_name FROM currencies";
$result_currencies = $conn->query($sql_currencies);
$currencies = [];
if ($result_currencies) {
    while ($row = $result_currencies->fetch_assoc()) {
        $currencies[$row['currency_code']] = $row['currency_name'];
    }
} else {
    echo "<p>Error fetching currencies: " . $conn->error . "</p>";
}
// Fetch currencies from the database
$sql_currencies = "SELECT currency_code, currency_name FROM currencies";
$result_currencies = $conn->query($sql_currencies);
$currencies = [];
if ($result_currencies) {
    while ($row = $result_currencies->fetch_assoc()) {
        $currencies[$row['currency_code']] = $row['currency_name'];
    }
} else {
    echo "<p>Error fetching currencies: " . $conn->error . "</p>";
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form fields are not empty
    if (
        !empty($_POST['hero-description']) &&
        !empty($_POST['price']) &&
        !empty($_POST['duration']) &&
        !empty($_POST['accommodation']) &&
        !empty($_POST['meals']) &&
        !empty($_POST['documents']) &&
        !empty($_FILES['image1']['name']) &&
        !empty($_FILES['image2']['name']) &&
        !empty($_FILES['image3']['name']) &&
        !empty($_POST['tour_types']) &&
        !empty($_POST['currency_code'])
    ) {

        // Set a session variable to indicate that the form has been submitted
        $_SESSION['form_submitted'] = true;

        $tour_name = $_POST['hero-description'];
        $price = $_POST['price']; // Get price from form
        $currency_code = $_POST['currency_code']; // Get currency from form
        $accommodation = $_POST['accommodation'];
        $documents = $_POST['documents'];
        $tour_types = $_POST['tour_types'];
        $duration = $_POST['duration']; // Get duration from form
        $meals = $_POST['meals']; // Get meals provided from form

        // Handle image uploads
        $imagePaths = [];
        $uploadDir = 'uploads/';

        for ($i = 1; $i <= 3; $i++) {
            $imageFile = $_FILES["image$i"];
            $targetFile = $uploadDir . basename($imageFile["name"]);
            if (move_uploaded_file($imageFile["tmp_name"], $targetFile)) {
                $imagePaths[] = $targetFile;
            } else {
                echo "<p>Error uploading image $i.</p>";
                exit;
            }
        }

        // Start transaction
        $conn->begin_transaction();

        try {
            // Insert tour details
            $sql = "INSERT INTO tours (tour_name, price, currency_code, accommodation, required_documents, duration, meals_provided, main_image, image2, image3) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssss", $tour_name, $price, $currency_code, $accommodation, $documents, $duration, $meals, $imagePaths[0], $imagePaths[1], $imagePaths[2]);
            $stmt->execute();

            $tour_id = $conn->insert_id;

            // Insert tour types relations
            $sql_types = "INSERT INTO tour_type_relations (tour_id, type_id) VALUES (?, ?)";
            $stmt_types = $conn->prepare($sql_types);

            foreach ($tour_types as $type_id) {
                $stmt_types->bind_param("ii", $tour_id, $type_id);
                $stmt_types->execute();
            }

            // Commit transaction
            $conn->commit();
            echo "<p>New tour created successfully with images and tour types.</p>";
        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollback();
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p>Error: All fields are required, including at least one tour type and currency.</p>";
    }
}

// Check if the page is being reloaded
if (isset($_SESSION['form_submitted'])) {
    unset($_SESSION['form_submitted']); // Clear the session variable
    // Redirect to prevent form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal - Tour Details</title>
    <link rel="stylesheet" href="i-the-detail-portal.css"> <!-- Link to CSS file -->
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="logo.png" />
                <p>Arwa Travel Admin</p>
            </div>
        </nav>
    </header>

    <main>
        <div class="admin-container">
            <h1>Admin Portal - Input Tour Details</h1>
            <form action="" method="POST" enctype="multipart/form-data"> <!-- Action points to itself -->
                <section class="form-section">
                    <h2>Upload Tour Images</h2>
                    <label for="image1">Main Image:</label>
                    <input type="file" id="image1" name="image1" accept="image/*" required>
                    <label for="image2">Additional Image 1:</label>
                    <input type="file" id="image2" name="image2" accept="image/*" required>
                    <label for="image3">Additional Image 2:</label>
                    <input type="file" id="image3" name="image3" accept="image/*" required>
                </section>

                <section class="form-section">
                    <h2>Tour Name</h2>
                    <textarea id="hero-description" name="hero-description" rows="4" required></textarea>
                    <label for="price">Price:</label>
                    <input type="text" id="price" name="price" required>
                    <label for="currency_code">Currency:</label>
                    <select id="currency_code" name="currency_code" required>
                        <?php foreach ($currencies as $code => $name): ?>
                            <option value="<?php echo $code; ?>"><?php echo $name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="duration">Duration:</label>
                    <input type="text" id="duration" name="duration" required>
                </section>

                <section class="form-section">
                    <h2>Place to Stay</h2>
                    <label for="accommodation">Accommodation Details:</label>
                    <textarea id="accommodation" name="accommodation" rows="4" required></textarea>
                    <label for="meals">Meals Provided:</label>
                    <textarea id="meals" name="meals" rows="4" required></textarea>
                </section>

                <section class="form-section">
                    <h2>Required Documents</h2>
                    <label for="documents">List of Required Documents:</label>
                    <textarea id="documents" name="documents" rows="4" required></textarea>
                </section>

                <section class="form-section">
                    <h2>Tour Types</h2>
                    <div class="tour-types-grid">
                        <div class="tour-type-checkbox">
                            <input type="checkbox" id="international" name="tour_types[]" value="1">
                            <label for="international">
                                <img src="../Photos/airplane.png" alt="International Tours">
                                <span>International Tours</span>
                            </label>
                        </div>

                        <div class="tour-type-checkbox">
                            <input type="checkbox" id="adventure" name="tour_types[]" value="2">
                            <label for="adventure">
                                <img src="../Photos/skiing.png" alt="Adventure Tours">
                                <span>Adventure Tours</span>
                            </label>
                        </div>

                        <div class="tour-type-checkbox">
                            <input type="checkbox" id="local" name="tour_types[]" value="3">
                            <label for="local">
                                <img src="../Photos/mountain.png" alt="Local Tours">
                                <span>Local Tours</span>
                            </label>
                        </div>

                        <div class="tour-type-checkbox">
                            <input type="checkbox" id="leisure" name="tour_types[]" value="4">
                            <label for="leisure">
                                <img src="../Photos/beach-chair (1).png" alt="Leisure Tours">
                                <span>Leisure Tours</span>
                            </label>
                        </div>

                        <div class="tour-type-checkbox">
                            <input type="checkbox" id="honeymoon" name="tour_types[]" value="5">
                            <label for="honeymoon">
                                <img src="../Photos/honeymoon.png" alt="Honeymoon Packages">
                                <span>Honeymoon Packages</span>
                            </label>
                        </div>

                        <div class="tour-type-checkbox">
                            <input type="checkbox" id="trekking" name="tour_types[]" value="6">
                            <label for="trekking">
                                <img src="../Photos/hiking.png" alt="Trekking Tours">
                                <span>Trekking Tours</span>
                            </label>
                        </div>
                    </div>
                </section>

                <button type="submit" class="submit-button">Submit Tour Details</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Arwa Travels Admin Portal. All rights reserved.</p>
    </footer>
</body>

</html>