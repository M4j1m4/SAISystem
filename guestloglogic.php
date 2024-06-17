<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
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
        header("Location: guest.php?error=Username and password are required");
        exit();
    } elseif (empty($uname)) {
        header("Location: guest.php?error=Username is required");
        exit();
    } elseif (empty($pass)) {
        header("Location: guest.php?error=Password is required");
        exit();
    } else {
        $sql = "SELECT * FROM guest WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $stored_password = $row['password'];

            if ($pass === $stored_password) { // Compare plain text passwords
                $_SESSION['username'] = $row['username'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];

                if (isset($row['category']) && $row['category'] == 'guest') {
                    header("Location: guesthome.php");
                } else {
                    header("Location: guesthome.php");
                }
                exit();
            } else {
                header("Location: guest.php?error=Incorrect password");
                exit();
            }
        } else {
            header("Location: guest.php?error=Incorrect username");
            exit();
        }

        $stmt->close();
    }
} else {
    header("Location: guestlogin.php");
    exit();
}

$conn->close();
?>
