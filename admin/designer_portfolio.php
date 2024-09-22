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

if ($_SESSION['role'] === 'Designer') {
    if (isset($_POST['add_design'])) {
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $category_id = intval($_POST['category_id']);
        $description = mysqli_real_escape_string($con, $_POST['description']);

        // Handle file upload
        $image_url = '';
        if (isset($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "uploads/portfolio_images/"; // Update to the gallery directory
            // Ensure the directory exists
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
            }
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $image_url = basename($_FILES["image"]["name"]);

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // File is successfully uploaded
            } else {
                echo "<script>alert('Error uploading file.');</script>";
            }
        }

        // Insert query to add the design
        $sql = "INSERT INTO `designer_portfolio`(`title`, `category_id`, `description`, `image`,`user_id`) VALUES ('$title', '$category_id', '$description', '$image_url', '".$_SESSION['user_id']."')";

        if ($con->query($sql) === TRUE) {
            echo "<script>window.location.href='designer_portfolio.php';</script>";
        } else {
            echo "<script>alert('Error: " . $con->error . "');</script>";
        }
    }
?>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Your Portfolio</h3>
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
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" style="height: 300px;">
            <table class="table table-head-fixed text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Category Name</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                      $user_id = $_SESSION['user_id'];
                    $sql = "SELECT 
        dp.id AS ID, 
        dp.title AS Title, 
        dp.description AS Description, 
        c.category_name AS Category_Name, 
        dp.image AS Image
    FROM 
        designer_portfolio dp
    LEFT JOIN 
        categories c 
    ON 
        dp.category_id = c.category_id
    WHERE 
        dp.user_id = '$user_id';
"; // Adjust if necessary based on your categories table structure

                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row["ID"]; ?></td>
                        <td><?php echo $row["Title"]; ?></td>
                        <td><?php echo $row["Description"]; ?></td>
                        <td><?php echo $row["Category_Name"]; ?></td>
                        <td><img src="uploads/portfolio_images/<?php echo $row["Image"]; ?>" alt="Image" style="width: 100px; height: auto;"></td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default">Action</button>
                                <button type="button" class="btn btn-default dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="edit_portfolio.php?id=<?php echo $row['ID']; ?>">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="designer_portfolio.php?delete_id=<?php echo $row['ID']; ?>">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>

<div class="card card-primary col-12">
    <div class="card-header">
        <h3 class="card-title">Add Design</h3>
    </div>
    <form method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter design title" required>
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
                                echo "<option value='' disabled>No categories found</option>";
                            }
                            ?>
                        </select>
                    </div>
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
            <button type="submit" name="add_design" class="btn btn-primary">Add Design</button>
        </div>
    </form>
</div>

<?php
if (isset($_GET['delete_id'])) {
    $product_id = intval($_GET['delete_id']); // Sanitize input

    // SQL query to delete the user
    $deleteQuery = "DELETE FROM `designer_portfolio` WHERE `id` = $product_id";

    if ($con->query($deleteQuery) === TRUE) {
        // Directly redirect after deletion without confirmation
        echo "<script>window.location.href='designer_portfolio.php';</script>";
        exit(); // Ensure no further code is executed
    } else {
        echo "<script>alert('Error deleting item: " . $con->error . "');</script>";
    }
}

include 'includes/footer.php';
}
?>
