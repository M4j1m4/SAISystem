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
            $imageWidth = 80; // Fixed width
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

// Set document information
$pdf->SetCreator('CLARKLANE');
$pdf->SetAuthor('Clarklane Bicycle Center');
$pdf->SetTitle('Sales Report');
$pdf->SetSubject('Sales Data');

// Remove default footer
$pdf->setPrintFooter(false);

// Add a new page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', 'B', 16);

// Add report title
$pdf->Cell(0, 10, 'Sales Report', 0, 1, 'C');

// Add date range
$start_date = isset($_GET['start-date']) ? $_GET['start-date'] : date('Y-m-d', strtotime('-1 week'));
$end_date = isset($_GET['end-date']) ? $_GET['end-date'] : date('Y-m-d');
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, "Date Range: $start_date to $end_date", 0, 1, 'C');

// Add some space and set normal font
$pdf->Ln(5);
$pdf->SetFont('helvetica', '', 12);

// Add table headers
$pdf->SetFillColor(200, 220, 255); // Light blue
$pdf->Cell(40, 10, 'Category', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Product Name', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Quantity', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Price', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Date', 1, 1, 'C', true);

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "clbc_inventory";
$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Format start and end dates for timestamp comparison
$start_timestamp = $start_date . ' 00:00:00';
$end_timestamp = $end_date . ' 23:59:59';

// Query to fetch sales data within the date range
$sql = "SELECT category, product_name, quantity, price, date FROM sales_report WHERE quantity > 0 AND date BETWEEN '$start_timestamp' AND '$end_timestamp'";

// Add category filter if provided
if (!empty($_GET['category'])) {
    $category = $_GET['category'];
    $sql .= " AND category = '$category'";
}

// Add search filter if provided
if (!empty($_GET['search'])) {
    $search = $_GET['search'];
    $sql .= " AND (category LIKE '%$search%' OR product_name LIKE '%$search%')";
}

// Order by date in descending order
$sql .= " ORDER BY date DESC";

$result = $connection->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        // Change font size to 14 for category column
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Cell(40, 10, $row["category"], 1, 0, 'C');

        // Reset font size to 12 for other columns
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(60, 10, $row["product_name"], 1, 0, 'L');
        $pdf->Cell(30, 10, $row["quantity"], 1, 0, 'C');
        $pdf->Cell(30, 10, '' . number_format($row["price"], 2), 1, 0, 'R');
        $pdf->Cell(30, 10, date('Y-m-d', strtotime($row["date"])), 1, 1, 'C');
    }
} else {
    $pdf->Cell(0, 10, 'No data found', 1, 1, 'C');
}

// Close connection
$connection->close();

// Output the PDF file
$pdf->Output('sales_report.pdf', 'I');
?>