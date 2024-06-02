<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-AU-Compatible" content="IE-=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Sales Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
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
                <div class="col-sm-6">
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
                <div class="col-sm-6">
                    <select class="form-select" name="product_name" id="product_name_select" required>
                        <option value="">Select Product</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">QUANTITY</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="quantity" value="<?php echo $quantity; ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">PRICE</label>
                <div class="col-sm-6">
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

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/SAISystem/createPurchase.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>

    <script>
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
</body>
</html>
