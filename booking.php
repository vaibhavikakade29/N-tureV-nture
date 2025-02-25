<?php
include 'database.php'; // Include your database connection file

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $adventure = mysqli_real_escape_string($conn, $_POST['adventure']);
    $package = mysqli_real_escape_string($conn, $_POST['package']);
    $total_people = mysqli_real_escape_string($conn, $_POST['total_people']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $price = str_replace("₹", "", mysqli_real_escape_string($conn, $_POST['price'])); // Remove currency symbol

    // Check if the email and username exist in the users table
    $checkUserQuery = "SELECT * FROM users WHERE TRIM(email) = '$email' AND TRIM(username) = '$username'";
    $result = $conn->query($checkUserQuery);

    if (!$result) {
        die("Error in query: " . $conn->error); // Check if query fails
    }

    if ($result->num_rows > 0) {
        // Insert into database if user exists
        $sql = "INSERT INTO bookings (username, email, phone, adventure, package, total_people, date, total_price) 
                VALUES ('$username', '$email', '$phone', '$adventure', '$package', '$total_people', '$date', '$price')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    alert('Booking successful!');
                    window.location.href='payment.html';
                  </script>";
        } else {
            die("Error inserting booking: " . $conn->error);
        }
    } else {
        echo "<script>
                alert('Error: You have not yet registered. Please register now.');
                window.location.href='login.html';
              </script>";
        exit;
    }
}

$conn->close();
?>
