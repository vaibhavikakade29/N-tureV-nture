<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $review = trim($_POST['review']);
    $rating = intval($_POST['rating']);

    // Basic validation
    if (empty($name) || empty($review) || $rating < 1 || $rating > 5) {
        echo "<script>alert('Please fill all fields correctly.'); window.history.back();</script>";
        exit;
    }

    // Prevent SQL injection
    $name = mysqli_real_escape_string($conn, $name);
    $review = mysqli_real_escape_string($conn, $review);

    // Insert data into the reviews table
    $sql = "INSERT INTO reviews (name, review, rating) VALUES ('$name', '$review', '$rating')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Review submitted successfully!'); window.location.href='index.html';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
