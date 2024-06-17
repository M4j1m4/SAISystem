<?php
$servername= "localhost";
$username="root";
$password="";
$database="clbc_inventory";

$connection = new mysqli($servername, $username, $password, $database);

$category= "";
$product_name="";
$stocks="";

$errorMessage = "";
$successMessage= "";

// Function to check if a string contains only numbers
function is_numeric_string($str) {
    return preg_match('/^\d+$/', $str);
}

if( $_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name=$_POST['product_name'];
    $category=$_POST['category'];
    $stocks=$_POST['stocks'];

    do {
        if (empty($product_name) || empty($category) || empty($stocks)){
            $errorMessage = "All the fields are required";
            break;
        }

        // Check if product_name contains only numbers
        if (is_numeric_string($product_name)) {
            $errorMessage = "Product name cannot be only numbers";
            break;
        }

        // Check if category contains only numbers
        if (is_numeric_string($category)) {
            $errorMessage = "Category cannot be only numbers";
            break;
        }

        $sql = "INSERT INTO inventory_data (product_name, category, stocks)" . 
               "VALUES ('$product_name', '$category', '$stocks')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query:" . $connection->error;
            break;
        }

        $product_name= "";
        $category="";
        $stocks="";

        $successMessage="Item added successfully!";

        header("location: /SAISystem/home.php");
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
                <h2>CREATE ITEM</h2>

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
                            <label class="col-sm-3 col-form-label">PRODUCT</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="product_name" value="<?php echo $product_name; ?>">
                        </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">CATEGORY</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="category" value="<?php echo $category ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">STOCKS</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="stocks" value="<?php echo $stocks; ?>">
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

                        <div class="row mb-3 space-beside">
                            <div class="offset-sm-1 col-sm-3 d-grid">   
                                <button type="submit" class="btn btn-primary"><i class='fas fa-edit'></i>SUBMIT</button>
                            </div>
                            <div class="col-sm-3 d-grid">
                                <a class="btn btn-outline-primary" href="/SAISystem/home.php" role="button"><i class="fas fa-ban"></i>CANCEL</a>
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