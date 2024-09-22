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

if ($_SESSION['role'] === 'Admin' && isset($_GET['id'])) {
    $id = intval($_GET['id']); // Get the ID from the URL and sanitize it

    // Fetch the gallery record from the database
    $sql = "SELECT * FROM `inspiration_gallery` WHERE `inspiration_id` = $id";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $category_id = $row['category']; // Assuming category ID is stored
        $description = $row['description'];
        $image_url = $row['image_url'];
    } else {
        echo "<script>alert('No record found');</script>";
        echo "<script>window.location.href='inspiration_gallery.php';</script>";
        exit();
    }

    if (isset($_POST['update_picture'])) {
        $product_title = mysqli_real_escape_string($con, $_POST['product_title']);
        $category_id = intval($_POST['category_id']);
        $description = mysqli_real_escape_string($con, $_POST['description']);

        // Handle file upload
        $image_url = $row['image_url']; // Default to existing image
        if (isset($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "uploads/gallery/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $image_url = basename($_FILES["image"]["name"]);
            
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // File uploaded successfully
            } else {
                echo "<script>alert('Error uploading file.');</script>";
            }
        }

        // Update query
        $sql = "UPDATE `inspiration_gallery` 
                SET `title` = '$product_title', `category` = '$category_id', `description` = '$description', `image_url` = '$image_url'
                WHERE `inspiration_id` = $id";
        
        if ($con->query($sql) === TRUE) {
            echo "<script>alert('Record updated successfully');</script>";
            echo "<script>window.location.href='inspiration_gallery.php';</script>";
        } else {
            echo "<script>alert('Error: " . $con->error . "');</script>";
        }
    }
?>

<div class="card card-primary col-12">
    <div class="card-header">
        <h3 class="card-title">Edit Picture</h3>
    </div>
    <form method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="product_title">Title</label>
                    <input type="text" class="form-control" id="product_title" name="product_title" value="<?php echo $title; ?>" required>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="" disabled>Select category</option>
                            <?php
                            $sql = "SELECT * FROM `categories`";
                            $result = $con->query($sql);

                            if ($result->num_rows > 0) {
                                while ($category_row = $result->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $category_row['category_id']?>" <?php echo ($category_row['category_id'] == $category_id) ? 'selected' : ''; ?>>
                                <?php echo $category_row['category_name']; ?>
                            </option>
                            <?php
                                }
                            } else {
                                echo "<option value='' disabled>No categories found</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-sm-6">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" required><?php echo $description; ?></textarea>
                </div>
                <div class="form-group col-sm-6">
                    <label for="image">Image</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                    <img src="uploads/gallery/<?php echo $image_url; ?>" alt="Current Image" width="100">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" name="update_picture" class="btn btn-primary">Update Picture</button>
        </div>
    </form>
</div>

<?php
include 'includes/footer.php';
}
?>
