<?php
$servername= "localhost";
$username="root";
$password="";
$database="clbc_suppliers";

$connection = new mysqli($servername, $username, $password, $database);


$name= "";
$product="";
$contactInfo="";

$errorMessage = "";
$successMessage= "";

if( $_SERVER['REQUEST_METHOD'] == 'POST') {
    $product=$_POST['product'];
    $name=$_POST['name'];
    $contactInfo=$_POST['contactInfo'];

    do {
        if (empty($product) || empty($name) || empty($contactInfo)){
            $errorMessage = "All the fields are required";
            break;
        }

        $sql = "INSERT INTO supplier_data (product, name, contactInfo)" . 
               "VALUES ('$product', '$name', '$contactInfo')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query:" . $connection->error;
            break;
        }

        $product= "";
        $name="";
        $contactInfo="";

        $successMessage="Client added succesfully!";

        header("location: /SAISystem/supplier.php");
        exit;

    } while(false);
}
?>


<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-AU-Compatible" content="IE-=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Item</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
    <div class="container my-5">
        <h2>Create Supplier</h2>

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
                <label class="col-sm-3 col-form-label">NAME</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
            </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">PRODUCT</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="product" value="<?php echo $product ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">CONTACT NUMBER</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="contactInfo" value="<?php echo $contactInfo; ?>">
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
        
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">   
                    <button type="submit" class="btn btn-primary">Submit</label>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/SAISystem/supplier.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
</body>
