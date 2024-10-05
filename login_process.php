<?php
require 'db_config.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement with correct column names
    $stmt = mysqli_prepare($conn, "SELECT password FROM admin_users WHERE username = ?");
    if ($stmt === false) {
        die("Failed to prepare the SQL statement: " . mysqli_error($conn));
    }

    // Bind parameters and execute
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $stored_password);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Check password
    if ($stored_password && $password === $stored_password) {
        session_start();
        $_SESSION['username'] = $username; // Store username or other relevant data in the session

        // Display success alert and redirect to the admin panel
        echo "<script>
                alert('Login successful!');
                window.location.href = 'admin_panel.php';
              </script>";
        exit();
    } else {
        // Redirect back to the login page with an error parameter
        header("Location: login.php?error=1");
        exit();
    }
} else {
    echo "Invalid request method.";
}

// Close the database connection
mysqli_close($conn);
?>
