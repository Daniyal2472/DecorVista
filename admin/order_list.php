<?php
include 'includes/header.php'; // Ensure this path is correct
ob_start();

// Check if the user is logged in and if the role is set
if (isset($_SESSION['role']) && ($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Designer')) {

    // If PDF download is requested
    if (isset($_GET['download']) && $_GET['download'] === 'pdf') {
        require('./fpdf186/fpdf.php');

        // Create PDF object
        $pdf = new FPDF();
        $pdf->AddPage();

        // Set font for the PDF header
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190, 10, 'Order Slip', 0, 1, 'C');
        $pdf->Ln(5); // Line break

        // Set font for general information
        $pdf->SetFont('Arial', '', 12);

        // Fetch order data from the database
        $sql = "SELECT o.order_id, CONCAT(u.first_name, ' ', u.last_name) AS user_full_name, p.product_name, o.product_price, o.order_date 
                FROM orders o
                JOIN users u ON o.user_id = u.user_id
                JOIN products p ON o.product_id = p.product_id";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Display each order as an order slip
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(40, 10, 'Order ID:', 0, 0);
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(50, 10, $row['order_id'], 0, 1);
                
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(40, 10, 'User:', 0, 0);
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(50, 10, $row['user_full_name'], 0, 1);

                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(40, 10, 'Product:', 0, 0);
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(50, 10, $row['product_name'], 0, 1);

                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(40, 10, 'Price:', 0, 0);
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(50, 10, '$' . number_format($row['product_price'], 2), 0, 1);

                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(40, 10, 'Order Date:', 0, 0);
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(50, 10, date('Y-m-d', strtotime($row['order_date'])), 0, 1);
                
                $pdf->Ln(10); // Add space between orders
            }
        } else {
            $pdf->Cell(190, 10, 'No orders found', 0, 1, 'C');
        }

        // Output PDF as a download
        $pdf->Output('D', 'order_slip.pdf'); // 'D' forces download
        ob_end_flush(); // Send output to browser
        exit(); // Stop further execution
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order List</title>
    <link rel="stylesheet" href="path/to/your/bootstrap.css">
    <link rel="stylesheet" href="path/to/fontawesome.css">
</head>
<body>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?php echo ($_SESSION['role'] === 'Designer') ? 'Your Orders' : 'All Orders'; ?></h3>
            <div class="card-tools">
                <!-- PDF Download Button -->
                <a href="order_list.php?download=pdf" class="btn btn-danger" style="margin-right: 10px;">
                    <i class="fas fa-file-pdf"></i> Download PDF
                </a>
            </div>
        </div>
        <div class="card-body table-responsive p-0" style="height: 300px;">
            <table class="table table-head-fixed text-nowrap">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Fetch order data for display in the table
                $sql = "SELECT o.order_id, CONCAT(u.first_name, ' ', u.last_name) AS user_full_name, p.product_name, o.product_price, o.order_date 
                        FROM orders o
                        JOIN users u ON o.user_id = u.user_id
                        JOIN products p ON o.product_id = p.product_id";
                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row['order_id']; ?></td>
                            <td><?php echo $row['user_full_name']; ?></td>
                            <td><?php echo $row['product_name']; ?></td>
                            <td><?php echo '$' . number_format($row['product_price'], 2); ?></td>
                            <td><?php echo date('Y-m-d', strtotime($row['order_date'])); ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">No orders found</td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
<?php
} else {
    echo "Unauthorized access!";
}
?>
