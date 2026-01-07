<?php
// Database connection
require_once 'includes/db.php';

// Check connection
// Check if a specific tour type is requested
$type_id = isset($_GET['type']) ? (int)$_GET['type'] : null;

// Prepare the SQL query based on whether a type filter is applied
if ($type_id) {
  // Query for specific tour type
  $sql = "SELECT t.*, tt.type_name 
            FROM tours t
            JOIN tour_type_relations ttr ON t.tour_id = ttr.tour_id
            JOIN tour_types tt ON ttr.type_id = tt.type_id
            WHERE ttr.type_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $type_id);
  $stmt->execute();
  $result = $stmt->get_result();
} else {
  // Query for all tours without currency
  $sql = "SELECT DISTINCT t.*, tt.type_name 
            FROM tours t
            LEFT JOIN tour_type_relations ttr ON t.tour_id = ttr.tour_id
            LEFT JOIN tour_types tt ON ttr.type_id = tt.type_id";
  $result = $conn->query($sql);
}

// Get the current filter for displaying in the header
$filter_name = '';
if ($type_id) {
  $type_query = "SELECT type_name FROM tour_types WHERE type_id = ?";
  $stmt = $conn->prepare($type_query);
  $stmt->bind_param("i", $type_id);
  $stmt->execute();
  $type_result = $stmt->get_result();
  if ($row = $type_result->fetch_assoc()) {
    $filter_name = $row['type_name'];
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tours and Deals</title>
  <link rel="stylesheet" href="view-all-deals.css">
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
        <li><a href="./view-all-deals.php" class="active">Deals</a></li>
        <li><a href="../About us/aboutus.html">About</a></li>
        <li><a href="https://wa.me/923335511100">Contact Us</a></li>
      </ul>
    </nav>

    <div class="menu-container" id="menu-container">
      <ul>
        <li><a href="./index.php">Home</a></li>
        <li><a href="./view-all-deals.php" class="active">Deals</a></li>
        <li><a href="../About us/aboutus.html">About</a></li>
        <li><a href="https://wa.me/923335511100">Contact Us</a></li>
      </ul>
    </div>
  </header>
  <script src="view-all-deals.js"></script>

  <!-- Add a filter indicator -->
  <div class="filter-header">
    <h1><?php echo $filter_name ? "Showing: " . htmlspecialchars($filter_name) : "All Tours"; ?></h1>
    <?php if ($filter_name): ?>
      <a href="view-all-deals.php" class="clear-filter">View All Tours</a>
    <?php endif; ?>
  </div>

  <!-- Display the tours -->
  <?php if ($result->num_rows > 0): ?>
    <?php while ($tour = $result->fetch_assoc()): ?>
      <div class="card-container">
        <div class="card-image">
          <?php if (!empty($tour['main_image'])): ?>
            <img src="<?php echo './' . htmlspecialchars($tour['main_image']); ?>"
              alt="<?php echo htmlspecialchars($tour['tour_name']); ?>" />
          <?php else: ?>
            <img src="../Photos/default-tour-image.jpg" alt="Default tour image" />
          <?php endif; ?>
        </div>
        <div class="card-content">
          <h3><?php echo htmlspecialchars($tour['tour_name']); ?></h3>
          <p>Price: <?php echo htmlspecialchars($tour['price']) . ' ' . htmlspecialchars($tour['currency_code']); ?></p>
          <p>Duration: <?php echo htmlspecialchars($tour['duration']); ?></p>
          <a href="./tour-details.php?id=<?php echo $tour['tour_id']; ?>">
            <button class="learn-more">Learn More</button>
          </a>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <div class="no-results">
      <p>No tours found for this category.</p>
      <a href="view-all-deals.php" class="view-all-link">View All Tours</a>
    </div>
  <?php endif; ?>
  <div class="floating-button" onclick="location.href='https://wa.me/923335511100'">
    <img src="../Photos/booknow-icon.png" alt="Book Now" />
    <span>Book Now</span>
  </div>

</body>

</html>