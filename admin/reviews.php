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


<?php
if ($_SESSION['role'] === 'Admin') {
?>
<div class="col-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Reviews</h3>
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
            <th>User</th>
            <th>Designer</th>
            <th>Review</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT 
          CONCAT(reviewer.first_name, ' ', reviewer.last_name) AS reviewer_full_name,
          CONCAT(designer.first_name, ' ', designer.last_name) AS designer_full_name,
          designer.profile_photo AS designer_profile_photo,
          r.comment
      FROM reviews r
      JOIN users reviewer ON r.user_id = reviewer.user_id
      JOIN users designer ON r.designer_id = designer.user_id";   
      
          $result = $con->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
          ?>
          <tr>
            <td><?php echo $row["reviewer_full_name"]; ?></td>
            <td><?php echo $row["designer_full_name"]; ?></td>
            <td><?php echo $row["comment"]; ?></td>
            
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
}
?>

<?php
if ($_SESSION['role'] === 'Designer') {
?>
<div class="col-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Your Reviews</h3>
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
            <th>User</th>
            <th>Review</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $designer_id = $_SESSION['user_id']; // Assuming the designer's user ID is stored in the session

          $sql = "SELECT 
                    CONCAT(reviewer.first_name, ' ', reviewer.last_name) AS reviewer_full_name,
                    CONCAT(designer.first_name, ' ', designer.last_name) AS designer_full_name,
                    designer.profile_photo AS designer_profile_photo,
                    r.comment
                FROM reviews r
                JOIN users reviewer ON r.user_id = reviewer.user_id
                JOIN users designer ON r.designer_id = designer.user_id
                WHERE designer.user_id = $designer_id";
          
      
          $result = $con->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
          ?>
          <tr>
            <td><?php echo $row["reviewer_full_name"]; ?></td>
            <td><?php echo $row["comment"]; ?></td>
            
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
}
?>

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
