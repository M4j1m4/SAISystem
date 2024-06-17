<?php
session_start();

$servername = "localhost";
$username = "root";  // Replace with your actual MySQL username
$password = "";  // Replace with your actual MySQL password
$dbname = "clbc_users";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = isset($_POST['uname']) ? validate($_POST['uname']) : '';
    $pass = isset($_POST['password']) ? validate($_POST['password']) : '';

    if (empty($uname) && empty($pass)) {
        header("Location: login.php?error=Username and password are required");
        exit();
    } elseif (empty($uname)) {
        header("Location: login.php?error=Username is required");
        exit();
    } elseif (empty($pass)) {
        header("Location: login.php?error=Password is required");
        exit();
    } else {
        // First, check if the username exists
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Username is correct, now check the password
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];

            if ($pass === $row['password']) {
                // Both username and password are correct
                $_SESSION['username'] = $row['username'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];

                if (isset($row['category']) && $row['category'] == 'admin') {
                    header("Location: home.php");
                } else {
                    header("Location: home.php");
                }
                exit();
            } else {
                // Username is correct, but password is incorrect
                header("Location: login.php?error=Incorrect password");
                exit();
            }
        } else {
            // Username is incorrect, now check if the password is correct for any user
            $sql = "SELECT * FROM users WHERE password = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $pass);
            $stmt->execute();
            $result = $stmt->get_result();
        
            if ($result->num_rows > 0) {
                // Password is correct, but username is incorrect
                header("Location: login.php?error=Incorrect username");
                exit();
            } else {
                // Both username and password are incorrect
                header("Location: login.php?error=Incorrect username and password");
                exit();
            }
        
            $stmt->close();
        }
    }
} else {
    // If not a POST request, redirect to login page
    header("Location: login.php");
    exit();
}

$conn->close();
?>