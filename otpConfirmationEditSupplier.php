<?php
    if (isset($_POST["verify_email"])) {
        $email = $_POST["email"];
        $verification_code = $_POST["verification_code"];

        // Connect with the database
        $conn = mysqli_connect("localhost", "root", "", "cblc_verification");

        // Mark email as verified
        $sql = "UPDATE verify SET email_verified_at = NOW() WHERE email = '" . $email . "' AND verification_code = '" . $verification_code . "'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_affected_rows($conn) == 0) {
            die("Verification code failed.");
        } else {
            // Delete the data from the database after successful verification
            $sql_delete = "DELETE FROM verify WHERE email = '" . $email . "'";
            mysqli_query($conn, $sql_delete);
        }

        // Get the 'id' parameter from the URL
        $id = isset($_GET['id']) ? $_GET['id'] : '';

        header("Location: editSupplier.php?id=" . $id);
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
form {
  display: flex; /* Arrange elements horizontally */
  flex-direction: column; /* Stack elements vertically */
  margin: 20px auto; /* Add some margin for spacing */
  width: 300px; /* Set form width */
  padding: 20px; /* Add padding for better spacing */
  border: 1px solid #ccc; /* Add a thin border */
  border-radius: 5px; /* Rounded corners for a smoother look */
}

input[type="text"],
input[type="submit"] {
  padding: 10px; /* Add padding to input fields and submit button */
  border: 1px solid #ccc; /* Border for input fields and button */
  border-radius: 3px; /* Rounded corners for input fields and button */
  margin-bottom: 10px; /* Add some space between elements */
}

input[type="submit"] {
  background-color: #4CAF50; /* Green color for submit button */
  color: white; /* White text for submit button */
  cursor: pointer; /* Change cursor to pointer on hover */
}
</style>
</head>
<body>
<div class="horizontal-container"> 
            <div class="header-container">
                <div class="left-header">
                    <h1>SALES AND INVENTORY SYSTEM</h1>
                </div>
                <div class="right-header">
                    <span id="current-date-time"></span>
                </div>
            </div>
        </div>
        <div class="nav-container">
            <div class="white-container">
                    <button class="button"><a href="/SAISystem/home.php"><i class="fas fa-home"></i>     HOME</a></button>
                    <button class="button"><a href="/SAISystem/users.php"><i class="fas fa-users"></i>     USERS</a></button>
                    <button class="button"><a href="/SAISystem/supplier.php"><i class="fas fa-truck"></i>     SUPPLIERS</a></button>
                    <button class="button"><a href="/SAISystem/stockreport.php"><i class="fas fa-boxes"></i>      STOCKS REPORT</a></button>
                    <button class="button"><a href="/SAISystem/salesreport.php"><i class="fas fa-chart-line"></i>      SALES REPORT</a></button>
            </div>
        </div>
        <div class="admin-button-container">
            <button class="admin-button">ADMIN &#9660;</button>
            <button class="signout-button"><a href="logout.php" class="none1">SIGN OUT</a></button>
        </div>
        <div class="vertical-container">
            <div class="circle-container">
                <img src="img/1.png" alt="ClarkLane Logo">
            </div>
            <div class="button-container">  
                <div class="home-button-container">
                    <button class="button"><i class="fas fa-home"></i>HOME</button>
                </div>
                <div class="user-button-container">
                    <button class="button"><a href="/SAISystem/users.php"><i class="fas fa-users"></i>USERS</a></button>
                </div>
                <div class="supplier-button-container">
                    <button class="button"><a href="/SAISystem/supplier.php"><i class="fas fa-truck"></i>SUPPLIERS</a></button>
                </div>
                <div class="stock-button-container">    
                    <button class="button"><a href="/SAISystem/stockreport.php" class="none"><i class="fas fa-boxes"></i>STOCKS REPORT</a></button>
                </div>
                <div class="sales-button-container">
                    <button class="button"><a href="/SAISystem/salesreport.php"><i class="fas fa-chart-line"></i>SALES REPORT</a></button>
                </div>
            </div>
            <div class="scroll-to-top-container">
                <button class="scroll-to-top-button">Move to Top ↑</button>
            </div>
        </div>
        <div class="content-container">   
            <div class="container my-5">
              <form method="POST">
                <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>" required>
                <input type="text" name="verification_code" placeholder="Enter verification code" required />
            
                <input type="submit" name="verify_email" value="Verify">
              </form>
            </div>
        </div>
</body>
</html>

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

        // Scroll to top button functionality
        const scrollToTopButton = document.querySelector('.scroll-to-top-button');

        scrollToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        function getCurrentDateTime() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' };
        return now.toLocaleString('en-US', options);
    }

    // Update the date and time every second
    const dateTimeElement = document.getElementById('current-date-time');
    setInterval(() => {
        dateTimeElement.textContent = getCurrentDateTime();
    }, 1000);
</script>