<?php
session_start(); // Start a session to store user data across pages

include 'database.php'; // Include database connection file

// Check if the form is submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Securely get user input and prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Encrypt the password using bcrypt for security
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if the email already exists in the database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // If the email already exists, show an alert and redirect to the login page
        echo "<script>alert('Email already registered!'); window.location.href='login.html';</script>";
    } else {
        // If email is not found, insert the new user into the database
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        
        if (mysqli_query($conn, $sql)) {
            // Start a session for the user and store email and username
            $_SESSION['email'] = $email; 
            $_SESSION['username'] = $username;
            
            // Show a success message and redirect to the dashboard
            echo "<script>alert('Registration successful!'); window.location.href='login.html';</script>";
        } else {
            // If there is an error inserting data, display the error message
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>
