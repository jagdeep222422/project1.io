

<?php
session_start();

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Database Connect here
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'registration';

    // Try and connect using the info above.
    $con = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

    if ($con->connect_error) {
        die("Failed to Connect: " . $con->connect_error);
    } else {
        $stmt = $con->prepare("SELECT * FROM accounts WHERE username=? AND email=?");
        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();
        $stmt_result = $stmt->get_result();

        if ($stmt_result->num_rows > 0) {
            $data = $stmt_result->fetch_assoc();
            if ($data['password'] == $password) {
                // Authentication successful
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                header('Location: profile.html');
                exit;
            } else {
                echo "<h2>Invalid Password</h2>";
            }
        } else {
            echo "<h2>Invalid Username or Email</h2>";
        }
    }
} else {
    echo "<h2>Missing Username, Password, or Email</h2>";
}
?>


////////////////////////////////////////////////////////////
<?php
    session_start();
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email=$_POST['email'];
    // Database Connect here
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'registration';
    // Try and connect using the info above.
    $con = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if ($con->connect_error) {
        die("Failed to Connect: " . $con->connect_error);
    } else {
        $stmt = $con->prepare("SELECT * FROM accounts WHERE username=?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt_result = $stmt->get_result(); // Fix the typo here
        if ($stmt_result->num_rows > 0) {
            $data = $stmt_result->fetch_assoc();
            if ($data['password'] == $password) {
                //echo "<h2>Login Successfully</h2>";
                //echo 'Welcome ' . $username. '!';
                include 'profile.html';
                //header('Location: home.php');
            } else {
                echo "<h2>Invalid Email or Password</h2>";
            }
        } else {
            echo "<h2>Invalid Username or Password</h2>";
        }
    }
?> 

/////////////////////////////////////////////////////////////////////
<?php
session_start();

// if (!isset($_SESSION['loggedin'])) {
//     header('Location: login.html'); // Redirect to login page if not logged in
//     exit;
// }

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'registration';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Assuming $_SESSION['id'] contains the user's ID
// Assuming $_SESSION['id'] contains the user's ID
if (!isset($_SESSION['id'])) {
    exit('User ID is not set.'); // Handle the case where 'id' is not set
}

$userID = $_SESSION['id'];

// Query to retrieve user information
$query = "SELECT username, email, password FROM accounts WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param('i', $userID);
$stmt->execute();
$stmt->bind_result($username, $email, $password);
$stmt->fetch();
$stmt->close();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Profile Page</title>
    <!-- Include your CSS and other head content here -->
</head>
<body class="loggedin">
    <nav class="navtop">
        <!-- Your navigation menu here -->
    </nav>
    <div class="content">
        <h2>Profile Page</h2>
        <div>
            <p>Username: <?php echo $username; ?></p>
            <p>Email: <?php echo $email; ?></p>
            <p>Password: <?php echo $password; ?></p>
        </div>
    </div>
</body>
</html>


/////////////////////////////////////////////////////
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Profile Page</title>
    <link href="style1.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>

<body class="loggedin">
    <nav class="navtop">
        <div>
            <h1>Website Title</h1>
            <a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
            <!--<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>-->
        </div>
    </nav>
    <div class="content">
        <h2>Profile Page</h2>
        <div>
            <p>Your account details are below:</p>
            <table>
                <tr>
                    <td>Username:</td>
                    <td>
                        <!-- <?php echo $username; ?> -->
                        <?=$_SESSION['name']?>
                    </td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td>
                        <?php echo $email; ?>
                    </td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>
                        <?php echo $password; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>


////////////////////////////////////
// We need to use sessions, so you should always start sessions using the below code.
// session_start();

// // If the user is not logged in, redirect to the login page...
// if (!isset($_SESSION['loggedin'])) {
// 	header('Location: index.html');
// 	exit;
// }

// $DATABASE_HOST = 'localhost';
// $DATABASE_USER = 'root';
// $DATABASE_PASS = '';
// $DATABASE_NAME = 'registration';

// $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

// if (mysqli_connect_errno()) {
// 	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
// }

// // We don't have the password or email info stored in sessions, so instead, we can get the results from the database.
// $username = $_SESSION['username']; 
// $stmt = $con->prepare("SELECT password, email FROM accounts WHERE username=?");
// $stmt->bind_param('s', $username);
// $stmt->execute();

// // Bind the result to new variables
// $stmt->bind_result($password, $email);
// $stmt->fetch();
// $stmt->close();

///////////////////////////////////////////////
<!-- <!DOCTYPE html>
<html>
<head>
    <title>Welcome Page</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <p>Email: <?php echo $_SESSION['email']; ?></p>
    <a href="logout.php">Logout</a>
</body>
</html> -->



<?php
session_start(); // Start the session

// var_dump($_SESSION); // Debug statement to check the session contents

// // Check if the user is logged in (username should be set in the session)
if (!isset($_SESSION['username'])) {
    //header("Location: login.html"); // Redirect to the login page if not logged in
    exit('Please complete the login form!');
}
?>
<!-- <?=$_SESSION['name']?> -->