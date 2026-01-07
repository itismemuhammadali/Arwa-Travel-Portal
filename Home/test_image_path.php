<?php
$imagePath = '../I The Detail Portal/uploads/taj.jpeg'; // Replace with a known image filename

// Check if the file exists
if (file_exists($imagePath)) {
    echo "Image path: $imagePath <br>";
    echo '<img src="' . $imagePath . '" alt="Test Image" />';
} else {
    echo "Image not found at path: $imagePath";
}
