<?php
// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include TCPDF library's autoloader
require_once('library/TCPDF-main/tcpdf.php');

// Extend TCPDF class to create custom header
class MYPDF extends TCPDF { 
    // Header image path
    public $header_image = 'images/logosareport.png';

    // Header content
    public function Header() {
        // Set header image
        if (!empty($this->header_image)) {
            $image = $this->header_image;
            
            // Get the dimensions of the image
            $imageData = getimagesize($image);
            $imageWidth = 80; // Fixed width as in your code
            $imageHeight = $imageWidth * ($imageData[1] / $imageData[0]); // Calculate height to maintain aspect ratio
            
            // Center the image horizontally and place it at the top
            $x = (($this->getPageWidth() - $imageWidth) / 2);
            $y = 10; // Small padding from the top
            
            // Draw the image
            $this->Image($image, $x, $y, $imageWidth, $imageHeight, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            
            // Set the top margin to be just below the image
            $this->SetTopMargin($y + $imageHeight + 10); // 10 is extra padding
        }
    }
}

// Create a new TCPDF object    
$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// ... [document information and database connection code remains the same] ...

// Add a new page
$pdf->AddPage();

// The content will start at the position set by SetTopMargin

// Set font
$pdf->SetFont('helvetica', 'B', 16);

// Add table header
$pdf->Cell(0, 10, 'Critical Stock Items Report', 0, 1, 'C');

// Add some space and set normal font
$pdf->Ln(5);
$pdf->SetFont('helvetica', '', 12);

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "clbc_inventory";
$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Query to select products with stock 3 or below
$sql = "SELECT category, product_name, stocks FROM inventory_data WHERE stocks <= 3";
$result = $connection->query($sql);
if (!$result) {
    die("Invalid Query: " . $connection->error);
}


// Add table headers
$pdf->Cell(80, 10, 'Category', 1, 0, 'C');
$pdf->Cell(80, 10, 'Product', 1, 0, 'C');
$pdf->Cell(30, 10, 'Current Stock', 1, 1, 'C');

// Add table data
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(80, 10, $row['category'], 1, 0, 'C');
    $pdf->Cell(80, 10, $row['product_name'], 1, 0, 'L');
    $pdf->Cell(30, 10, $row['stocks'], 1, 1, 'C');
}

// Close the database connection
$connection->close();

// Output the PDF file
$pdf->Output('critical_stock_items_report.pdf', 'I');
?>