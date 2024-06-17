<!DOCTYPE html> 
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1. ">
    <title>SALES REPORT</title>
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
                <button class="button"><a href="/SAISystem/home.php"><i class="fas fa-home"></i>HOME</a></button>
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
            <a class="btn btn-primary btn-width" role="button" href="/SAISystem/emailBoughtInventory.php"><i class="fas fa-truck"></i>    CREATE PURCHASE</a>
            <div class="spacetop">
                <a class="btn btn-primary btn-width" role="button" target="_blank" href="/SAISystem/generate_salesreport.php"><i class="fas fa-flag"></i>     GENERATE REPORT</a>
            </div>
            <!-- Date Range Selector -->  
            <div class="color-design spacetop">
                <h3>SALES HISTORY</h3>
            </div>
            <div class="row justify-content-center"> <!-- Center the content horizontally -->
                <div class="col-sm-11"> <!-- Adjust column size as needed -->
                    <form action="salesreport.php" method="GET" class="mt-3 mb-3">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Date Range</span>
                            <input type="date" class="form-control" id="start-date" name="start-date">
                            <span class="input-group-text">to</span>    
                            <input type="date" class="form-control" id="end-date" name="end-date">
                        </div>

                        <button type="submit" class="btn btn-primary" role="button"><i class='fas fa-edit'></i>     SUBMIT</button>
                    </form>
                </div>
            </div>

                <form action="salesreport.php" method="GET" class="mt-3 mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Category/Product Name" name="search">
                        <button class="btn btn-primary btn-width" role="button" type="submit"><i class="fas fa-search"></i> Search</button>
                    </div>
                </form>

            <!-- Sales Report Table -->
            <table class="table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Purchase Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php
include 'db_connection.php';

// Define default start and end dates
$start_date = isset($_GET['start-date']) ? $_GET['start-date'] : date('Y-m-d', strtotime('-1 week'));
$end_date = isset($_GET['end-date']) ? $_GET['end-date'] : date('Y-m-d');

// Format start and end dates for timestamp comparison
$start_timestamp = $start_date . ' 00:00:00';
$end_timestamp = $end_date . ' 23:59:59';

// Check if a search query is submitted
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    // Query to search for the input in category or product name
    $sql = "SELECT id, category, product_name, quantity, price, date FROM sales_report WHERE quantity > 0 AND (category LIKE '%$search%' OR product_name LIKE '%$search%')";

    // Check if start and end dates are provided
    if (!empty($start_date) && !empty($end_date)) {
        $sql .= " AND date BETWEEN '$start_timestamp' AND '$end_timestamp'";
    }

    // Check if category is provided
    if (!empty($_GET['category'])) {
        $category = $_GET['category'];
        $sql .= " AND category = '$category'";
    }
} else {
    // Fetch data from the sales_report table within the specified date range and category, ordered by date in descending order
    $sql = "SELECT id, category, product_name, quantity, price, date FROM sales_report WHERE quantity > 0";

    // Check if start and end dates are provided
    if (!empty($start_date) && !empty($end_date)) {
        $sql .= " AND date BETWEEN '$start_timestamp' AND '$end_timestamp'";
    }

    // Check if category is provided
    if (!empty($_GET['category'])) {
        $category = $_GET['category'];
        $sql .= " AND category = '$category'";
    }

    // Order by date in descending order
    $sql .= " ORDER BY date DESC";
}

$result = $connection->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["category"] . "</td>";
        echo "<td>" . $row["product_name"] . "</td>";
        echo "<td>" . $row["quantity"] . "</td>";
        echo "<td>" . $row["price"] . "</td>";
        echo "<td>" . $row["date"] . "</td>"; 
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No data found</td></tr>";
}

