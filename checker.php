<?php
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'registration';

// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['password'])) {
    // Could not get the data that should have been sent.
    exit('Please complete the login form!');
}

// Make sure the submitted login values are not empty.
if (empty($_POST['username']) || empty($_POST['password'])) {
    // One or more values are empty.
    exit('Please complete the login form');
}

// Use prepared statement to retrieve the hashed password from the database based on the provided username.
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    // Bind parameters (s = string), in this case, the username.
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    // Check if the account exists in the database.
    if ($stmt->num_rows > 0) {
        // Account with the provided username exists.
        // Now, retrieve the hashed password.
        $stmt->bind_result($id, $hashedPassword);
        $stmt->fetch();

        // Verify the entered password against the hashed password.
        if (password_verify($_POST['password'], $hashedPassword)) {
            // Passwords match, login successful.
            session_start();
            $_SESSION['name'] = $_POST['username'];
            header('Location: home.html');
            exit();
        } else {
            // Passwords do not match, login failed.
            echo '<script>
            alert("Incorrect password. Please try again.");
            window.location.href = "index.html"; 
            </script>';
            exit();
        }
    } else {
        // No account with the provided username exists.
        echo '<script>
            alert("Username not found. Please check your username and try again.");
            window.location.href = "index.html"; 
            </script>';
        exit();
    }

    $stmt->close();
} else {
    // Something is wrong with the SQL statement.
    echo '<script>
            alert("Could not prepare statement!");
            window.location.href = "index.html";
          </script>';
    exit();
}

$con->close();
?>
<!-- Rest of your HTML code for the login form -->
