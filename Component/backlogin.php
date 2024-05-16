<?php
session_start();
$host = '192.168.100.64';
$db = 'lc';
$user = 'lc_user';
$pass = 'password';
$port = '80';

// Establishing a connection to PostgreSQL database
$conn = pg_connect("host=$host dbname=$db user=$user password=$pass port=$port");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if the user exists
    $query = "SELECT * FROM users WHERE email = $1";
    $result = pg_query_params($conn, $query, array($email));

    if ($result) {
        $user = pg_fetch_assoc($result);
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Store user data in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            header("Location: welcome.php");
            exit();
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "Error in query: " . pg_last_error($conn);
    }

    pg_free_result($result);
}

pg_close($conn);
?>