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

// Fetch category ID from URL
$category_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update category logic
    $category_name = mysqli_real_escape_string($con, $_POST['category_name']);

    $sql = "UPDATE `categories` SET `category_name`='$category_name' WHERE `category_id`='$category_id'";

    if ($con->query($sql) === TRUE) {
        echo "<script>alert('Category updated successfully'); window.location.href='categories.php';</script>";
    } else {
        echo "<script>alert('Error: " . $con->error . "');</script>";
    }
}

// Fetch existing category data
$sql = "SELECT * FROM `categories` WHERE `category_id`='$category_id'";
$result = $con->query($sql);
$category = $result->fetch_assoc();

if (!$category) {
    echo "Category not found.";
    exit;
}
?>

<div class="card card-primary col-12">
  <div class="card-header">
    <h3 class="card-title">Edit Category</h3>
  </div>
  <form method="POST">
    <div class="card-body">
      <div class="form-group">
        <label for="category_name">Category Name</label>
        <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $category['category_name']; ?>" required>
      </div>
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Update</button>
    </div>
  </form>
</div>

<?php
include 'includes/footer.php';
}
?>
