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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/SAISystem/home.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
