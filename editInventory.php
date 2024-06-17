<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "clbc_inventory";

$connection = new mysqli($servername, $username, $password, $database);

$id = "";
$product_name= "";
$category="";
$stocks="";
$product_image="";

$errorMessage = "";
$successMessage= "";

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(!isset($_GET['id'])) {
        header('location: /SAISystem/home.php');
        exit;
    }

    $id = $_GET['id'];

    $sql = "SELECT * FROM inventory_data WHERE id=$id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if(!$row) {
        header('location: /SAISystem/home.php');
        exit;
    }

    $product_name = $row['product_name'];
    $category = $row['category'];
    $stocks = $row['stocks'];
    $product_image = $row['product_image'];
}
else if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $stocks = $_POST['stocks'];
    $product_image = $_FILES['product_image']['name'];
    $product_img_temp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'images/' . $product_image;

    // Move uploaded image to target folder
    if(move_uploaded_file($product_img_temp_name, $product_image_folder)) {
        // Update database with new product image
        $sql = "UPDATE inventory_data SET product_name = '$product_name', category = '$category', stocks = '$stocks', product_image = '$product_image' WHERE id = $id";
        
        if($connection->query($sql) === TRUE) {
            $successMessage = "Product updated successfully";
            header('Location: home.php');
            exit;
        } else {
            $errorMessage = "Error updating product: " . $connection->error;
        }
    } else {
        $errorMessage = "Error uploading image";
    }
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
                    <h2>EDIT ITEM</h2>

                        <?php if(!empty($errorMessage)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $errorMessage; ?>
                            </div>
                        <?php endif; ?>

                        <?php if(!empty($successMessage)): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $successMessage; ?>
                            </div>
                        <?php endif; ?>

                        <form method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">PRODUCT</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="product_name" value="<?php echo $product_name; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">CATEGORY</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="category" value="<?php echo $category ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">STOCKS</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="stocks" value="<?php echo $stocks; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">PRODUCT IMAGE</label>
                                <div class="col-sm-6">
                                    <input type="file" class="form-control" name="product_image" accept="image/png, image/jpg, image/jpeg">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="offset-sm-3 col-sm-3 d-grid">   
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