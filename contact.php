<?php
include 'database.php'; // Include your database connection file

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Check if the email and username exist in the users table
    $checkUserQuery = "SELECT * FROM users WHERE TRIM(email) = '$email' AND TRIM(username) = '$username'";
    $result = $conn->query($checkUserQuery);

    if ($result->num_rows > 0) {
        // Insert into database if user exists
        $sql = "INSERT INTO contact (username, email, subject, message) VALUES ('$username', '$email', '$subject', '$message')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    alert('Message sent successfully!');
                    window.location.href='contact.html'; // Redirect to contact page
                  </script>";
        } else {
            echo "<script>
                    alert('Error: " . $conn->error . "');
                  </script>";
        }
    } else {
        // Display error message and redirect to registration page
        echo "<script>
                alert('Error: You have not yet registered. Please register now.');
                window.location.href='login.html';
              </script>";
        exit;
    }
}

$conn->close();
?>
