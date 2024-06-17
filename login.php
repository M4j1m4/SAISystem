<!DOCTYPE html>
<html>
<head>
    <title>Clark Lane Bicycle Center</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Exa:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/179c54bbd3.js"></script>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="home.css">
</head>
<body>
<div class="log-in-page">
    <div>
        <img class="clark-lane-logo" src="img/clarklane.png">
    </div>
    <div class="login">
        <div class="welcome-text">
            <p>Login</p>
        </div>
        <!-- PHP code to display error messages -->
        <?php
if (isset($_GET['error'])) {
    $error_message = $_GET['error'];
    switch ($error_message) {
        case "Username is required":
            echo "<div class='error-message'>Please enter your username</div>";
            break;
        case "Password is required":
            echo "<div class='error-message'>Please enter your password</div>";
            break;
        case "Incorrect password":
            echo "<div class='error-message'>The password you entered is incorrect</div>";
            break;
        case "Incorrect username":
            echo "<div class='error-message'>The username you entered is incorrect</div>";
            break;
        case "Incorrect username and password":
            echo "<div class='error-message'>Both username and password are incorrect</div>";
            break;
        case "Username and password are required":
            echo "<div class='error-message'>Please enter both username and password</div>";
            break;
        default:
            echo "<div class='error-message'>An error occurred</div>";
            break;
    }
}
?>
        <!-- End of PHP code -->
        <div class="admin-button-container">
            <button class="admin-button">ADMIN &#9660;</button>
            <button class="signout-button"><a href="guest.php" class="none1">GUEST</a></button>
        </div>
        <form action="loglogic.php" method="post"> <!-- Added form tags -->
            <div class="username">
                <p style="margin-bottom: 10px">Username</p>
                <input class="user-box" type="text" name="uname"> <!-- Added name attribute -->
            </div>
            <div class="password">
                <p style="margin-bottom: 10px">Password</p>
                <span class="eye" onclick="myFunction()">
                    <input class="pass-box" type="password" id="myInput" name="password"> <!-- Added name attribute -->
                    <i id="hide1" class="fa-solid fa-eye"></i>
                    <i id="hide2" class="fa-solid fa-eye-slash"></i>
                </span>
            </div>
            <div>
                <button class="log-in-button" type="submit"> <!-- Added type="submit" -->
                    Log In
                </button>
            </div>
        </form> <!-- Closed form tags -->
    </div>
</div>
<script>
    function myFunction(){
        var x = document.getElementById("myInput");
        var y = document.getElementById("hide1");
        var z = document.getElementById("hide2");

        if(x.type === 'password'){
            x.type = "text";
            y.style.display = "block";
            z.style.display = "none";
        } else {
            x.type = "password";
            y.style.display = "none";
            z.style.display = "block";
        }
    }
</script>
<script>
    // JavaScript to handle the dropdown menu

    // Get the admin button and the sign-out button
    const adminButton = document.querySelector('.admin-button');
    const signoutButton = document.querySelector('.signout-button');

    // Add an event listener to the admin button
    adminButton.addEventListener('click', () => {
        // Toggle the visibility of the sign-out button
        if (signoutButton.style.display === 'none' || signoutButton.style.display === '') {
            signoutButton.style.display = 'block';
        } else {
            signoutButton.style.display = 'none';
        }
    });
</script>
</body>
</html>
