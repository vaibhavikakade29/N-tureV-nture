<?php
session_start(); // Start a session to manage user login state

include 'database.php'; // Include database connection file

// Check if the form is submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Securely get user input and prevent SQL injection
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // Get the entered password

    // Retrieve the user from the database based on the entered email
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    
    // Check if any record is found
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result); // Fetch user data

        // Verify the entered password with the hashed password stored in the database
        if (password_verify($password, $row['password'])) {
            // If the password is correct, set session variables for the user
            $_SESSION['email'] = $row['email'];

            // Redirect user to the dashboard after successful login
            echo "<script>alert('Login successful!'); window.location.href='index.html';</script>";
        } else {
            // If the password is incorrect, show an error message and redirect back to login page
            echo "<script>alert('Invalid email or password!'); window.location.href='login.html';</script>";
        }
    } else {
        // If no user is found with the entered email, show an error message
        echo "<script>alert('Invalid email or password!'); window.location.href='login.html';</script>";
    }
}
?>
