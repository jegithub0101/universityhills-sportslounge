<?php
require('fpdf/fpdf.php'); // Include FPDF library
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

//Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);


// Function to check if a user is logged in
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

// Redirect to login page if not logged in
if (!isLoggedIn()) {
    header("Location: admin-login.php");
    exit;
}

if (isset($_POST['logout'])) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to login page or wherever you want
    header("Location: admin-login.php");
    exit();
}

class PDF extends FPDF
{
    // Page header
    function Header()
{
    // Path to your logo
    $logoPath = 'Pic/logo.png'; // Replace with your actual logo path
    
    // Add the logo (x = 10, y = 6, width = 30)
    $this->Image($logoPath, 10, 6, 30);
    
    // Set font for the company name
    $this->SetFont('Arial', 'B', 16);
    
    // Move to the right to center the company name
    $this->Cell(80);
    
    // Add the company name (centered)
    $this->Cell(30, 10, 'Company Name', 0, 1, 'C');
    
    // Line break for spacing between the company name and "Sales Report"
    $this->Ln(1);
    
    // Set font for the "Sales Report" text
    $this->SetFont('Arial', 'I', 12);
    
    // Move to the center again and add "Sales Report"
    $this->Cell(80);
    $this->Cell(30, 10, 'Sales Report', 0, 1, 'C');
    
    // Line break to move the rest of the content down
    $this->Ln(5);
}


    // Page footer
    function Footer()
    {
        // Go to 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    // Load data
    function LoadData($sql)
    {
        global $connection;
        $result = $connection->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              
                $data[] = $row;
            }
        }
        return $data;
    }


    function SalesTable($header, $data)
{
    // Determine column widths based on the number of columns
    $w = array(); // Initialize column width array

    // Set widths dynamically based on headers
    switch (count($header)) {
        case 2: // For two-column tables (Product report)
            $w = array(80, 40); // Increase width for Product Name, reduce for Quantity Sold
            break;
        case 3: // For three-column tables (Sales report)
            $w = array(80, 60, 30); // Increase width for Date/Product
            break;
        default:
            echo "Invalid number of headers.";
            return;
    }

    // Print the table headers
    for ($i = 0; $i < count($header); $i++) {
        $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
    }
    $this->Ln(); // New line after header

    // Print the data dynamically based on headers
    foreach ($data as $row) {
        if (isset($row['product_name']) && isset($row['qty'])) {
            // Handle product report scenario
            $this->Cell($w[0], 6, $row['product_name'], 1); // Wider product_name column
            $this->Cell($w[1], 6, $row['qty'], 1, 0, 'C'); // Quantity column
        } elseif (isset($row['date']) && isset($row['totalprice'])) {
            // Handle sales report scenario
            $this->Cell($w[0], 6, $row['date'], 1); // Wider date column
            $this->Cell($w[1], 6, 'Php. ' . number_format($row['totalprice'], 2), 1);
        } else {
            echo "Data structure doesn't match expected format.";
            return;
        }
        $this->Ln(); // New line after each row
    }
}


    
    
}

// Instantiate PDF object
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Yearly Sales
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Yearly Sales', 0, 1);
$pdf->SetFont('Arial', '', 12);

$sql_yearly = "SELECT YEAR(date) AS date, ROUND(SUM(totalprice),2) AS totalprice
               FROM overall_payment
               WHERE YEAR(date) = YEAR(CURDATE())
               GROUP BY YEAR(date)";
$yearly_data = $pdf->LoadData($sql_yearly);
$pdf->SalesTable(['Year', 'Total Sales'], $yearly_data);
// add new line space 
$pdf->Ln(5);
// Monthly Sales
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Monthly Sales', 0, 1);
$pdf->SetFont('Arial', '', 12);

$sql_monthly = "SELECT MONTHNAME(date) AS date, ROUND(SUM(totalprice),2) AS totalprice
               FROM overall_payment
               GROUP BY MONTH(date)
               ORDER BY MONTH(date)";
$monthly_data = $pdf->LoadData($sql_monthly);
$pdf->SalesTable(['Month', 'Total Sales'], $monthly_data);
$pdf->Ln(5);
// Product Sales
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Product Sales', 0, 1);
$pdf->SetFont('Arial', '', 12);
$sql_product = "SELECT product_name as product_name, SUM(quantity) as qty  
                FROM product_payment
                GROUP BY product_name
                ORDER BY SUM(quantity) DESC";
$product_data = $pdf->LoadData($sql_product);
$pdf->SalesTable(['Product', 'Quantity Sold'], $product_data);

// Output the PDF
$pdf_filename_date_timestamp = date('Y-m-d_H-i-s');
$pdf_filename = 'sales_report_' . $pdf_filename_date_timestamp . '.pdf';
$pdf->Output('D', $pdf_filename); // 'D' for download

?>
