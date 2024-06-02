<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "clbc_inventory";
$connection = new mysqli($servername, $username, $password, $database);

$category = $_GET['category'];

$sql_products = "SELECT product_name FROM inventory_data WHERE category = '$category'";
$result_products = $connection->query($sql_products);

$options = "<option value=''>Select Product</option>";

if ($result_products->num_rows > 0) {
    while ($row = $result_products->fetch_assoc()) {
        $options .= "<option value='".$row['product_name']."'>".$row['product_name']."</option>";
    }
}

echo $options;
?>
