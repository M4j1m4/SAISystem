<?php
session_start();
include "db_conn.php";

if(isset($_POST['uname']) && isset($_POST['password'])) {
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    if(empty($uname)) {
        header("Location: login.php?error=Username is required");
        exit();
    } elseif(empty($pass)) {
        header("Location: login.php?error=Password is required");
        exit();
    } else {
        // Check if username and password match in the database
        $sql = "SELECT * FROM users WHERE username='$uname' AND password='$pass'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) === 1) {
            // If username and password match, log the user in
            $row = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $row['username'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['id'] = $row['id'];
            header("Location: home.php");
            exit();
        } else {
            // If username and password do not match, redirect to login page with error
            header("Location: login.php?error=Incorrect username or password");
            exit();
        }
    }
} else {
    // If username or password are not set, redirect to login page
    header("Location: login.php");
    exit();
}
?>
