<?php
// Include database connection
include("header.php"); // Your database connection file

if ($_SESSION['role'] !== 'User') {
    echo "<script>
    window.location.href = 'login.php';
    </script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$total_price = 0;

// Check if a delete request is made
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = intval($_GET['id']);
    
    // Prepare and execute the delete statement
    $deleteQuery = "DELETE FROM `cart` WHERE `product_id` = ? AND `user_id` = ?";
    $stmt = $con->prepare($deleteQuery);
    $stmt->bind_param("ii", $product_id, $user_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Product removed from your cart!');</script>";
    } else {
        echo "<script>alert('Failed to remove product from cart.');</script>";
    }
    $stmt->close();
}

// Proceed to checkout logic
if (isset($_POST['checkout'])) {
    // Fetch cart products
    $cartQuery = "SELECT p.product_name, p.image_url, p.price, c.product_id 
                  FROM cart c 
                  JOIN products p ON c.product_id = p.product_id 
                  WHERE c.user_id = ?";
    $stmt = $con->prepare($cartQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cartResult = $stmt->get_result();

    // Insert cart products into orders
    while ($row = $cartResult->fetch_assoc()) {
        $product_id = $row['product_id'];
        $product_image = $row['image_url'];
        $product_price = $row['price'];
        $quantity = 1; // Adjust as per your requirement

        // Insert into orders table with payment method
        $payment_method = $_POST['payment_method']; // Fetch payment method
        $orderQuery = "INSERT INTO orders (user_id, product_id, product_image, product_price, quantity, payment_method) 
                       VALUES (?, ?, ?, ?, ?, ?)";
        $orderStmt = $con->prepare($orderQuery);
        $orderStmt->bind_param("iisdis", $user_id, $product_id, $product_image, $product_price, $quantity, $payment_method);
        $orderStmt->execute();
        $orderStmt->close();
    }

    // Clear the user's cart after placing the order
    $clearCartQuery = "DELETE FROM cart WHERE user_id = ?";
    $stmt = $con->prepare($clearCartQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    // Redirect to order confirmation or a thank-you page
    echo "<script>alert('Your order has been placed successfully!'); window.location.href='index.php';</script>";
}

// Fetch products in the cart
$query = "SELECT p.product_name, p.image_url, p.price, c.product_id 
          FROM cart c 
          JOIN products p ON c.product_id = p.product_id 
          WHERE c.user_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- Include Bootstrap CSS -->
    <style>
        .heading {
            font-size: 2rem;
            color: black;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .product-image {
            max-width: 70px;
            height: auto;
            border-radius: 8px;
        }

        .table-shopping-cart th, .table-shopping-cart td {
            vertical-align: middle;
        }

        .order-summary {
            background: #f9f9f9;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        .pay-now-button {
            background-color: black;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .pay-now-button:hover {
            background-color: #bfa26b;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<div class="cart-container">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9">
                <div class="heading">Your Shopping Cart</div>
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-borderless table-shopping-cart">
                            <thead class="text-muted">
                            <tr class="small text-uppercase">
                                <th scope="col">Product</th>
                                <th scope="col" width="120">Price</th>
                                <th scope="col" width="100" class="text-right"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($row = $result->fetch_assoc()) {
                                $total_price += $row['price'];
                                ?>
                                <tr>
                                    <td>
                                        <figure class="itemside">
                                            <div class="aside">
                                                <img src="../admin/uploads/products/<?php echo $row['image_url']; ?>" class="product-image">
                                            </div>
                                            <figcaption class="info">
                                                <a href="#" class="title text-dark"><?php echo htmlspecialchars($row['product_name']); ?></a>
                                            </figcaption>
                                        </figure>
                                    </td>
                                    <td>
                                        <div class="price-wrap">PKR: <?php echo number_format($row['price'], 2); ?></div>
                                    </td>
                                    <td class="text-right">
                                        <a href="cart.php?id=<?php echo $row['product_id']; ?>" class="btn btn-light">Remove</a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="order-summary">
                    <h3>Order Summary</h3>
                    <dl class="dlist-align">
                        <dt>Total price:</dt>
                        <dd class="text-right">PKR: <?php echo number_format($total_price, 2); ?></dd>
                    </dl>
                    <hr>
                    <form method="POST" action="">
                        <h5>Select Payment Method:</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="cash_on_delivery" value="cash_on_delivery" required>
                            <label class="form-check-label" for="cash_on_delivery">
                                Cash on Delivery
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                            <label class="form-check-label" for="bank_transfer">
                                Bank Transfer
                            </label>
                        </div>

                        <!-- Hidden section for bank transfer details -->
                        <div id="bank_details" style="display:none; margin-top: 10px;">
                            <p><strong>Bank Account Number:</strong> 1234-5678-9012-3456</p>
                            <p><strong>Email:</strong> example@example.com</p>
                            <p>Transfer the money and send a screenshot to the above email address.</p>
                        </div>

                        <button type="submit" name="checkout" class="btn btn-primary pay-now-button">Proceed to Checkout</button>
                    </form>
                    <a href="category.php" class="btn btn-success mt-2">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    // Show bank details when Bank Transfer is selected
    document.getElementById('bank_transfer').addEventListener('change', function () {
        document.getElementById('bank_details').style.display = 'block';
    });

    // Hide bank details when Cash on Delivery is selected
    document.getElementById('cash_on_delivery').addEventListener('change', function () {
        document.getElementById('bank_details').style.display = 'none';
    });
</script>
</html>
