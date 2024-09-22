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

?>

<div class="col-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Users</h3>
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
            <th>Profile Pic</th>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Full Name</th>
            <th>Contact No.</th>
            <th>Created at</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM users WHERE role='User'";
          $result = $con->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
          ?>
          <tr>
            <td>
              <?php if (!empty($row["profile_photo"])): ?>
                <img src="uploads/profile_pictures/<?php echo $row["profile_photo"]; ?>" alt="Profile Pic" style="width: 50px; height: 50px;">
              <?php else: ?>
                <img src="uploads/default.png" alt="Default Pic" style="width: 50px; height: 50px;">
              <?php endif; ?>
            </td>
            <td><?php echo $row["user_id"]; ?></td>
            <td><?php echo $row["username"]; ?></td>
            <td><?php echo $row["email"]; ?></td>
            <td><?php echo $row["first_name"]; ?> <?php echo $row["last_name"]; ?></td>
            <td><?php echo $row["contact"]; ?></td>
            <td><?php echo $row["created_at"]; ?></td>
            <td>
              <div class="btn-group">
                <button type="button" class="btn btn-default">Action</button>
                <button type="button" class="btn btn-default dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu" role="menu">
                  <a class="dropdown-item" href="edit_user.php?id=<?php echo $row['user_id']; ?>">Edit</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="users.php?delete_id=<?php echo $row['user_id']; ?>">Delete</a>
                </div>
              </div>
            </td>
          </tr>
          <?php
            }
          } else {
          ?>
          <tr>
            <td colspan="8" class="text-center">No users found</td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>



<?php
// Check if 'delete_id' is set in the URL
if (isset($_GET['delete_id'])) {
  $user_id = intval($_GET['delete_id']); // Sanitize input

  // SQL query to delete the user
  $deleteQuery = "DELETE FROM `users` WHERE `user_id` = $user_id";

  if ($con->query($deleteQuery) === TRUE) {
    echo "<script>alert('User deleted successfully');</script>";
    echo "<script>window.location.href='users.php';</script>"; // Redirect to refresh the page
  } else {
    echo "<script>alert('Error deleting user: " . $con->error . "');</script>";
  }
}

include 'includes/footer.php';
}
?>
