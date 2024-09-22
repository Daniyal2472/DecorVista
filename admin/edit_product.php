<?php
include 'includes/header.php';

if ($_SESSION['role'] === 'User') {
    echo "<script>
        alert('You are not authorized to access this page.\\nPlease login as Admin or Designer.');
        window.location.href = '/DecorVista/decorvista/login.php';
    </script>";
    exit();
}
if (!isset($_SESSION['role'])) {
    echo "<script>
        alert('Please register to access this page.');
        window.location.href = '/DecorVista/decorvista/register.php';
    </script>";
    exit();
}

if ($_SESSION['role'] === 'Admin') {

// Fetch product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch existing product data
$sql = "SELECT p.product_id, p.product_name, p.category_id, p.price, p.description, p.image_url, c.category_name 
        FROM products p 
        JOIN categories c ON p.category_id = c.category_id 
        WHERE p.product_id = '$product_id'";
$result = $con->query($sql);
$product = $result->fetch_assoc();

if (!$product) {
    echo "Product not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = mysqli_real_escape_string($con, $_POST['product_name']);
    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $image_url = $product['image_url']; // Keep existing image if no new image is uploaded

    // Check if a new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $image_name = basename($_FILES['image']['name']);
        $image_path = 'uploads/products/' . $image_name;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            $image_url = $image_path;
        } else {
            echo "<script>alert('Failed to upload image.');</script>";
        }
    }

    $sql = "UPDATE `products` SET 
                `product_name`='$product_name', 
                `category_id`='$category_id', 
                `price`='$price', 
                `description`='$description', 
                `image_url`='$image_name' 
            WHERE `product_id`='$product_id'";

    if ($con->query($sql) === TRUE) {
        echo "<script>window.location.href='products.php';</script>";
    } else {
        echo "<script>alert('Error: " . $con->error . "');</script>";
    }
}
?>

<div class="card card-primary col-12">
    <div class="card-header">
        <h3 class="card-title">Edit Product</h3>
    </div>
    <form method="POST" enctype="multipart/form-data">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="product_name">Product Name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $product['product_name']; ?>" required>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <?php
                            // Fetch categories
                            $sql = "SELECT * FROM `categories`";
                            $categories = $con->query($sql);
                            while ($category = $categories->fetch_assoc()) {
                                $selected = $category['category_id'] == $product['category_id'] ? 'selected' : '';
                                echo "<option value='{$category['category_id']}' $selected>{$category['category_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-sm-6">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>" required>
                </div>
                <div class="form-group col-sm-6">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" required><?php echo $product['description']; ?></textarea>
                </div>
                <div class="form-group col-sm-6">
                    <label for="image">Image</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                    <?php if ($product['image_url']) : ?>
                        <p>Leave unchanged to keep the same image.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update Product</button>
        </div>
    </form>
</div>

<?php
include 'includes/footer.php';
                    }
?>
