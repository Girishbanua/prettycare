<?php
include "../includes/db.php";
$cart = $_SESSION['cart'];
$checkout = $_SESSION['checkout'];

foreach ($cart as $product_id => $quantity) {
    $result = mysqli_query($conn, "SELECT * FROM products WHERE productID = $product_id");
    $product = mysqli_fetch_assoc($result);

    $name = $product['productname'];
    $price = $product['productRate'];
}


require('../fpdf/fpdf.php');

class PDF extends FPDF
{
    // Header
    function Header()
    {
        // Logo
        $this->Image('../images/logo.png', 10, 6, 30);

        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, 'Beauty Products Store', 0, 1, 'C');
        $this->Ln(5);
    }

    // Footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Thank you for shopping with us!', 0, 0, 'C');
    }
}

// Create PDF
$pdf = new PDF();
$pdf->AddPage();



// Dummy Data (Replace with DB data)
$invoice_no = "INV001";
$date = date("d-m-Y");
$customer_name = $checkout['name'] . " " . $checkout['lname'];

// Invoice Details
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 6, "Invoice #: $invoice_no", 0, 0);
$pdf->Cell(0, 6, "Date: $date", 0, 1);

$pdf->Cell(100, 6, "Customer: $customer_name", 0, 1);

$pdf->Ln(5);

// Table Header
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 10, 'Product', 1);
$pdf->Cell(30, 10, 'Price', 1);
$pdf->Cell(30, 10, 'Qty', 1);
$pdf->Cell(30, 10, 'Total', 1);
$pdf->Ln();

// Sample Cart Data (Replace with your session/db)
$cart = [
    ["name" => "Lipstick", "price" => 200, "qty" => 2],
    ["name" => "Face Wash", "price" => 150, "qty" => 1],
];

$total = 0;

// Table Data
$pdf->SetFont('Arial', '', 12);
foreach ($cart as $item) {
    $line_total = $item['price'] * $item['qty'];
    $total += $line_total;

    $pdf->Cell(80, 10, $item['name'], 1);
    $pdf->Cell(30, 10, $item['price'], 1);
    $pdf->Cell(30, 10, $item['qty'], 1);
    $pdf->Cell(30, 10, $line_total, 1);
    $pdf->Ln();
}

// Summary
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(140, 10, 'Grand Total', 1);
$pdf->Cell(30, 10, $total, 1);

$pdf->Output();

// unset($_SESSION['cart']);
// unset($_SESSION['total']);
// unset($_SESSION['checkout']);
