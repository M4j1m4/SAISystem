<?php
$servername= "localhost";
$username="root";
$password="";
$database="clbc_users";

$connection = new mysqli($servername, $username, $password, $database);


$username= "";
$category="";
$password="";
$gmail="";

$errorMessage = "";
$successMessage= "";

if( $_SERVER['REQUEST_METHOD'] == 'POST') {
    $username=$_POST['username'];
    $category=$_POST['category'];
    $password=$_POST['password'];
    $gmail = $_POST['gmail'];

    do {
        if (empty($username) || empty($category) || empty($password) || empty($gmail)){
            $errorMessage = "All the fields are required";
            break;
        }

        $sql = "INSERT INTO guest (username, category, password, gmail)" . 
               "VALUES ('$username', '$category', '$password', '$gmail')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query:" . $connection->error;
            break;
        }

        $username= "";
        $category="";
        $password="";
        $gmail="";

        $successMessage="Client added succesfully!";

        header("location: /SAISystem/users.php");
        exit;

    } while(false);
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
                <div class="container">
                <h2>Create Account</h2>

                    <?php
                    if( !empty($errorMessage)) {
                        echo "
                        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                            <strong>$errorMessage</strong>
                            <button type='button' class='btn-close data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                        ";
                    }

                    ?>

                    <form method="post">
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">USERNAME</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
                        </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">CATEGORY</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="category" value="<?php echo $category ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">PASSWORD</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="password" value="<?php echo $password; ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">EMAIL</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="gmail" value="<?php echo $gmail; ?>">
                            </div>
                        </div>

                        <?php
                        if( !empty($successMessage)){
                            echo "  
                            <div class='row mb-3'>
                                <div class='offset-sm-3 col-sm-6'>
                                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                        <strong>$successMessage</strong>
                                        <button type='button' class='btn-close data-bs-dismiss='alert' aria-label='Close'></button>
                                    </div>
                                </div>
                            </div>                
                            ";
                        }   

                        ?>

                        <div class="row mb-3 space-beside" >
                            <div class="offset-sm-3 col-sm-3 d-grid">   
                                <button type="submit" class="btn btn-primary"><i class='fas fa-edit'></i>SUBMIT</label>
                            </div>
                            <div class="col-sm-3 d-grid">
                                <a class="btn btn-outline-primary" href="/SAISystem/users.php" role="button"><i class='fas fa-ban'></i>CANCEL</a>
                            </div>
                        </div>
                    </form>
                </div>
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
