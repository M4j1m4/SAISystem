<!DOCTYPE html>
<html>
<head>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lexend+Exa:wght@100..900&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/179c54bbd3.js"></script>
  <link rel="stylesheet" href="register.css">
</head>
<body>
  <div class="log-in-page">
    <?php
    include("db_conn.php");
    if(isset($_POST['submit'])){
      $username = $_POST['username'];
      $category = $_POST['category'];
      $password = $_POST['password']; 

      mysqli_query($conn, "INSERT INTO users(username, category, password) VALUES('$username', '$category', '$password')") or die("Error Occurred");
      echo "<div><p>Registration Successful!</p></div><br>";
      echo "<a href='login.php'><button>Login Now</button></a>";
    }
    ?>
    <div>
      <img class="clark-lane-logo" src="/img/clarklane.png">
    </div>
    <div class="login">
      <div class="welcome-text">
        <p>Register</p>
      </div>
      <form action="" method="post"> <!-- Added form tag and action attribute -->
        <div class="username">
          <p style="margin-bottom: 10px">Username</p>
          <input class="user-box" type="text" name="username"> <!-- Added name attribute -->
        </div>
        <div class="email">
          <p style="margin-bottom: 10px">Category</p>
          <input class="email-box" type="text" name="category"> <!-- Added name attribute -->
        </div>
        <div class="password">
          <p style="margin-bottom: 10px">Password</p>
          <input class="pass-box" type="password" name="password" id="myInput"> <!-- Added name attribute -->
        </div>
        <div>
          <button class="log-in-button" type="submit" name="submit"> <!-- Added type and name attributes -->
            Create Account
          </button>
          <div class="register-here">
            <span class="signup">Already have an account? <a href="login.php">Login</a></span>
          </div>
        </div>
      </form> <!-- Closed form tag -->
    </div> 
  </div>
</body>
</html>
