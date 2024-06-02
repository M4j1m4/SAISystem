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
            <img src="/img/1.png" alt="ClarkLane Logo">
        </div>
        <div class="nav-container">
         <div class="white-container">
                <button class="button"><a href="/SAISystem/supplier.php"><i class="fas fa-truck"></i>     SUPPLIERS</a></button>
                <button class="button"><a href="/SAISystem/stockreport.php"><i class="fas fa-boxes"></i>      STOCKS REPORT</a></button>
                <button class="button"><a href="/SAISystem/salesreport.php"><i class="fas fa-chart-line"></i>      SALES REPORT</a></button>
        </div>
    </div>
        <div class="button-container">  
            <div class="home-button-container">
                <button class="button"><i class="fas fa-home"><a href="/SAISystem/guesthome.php"></i>HOME</a></button>
            </div>
            <div class="user-button-container">
                <button class="button"><a href="/SAISystem/guestusers.php"><i class="fas fa-users"></i>USERS</a></button>
            </div>
            <div class="supplier-button-container">
                <button class="button"><a href="/SAISystem/guestsupplier.php"><i class="fas fa-truck"></i>SUPPLIERS</a></button>
            </div>
            <div class="stock-button-container">    
                <button class="button"><a href="/SAISystem/gueststockreport.php" class="none"><i class="fas fa-boxes"></i>STOCKS REPORT</a></button>
            </div>
            <div class="sales-button-container">
                <button class="button"><a href="/SAISystem/guestsalesreport.php"><i class="fas fa-chart-line"></i>SALES REPORT</a></button>
            </div>
        </div>
        <div class="scroll-to-top-container">
            <button class="scroll-to-top-button">↑</button>
        </div>
    </div>
    <div class="content-container">
            <div class="container my-5">
                <br>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>PRODUCT</th>
                            <th>CONTACT NUMBER</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $servername= "localhost";
                        $username="root";
                        $password="";
                        $database="clbc_suppliers";

                        $connection = new mysqli($servername, $username, $password, $database);

                        if ($connection-> connect_error) {
                            die("Connection failed:" . $connection-> connect_error);
                        }
                        
                        $sql = "SELECT * from supplier_data";
                        $result = $connection->query($sql);

                        if(!$result){
                            die("Invalid Query:" . $connection->error);
                        }

                        while($row = $result->fetch_assoc()){
                            echo "
                            <tr>
                                <td>$row[id]</td>
                                <td>$row[name]</td>
                                <td>$row[product]</td>
                                <td>$row[contactInfo]</td>
                            </tr>
                            ";
                        }
                        ?>
                    </tbody>
                </table> 
            </div>
    </div>

    <br>
    <button onclick="addRow()">Add Supplier</button>
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

    