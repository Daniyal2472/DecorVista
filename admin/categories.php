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
      window.location.href = '/DecorVista/decorvista/login.php';
  </script>";
  exit();
}

if ($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Designer') {
?>

<div class="col-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Categories</h3>
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
            <th>Category ID</th>
            <th>Category name</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM `categories` ORDER BY `category_id` ASC";
          $result = $con->query($sql);

          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
          ?>
          <tr>
            <td><?php echo $row["category_id"]; ?></td>
            <td><?php echo $row["category_name"]; ?></td>
            <td>
              <div class="btn-group">
                <button type="button" class="btn btn-default">Action</button>
                <button type="button" class="btn btn-default dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu" role="menu">
                <a class="dropdown-item" href="edit_category.php?id=<?php echo $row['category_id']; ?>">Edit</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="categories.php?delete_id=<?php echo $row['category_id']; ?>">Delete</a>
                </div>
              </div>
            </td>
          </tr>
          <?php
            }
          } else {
            echo "No Category found";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="card card-primary col-12">
  <div class="card-header">
    <h3 class="card-title">Add Category</h3>
  </div>
  <form method="POST" onsubmit="return validateForm();">
    <div class="card-body">
        <div class="form-group">
          <label for="category_name">Category name</label>
          <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter category name" required>
        </div>
    </div>
    <div class="card-footer">
    <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
    </div>
  </form>
</div>

<?php
if (isset($_POST['add_category'])) {
    // Get the category name from the form input
    $category_name = mysqli_real_escape_string($con, $_POST['category_name']);

    // Check if the category already exists
    $checkCategory = "SELECT * FROM `categories` WHERE `category_name` = '$category_name'";
    $checkResult = $con->query($checkCategory);

    if ($checkResult->num_rows > 0) {
        echo "<script>alert('Category already exists');</script>";
    } else {
        // Insert query to add the category
        $sql = "INSERT INTO `categories` (`category_name`) VALUES ('$category_name')";

        if ($con->query($sql) === TRUE) {
            echo "<script>window.location.href='categories.php';</script>";
        } else {
            echo "<script>alert('Error: " . $con->error . "');</script>";
        }
    }
}


// Check if 'delete_id' is set in the URL
if (isset($_GET['delete_id'])) {
    $category_id = intval($_GET['delete_id']); // Sanitize input
  
    // SQL query to delete the user
    $deleteQuery = "DELETE FROM `categories` WHERE `category_id` = $category_id";
  
    if ($con->query($deleteQuery) === TRUE) {
      echo "<script>alert('Category deleted successfully');</script>";
      echo "<script>window.location.href='categories.php';</script>"; // Redirect to refresh the page
    } else {
      echo "<script>alert('Error deleting user: " . $con->error . "');</script>";
    }
  }
include 'includes/footer.php';
}
?>