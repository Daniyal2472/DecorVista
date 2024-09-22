<?php
include 'includes/header.php';

if ($_SESSION['role'] === 'User') {
    echo "<script>
    alert('You are not authorized to access this page.\nPlease login as Admin or Designer.');
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
if ($_SESSION['role'] === 'Designer') {
?>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Your Consultations</h3>
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
                        <th>Booking ID</th>
                        <th>User</th>
                        <th>Slot</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch consultations along with user and slot details
                    $sql = "
                    SELECT
                        c.designer_id,
                        c.booking_id, 
                        CONCAT(u.first_name, ' ', u.last_name) AS user, 
                        CONCAT(cs.slot_date, ' ', cs.start_time, ' - ', cs.end_time) AS slot, 
                        c.booking_date, 
                        c.status 
                    FROM 
                        consultations c 
                    JOIN 
                        users u ON c.user_id = u.user_id 
                    JOIN 
                        consultation_slots cs ON c.slot_id = cs.slot_id 
                    WHERE 
                        c.designer_id = '{$_SESSION['user_id']}'
                    ";
                    $result = $con->query($sql);
                    while ($slot = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $slot["booking_id"]; ?></td>
                        <td><?php echo $slot['user']; ?></td>
                        <td><?php echo $slot['slot']; ?></td>
                        <td><?php echo $slot['booking_date']; ?></td>
                        <td><?php echo $slot['status']; ?></td>
                        <td>
                            <?php
                            if ($slot['status'] === 'Pending approval') {
                            ?>
                                <form method="POST">
                                    <input type="hidden" name="booking_id" value="<?php echo $slot['booking_id']; ?>">
                                    <input type="hidden" name="status_action" value="update_status">
                                    <button type="submit" name="action" value="approve" class="btn btn-block btn-outline-success btn-xs">Approve</button>
                                    <button type="submit" name="action" value="disapprove" class="btn btn-block btn-outline-danger btn-xs">Disapprove</button>
                                </form>
                            <?php
                            } else if ($slot['status'] === 'Approved') {
                            ?>
                                <form method="POST">
                                    <input type="hidden" name="booking_id" value="<?php echo $slot['booking_id']; ?>">
                                    <input type="hidden" name="status_action" value="update_status">
                                    <button type="submit" name="action" value="disapprove" class="btn btn-block btn-outline-danger btn-xs">Disapprove</button>
                                </form>
                            <?php
                            } else if ($slot['status'] === 'Disapproved') {
                            ?>
                                <form method="POST">
                                    <input type="hidden" name="booking_id" value="<?php echo $slot['booking_id']; ?>">
                                    <input type="hidden" name="status_action" value="update_status">
                                    <button type="submit" name="action" value="approve" class="btn btn-block btn-outline-success btn-xs">Approve</button>
                                </form>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<?php
}
?>

<?php
if ($_SESSION['role'] === 'Admin') {
?>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Consultations</h3>
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
                        <th>Booking ID</th>
                        <th>User</th>
                        <th>Designer</th>
                        <th>Slot</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch consultations along with user and slot details
                    $sql = "
                    SELECT 
    c.booking_id AS 'Booking ID',
    CONCAT(u.first_name, ' ', u.last_name) AS 'User',
    CONCAT(d.first_name, ' ', d.last_name) AS 'Designer',
    CONCAT(cs.slot_date, ' ', cs.start_time, ' - ', cs.end_time) AS 'Slot',
    c.booking_date AS 'Date',
    c.status AS 'Status'
FROM 
    consultations c
JOIN 
    users u ON c.user_id = u.user_id
JOIN 
    users d ON c.designer_id = d.user_id
JOIN 
    consultation_slots cs ON c.slot_id = cs.slot_id;

                    ";
                    $result = $con->query($sql);
                    while ($slot = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $slot["Booking ID"]; ?></td>
                        <td><?php echo $slot['User']; ?></td>
                        <td><?php echo $slot['Designer']; ?></td>
                        <td><?php echo $slot['Slot']; ?></td>
                        <td><?php echo $slot['Date']; ?></td>
                        <td><?php echo $slot['Status']; ?></td>
                        
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<?php
}
?>

<?php
if (isset($_POST['status_action']) && $_POST['status_action'] === 'update_status') {
    // Get the booking_id, slot_id, and action from the form submission
    $booking_id = $_POST['booking_id'];
    $action = $_POST['action'];

    // Fetch the slot_id from the consultation for the booking being updated
    $slot_query = "SELECT slot_id FROM consultations WHERE booking_id = ?";
    $slot_stmt = $con->prepare($slot_query);
    $slot_stmt->bind_param("i", $booking_id);
    $slot_stmt->execute();
    $slot_stmt->bind_result($slot_id);
    $slot_stmt->fetch();
    $slot_stmt->close();

    // Determine the new status based on the action
    $new_status = '';
    $is_booked = 0;  // Default: slot not booked
    if ($action === 'approve') {
        $new_status = 'Approved';
        $is_booked = 1; // Slot is booked
    } else if ($action === 'disapprove') {
        $new_status = 'Disapproved';
        $is_booked = 0; // Slot is not booked
    }

    // Update the status in the consultations table
    $sql = "UPDATE consultations SET status = ? WHERE booking_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("si", $new_status, $booking_id);

    // If status update is successful, update the slot's booking status
    if ($stmt->execute()) {
        // Update the slot's booking status in the consultation_slots table
        $slot_update_sql = "UPDATE consultation_slots SET is_booked = ? WHERE slot_id = ?";
        $slot_update_stmt = $con->prepare($slot_update_sql);
        $slot_update_stmt->bind_param("ii", $is_booked, $slot_id);
        $slot_update_stmt->execute();
        $slot_update_stmt->close();

        // Optionally redirect or display a success message
        echo "<script>window.location.href = 'consultations.php';</script>";
    } else {
        echo "Error updating status: " . $con->error;
    }

    $stmt->close();
}

include 'includes/footer.php';
}
?>
