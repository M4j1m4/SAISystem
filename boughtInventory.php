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
                <h2>UPDATE SALES REPORT</h2>

                <?php
                // Establish database connection
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "clbc_inventory";
                $connection = new mysqli($servername, $username, $password, $database);

                $errorMessage = "";
                $successMessage = "";
                $category = "";
                $product_name = "";
                $quantity = "";
                $price = "";

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Handle insertion into sales_report table
                    $category = $_POST['category'];
                    $product_name = $_POST['product_name'];
                    $quantity = $_POST['quantity'];
                    $price = $_POST['price'];

                    // Inserting new record
                    $sql_insert = "INSERT INTO sales_report (category, product_name, quantity, price) VALUES ('$category', '$product_name', '$quantity', '$price')";

                    if ($connection->query($sql_insert) === TRUE) {
                        $successMessage = "Record inserted successfully";
                        header("location: /SAISystem/createPurchase.php");
                        exit;
                    } else {
                        $errorMessage = "Error inserting record: " . $connection->error;
                    }
                }

                // Fetch categories from the database
                $sql_categories = "SELECT DISTINCT category FROM inventory_data";
                $result_categories = $connection->query($sql_categories);

                ?>

                <form method="post">
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">CATEGORY</label>
                        <div class="col-sm-10">
                            <select class="form-select" name="category" onchange="fetchProducts(this.value)">
                                <option value="">Select Category</option>
                                <?php
                                if ($result_categories->num_rows > 0) {
                                    while ($row = $result_categories->fetch_assoc()) {
                                        echo "<option value='".$row['category']."'>".$row['category']."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">PRODUCT NAME</label>
                        <div class="col-sm-10">
                            <select class="form-select" name="product_name" id="product_name_select" required>
                                <option value="">Select Product</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">QUANTITY</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="quantity" value="<?php echo $quantity; ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">PRICE</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="price" value="<?php echo $price; ?>" required>
                        </div>
                    </div>

                    <?php
                    if (!empty($successMessage)) {
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
                        <div class="offset-sm-3 col-sm-3 d-grid">
                            <button type="submit" class="btn btn-primary"><i class='fas fa-edit'></i>SUBMIT</button>
                        </div>
                        <div class="col-sm-3 d-grid">
                            <a class="btn btn-outline-primary" href="/SAISystem/createPurchase.php" role="button"><i class='fas fa-ban'></i>CANCEL</a>
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


    function fetchProducts(category) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'fetch_products.php?category=' + category, true);
        xhr.onload = function() {
            if (this.status == 200) {
                document.getElementById('product_name_select').innerHTML = this.responseText;
            }
        }
        xhr.send();
    }

</script>