// Close connection
$connection->close();
?>
                </tbody>
            </table>
            <div class="fav-sales">
            <div class="fav-sales-left">
                <h3>TOP SALES</h3>
            </div>
            <div class="fav-sales-right">
                <h3>POPULAR ITEMS</h3>
            </div>
        </div>
        <div class="parent-container">
    <div class="left-half">
        <?php
        include 'db_connection.php';

        $sql = "
        SELECT sr.product_name, sr.quantity, id.product_image 
        FROM sales_report sr
        LEFT JOIN inventory_data id ON sr.product_name = id.product_name
        WHERE sr.quantity > 0
        ORDER BY sr.quantity DESC 
        LIMIT 1
        ";
        $result = $connection->query($sql);

        // Check if there is a product with the highest quantity
        if ($result->num_rows > 0) {
            // Fetch the product information
            $row = $result->fetch_assoc();
            $productName = $row["product_name"];
            $quantity = $row["quantity"];
            $productImage = $row["product_image"];

            echo "<div class='top-sales-container'>";
            echo "<p>Product Name: " . htmlspecialchars($productName) . "</p>";
            echo "<p>Quantity Sold: " . htmlspecialchars($quantity) . "</p>";
            
            // Display the product image if available
            if (!empty($productImage) && file_exists("images/$productImage")) {
                echo "<img src='images/" . htmlspecialchars($productImage) . "' alt='" . htmlspecialchars($productName) . "'>";
            } else {
                // If no specific image is available, try to find an image with the product name
                $sanitizedProductName = preg_replace('/[^A-Za-z0-9\-\"]/', '', $productName);
                $imageExtensions = ['.png', '.jpg', '.jpeg', '.gif'];
                $imageFound = false;
                
                foreach ($imageExtensions as $ext) {
                    $imageName = "images/{$sanitizedProductName}{$ext}";
                    if (file_exists($imageName)) {
                        echo "<img src='" . htmlspecialchars($imageName) . "' alt='" . htmlspecialchars($productName) . "'>";
                        $imageFound = true;
                        break;
                    }
                }
                
                if (!$imageFound) {
                    echo "<p>No image available</p>";
                }
            }
            
            echo "</div>";
        } else {
            echo "<div class='top-sales-container'>";
            echo "<h3>TOP SALES</h3>";
            echo "<p>No sales data found</p>";
            echo "</div>";
        }
        ?>
    </div>

    <div class="right-half">
        <div class="popular-items-container">
            <?php
            include 'db_connection.php';

            $sql = "
            SELECT sr.product_name, COUNT(*) as frequency, id.product_image 
            FROM sales_report sr
            LEFT JOIN inventory_data id ON sr.product_name = id.product_name
            WHERE sr.quantity > 0
            GROUP BY sr.product_name
            HAVING COUNT(*) > 1
            ORDER BY frequency DESC 
            LIMIT 1
            ";
            $result = $connection->query($sql);

            // Check if there are popular items
            if ($result->num_rows > 0) {
                // Fetch the product information
                $row = $result->fetch_assoc();
                $productName = $row["product_name"];
                $frequency = $row["frequency"];
                $productImage = $row["product_image"];

                echo "<p>Product Name: " . htmlspecialchars($productName) . "</p>";
                echo "<p>Times Sold: " . htmlspecialchars($frequency) . "</p>";
                
                // Display the product image if available
                if (!empty($productImage) && file_exists("images/$productImage")) {
                    echo "<img src='images/" . htmlspecialchars($productImage) . "' alt='" . htmlspecialchars($productName) . "'>";
                } else {
                    // If no specific image is available, try to find an image with the product name
                    $sanitizedProductName = preg_replace('/[^A-Za-z0-9\-\"]/', '', $productName);
                    $imageExtensions = ['.png', '.jpg', '.jpeg', '.gif'];
                    $imageFound = false;
                    
                    foreach ($imageExtensions as $ext) {
                        $imageName = "images/{$sanitizedProductName}{$ext}";
                        if (file_exists($imageName)) {
                            echo "<img src='" . htmlspecialchars($imageName) . "' alt='" . htmlspecialchars($productName) . "'>";
                            $imageFound = true;
                            break;
                        }
                    }
                    
                    if (!$imageFound) {
                        echo "<p>No image available</p>";
                    }
                }
            } else {
                echo "<h3>POPULAR ITEMS</h3>";
                echo "<p>No popular items found</p>";
            }
            ?>
        </div>
    </div>
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

    // Function to handle form submission
function handleFormSubmit(event) {
    event.preventDefault(); // Prevent default form submission behavior
    
    // Get the form element
    const form = event.target;
    
    // Get the selected category value
    const categoryFilter = document.getElementById('category-filter').value;
    
    // Create a URLSearchParams object to manage query parameters
    const params = new URLSearchParams();
    
    // Add the category filter parameter if a category is selected
    if (categoryFilter) {
        params.set('category', categoryFilter);
    }
    
    // Add the start and end date parameters
    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;
    if (startDate) {
        params.set('start-date', startDate);
    }
    if (endDate) {
        params.set('end-date', endDate);
    }
    
    // Update the form action with the query parameters
    form.action = `salesreport.php?${params.toString()}`;
    
    // Submit the form
    form.submit();
}


</script>
