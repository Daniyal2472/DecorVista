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

if ($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Designer') {



// Handle form submission for adding a new product
if (isset($_POST['add_product'])) {
    $product_name = mysqli_real_escape_string($con, $_POST['product_name']);
    $category_id = intval($_POST['category_id']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    // Handle file upload
    $image_url = '';
if (isset($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $target_dir = "uploads/products/"; // Update to the products directory inside uploads
    
    // Check if the directory exists, if not, create it
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
    }
    
    // Set the target file path
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $image_url = basename($_FILES["image"]["name"]); // Store the image file name

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // File is successfully uploaded
    } else {
        echo "<script>alert('Error uploading file.');</script>";
    }
}


    // Insert query to add the product
    $sql = "INSERT INTO `products` (`product_name`, `category_id`, `price`, `description`, `image_url`) 
            VALUES ('$product_name', '$category_id', '$price', '$description', '$image_url')";

    if ($con->query($sql) === TRUE) {
        echo "<script>window.location.href='products.php';</script>";
    } else {
        echo "<script>alert('Error: " . $con->error . "');</script>";
    }
}
?>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Products</h3>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive p-0" style="height: 300px;">
            <table class="table table-head-fixed text-nowrap">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Category Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Image URL</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT p.product_id, p.product_name, c.category_name, c.category_id, p.price, p.description, p.image_url 
                            FROM products p 
                            JOIN categories c ON p.category_id = c.category_id ORDER BY `product_id` ASC";
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row["product_id"]; ?></td>
                        <td><?php echo $row["product_name"]; ?></td>
                        <td><?php echo $row["category_name"]; ?></td>
                        <td><?php echo $row["price"]; ?></td>
                        <td><?php echo $row["description"]; ?></td>
                        <td><img src="uploads/products/<?php echo $row["image_url"]; ?>" alt="Image" style="width: 100px; height: auto;"></td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default">Action</button>
                                <button type="button" class="btn btn-default dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="edit_product.php?id=<?php echo $row['product_id']; ?>">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="products.php?delete_id=<?php echo $row['product_id']; ?>">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='7'>No Products found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card card-primary col-12">
    <div class="card-header">
        <h3 class="card-title">Add Product</h3>
    </div>
    <form method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="product_name">Product name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter product name" required>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="" disabled selected>Select category</option>
                            <?php
                            $sql = "SELECT * FROM `categories`";
                            $result = $con->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $row['category_id']?>"><?php echo $row['category_name']?></option>
                            <?php
                                }
                            } else {
                                echo "No categories found";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-sm-6">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" id="price" name="price" placeholder="Enter price" required>
                </div>
                <div class="form-group col-sm-6">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" placeholder="Enter description" required></textarea>
                </div>
                <div class="form-group col-sm-6">
                    <label for="image">Image</label>
                    <input type="file" class="form-control-file" id="image" name="image" required>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
        </div>
    </form>
</div>

<?php
// Check if 'delete_id' is set in the URL
if (isset($_GET['delete_id'])) {
    $product_id = intval($_GET['delete_id']); // Sanitize input
  
    // SQL query to delete the user
    $deleteQuery = "DELETE FROM `products` WHERE `product_id` = $product_id";
  
    if ($con->query($deleteQuery) === TRUE) {
        echo "<script>alert('Product deleted successfully');</script>";
        echo "<script>window.location.href='products.php';</script>"; // Redirect to refresh the page
    } else {
        echo "<script>alert('Error deleting user: " . $con->error . "');</script>";
    }
}

include 'includes/footer.php';
}

?>
