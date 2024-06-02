<?php
$servername= "localhost";
$username="root";
$password="";
$database="clbc_users";

$connection = new mysqli($servername, $username, $password, $database);


$username= "";
$category="";
$password="";

$errorMessage = "";
$successMessage= "";

if( $_SERVER['REQUEST_METHOD'] == 'POST') {
    $username=$_POST['username'];
    $category=$_POST['category'];
    $password=$_POST['password'];

    do {
        if (empty($username) || empty($category) || empty($password)){
            $errorMessage = "All the fields are required";
            break;
        }

        $sql = "INSERT INTO users (username, category, password)" . 
               "VALUES ('$username', '$category', '$password')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query:" . $connection->error;
            break;
        }

        $username= "";
        $category="";
        $password="";

        $successMessage="Client added succesfully!";

        header("location: /SAISystem/users.php");
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
        <h2>Create Account</h2>

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
                <label class="col-sm-3 col-form-label">USERNAME</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
            </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">CATEGORY</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="category" value="<?php echo $category ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">PASSWORD</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="password" value="<?php echo $password; ?>">
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
                    <a class="btn btn-outline-primary" href="/SAISystem/users.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
</body>
