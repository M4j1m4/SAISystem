<?php 
session_start();

if(isset($_SESSION['id']) && isset($_SESSION['username'])){
    ?>

    <!DOCTYPE html> 
    <html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HOME</title>
        <link rel="stylesheet" href="home.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lexend+Exa:wght@100..900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
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
                <div class="color-design">
                    <h3>INVENTORY</h3>
                </div> 
                <div class="newItem">
                    <a class="btn btn-primary btn-width" href="/SAISystem/emailVerification.php" role="button"><i class="fas fa-plus-circle add-icon"></i>    NEW ITEM</a>
                </div>
                <br>
                <!-- Search Form -->
                <form action="home.php" method="GET" class="mt-3 mb-3"> 
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="ID/category/product" name="search">
                        <button class="btn btn-primary btn-width" role="button" type="submit"><i class="fas fa-search"></i>     Search</button>
                    </div>
                </form>
                <table class="table">
                    <thead>
                        <tr>
                            <th>CATEGORY</th>
                            <th>PRODUCT</th>
                            <th>PRODUCT IMAGE</th>
                            <th>STOCKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $servername= "localhost";
                        $username="root";
                        $password="";
                        $database="clbc_inventory";

                        $connection = new mysqli($servername, $username, $password, $database);

                        if ($connection-> connect_error) {
                            die("Connection failed:" . $connection-> connect_error);
                        }
                        
                        // Check if a search query is submitted
                        if(isset($_GET['search'])) {
                            $search = $_GET['search'];
                            // Query to search for the input in ID, category, or product
                            $sql = "SELECT * FROM inventory_data WHERE id LIKE '%$search%' OR category LIKE '%$search%' OR product_name LIKE '%$search%'";
                        } else {
                            // Default query to fetch all data
                            $sql = "SELECT * FROM inventory_data";
                        }

                        $result = $connection->query($sql);

                        if(!$result){
                            die("Invalid Query:" . $connection->error);
                        }

                        while($row = $result->fetch_assoc()){
                            echo "
                            <tr> 
                                <td>$row[category]</td>
                                <td>$row[product_name]</td>
                                <td><img src='images/$row[product_image]' alt='$row[product_name]' style='max-width: 100px;'></td>
                                <td>$row[stocks]</td>
                                <td>
                                    <a class='btn btn-primary btn-sm' href='/SAISystem/emailEditInv.php?id=$row[id]'><i class='fas fa-edit'></i>   EDIT</a>
                                    <a class='btn btn-danger btn-sm' href='/SAISystem/emailDeleteInv.php?id=$row[id]'><i class='fas fa-trash-alt'></i>   DELETE</a>
                                </td>
                            </tr>
                            ";
                        }
                        ?>
                    </tbody>
                </table> 
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

    <?php
}
else {
    header("Location: login.php");
    exit();
}