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
    <div class="admin-button-container">
        <button class="admin-button">GUEST &#9660;</button>
        <button class="signout-button"><a href="logout.php" class="none1">SIGN OUT</a></button>
    </div>
    <div class="vertical-container">
        <div class="circle-container">
            <img src="img/1.png" alt="ClarkLane Logo">
        </div>
        <div class="nav-container">
         <div class="white-container">
                <button class="button"><a href="/SAISystem/guesthome.php"><i class="fas fa-truck"></i>     HOME</a></button>
                <button class="button"><a href="/SAISystem/gueststockreport.php"><i class="fas fa-boxes"></i>      STOCKS REPORT</a></button>
                <button class="button"><a href="/SAISystem/guestsalesreport.php"><i class="fas fa-chart-line"></i>      SALES REPORT</a></button>
        </div>
    </div>
        <div class="button-container">  
            <div class="home-button-container">
                <button class="button"><a href="/SAISystem/guesthome.php"><i class="fas fa-home"></i>HOME</a></button>
            </div>
            <div class="stock-button-container">    
                <button class="button"><a href="/SAISystem/gueststockreport.php" class="none"><i class="fas fa-boxes"></i>STOCKS REPORT</a></button>
            </div>
            <div class="sales-button-container">
                <button class="button"><a href="/SAISystem/guestsalesreport.php"><i class="fas fa-chart-line"></i>SALES REPORT</a></button>
            </div>
        </div>
        <div class="scroll-to-top-container">
            <button class="scroll-to-top-button">Move to Top ↑</button>
        </div>
    </div>
    <div class="content-container">
        <div class="container my-5">
            <div class="color-design">
                <h1>DAILY REPORT<h1>
            </div>    
            <form action="generate_pdf.php" method="POST" target="_blank">
                <button type="submit" class="btn btn-primary">Generate Report</button>
            </form>
            <div class="spacetop">
            <h4 class="stock-header">
            <span class="stock-header-icon"><i class="fas fa-exclamation-triangle"></i></span>
            <span class="stock-header-text">CRITICAL STOCK ITEMS</span>
            </h4>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Current Stock</th>
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
                    
                    // Query to select products with stock 3 or below
                    $sql = "SELECT product_name, stocks FROM inventory_data WHERE stocks <= 3";
                    $result = $connection->query($sql);

                    if(!$result){
                        die("Invalid Query:" . $connection->error);
                    }

                    while($row = $result->fetch_assoc()){
                        echo "
                        <tr>
                            <td>$row[product_name]</td>
                            <td>$row[stocks]</td>
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
