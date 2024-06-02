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
        <div class="scroll-to-top-container">
            <button class="scroll-to-top-button">Move to Top ↑</button>
        </div>
        <div class="center-container">
            <div class="container my-5">
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/SAISystem/salesreport.php" role="button">Cancel</a>
                </div>
                <br>
                <!-- Search Form -->
                <form action="createPurchase.php" method="GET" class="mt-3 mb-3"> 
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="ID/category/product" name="search">
                        <button class="btn btn-primary btn-width" role="button" type="submit"><i class="fas fa-search"></i>     Search</button>
                    </div>
                </form>
                <table class="table">
                    <thead>
                        <a class='btn btn-primary btn-sm' href='/SAISystem/boughtInventory.php?id=$row[id]'><i class='fas fa-edit'></i>   CREATE PURCHASE</a>
                        <tr>
                            <th>ID</th>
                            <th>CATEGORY</th>
                            <th>PRODUCT</th>
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
                                <td>$row[id]</td>
                                <td>$row[category]</td>
                                <td>$row[product_name]</td>
                                <td>$row[stocks]</td>
                                <td>
                                    <a class='btn btn-primary btn-sm' href='/SAISystem/stockInventory.php?id=$row[id]'><i class='fas fa-boxes'></i>   STOCKS</a>
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
                const scrollToTopButton = document.querySelector('.scroll-to-top-button');

scrollToTopButton.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}); 
    </script>