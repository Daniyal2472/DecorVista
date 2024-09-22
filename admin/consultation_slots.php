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

// Handle form submission for creating slots
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $designer_id = $_SESSION['user_id']; // Assuming designer is logged in
    $slot_date = $_POST['slot_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $sql = "INSERT INTO consultation_slots (designer_id, slot_date, start_time, end_time) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('isss', $designer_id, $slot_date, $start_time, $end_time);

    if ($stmt->execute()) {
        echo "<script>alert('Time slot created successfully.');</script>";
    } else {
        echo "Error: " . $con->error;
    }
}

// Fetch available slots (not booked) for the designer
$sql = "SELECT * FROM consultation_slots WHERE designer_id = '{$_SESSION['user_id']}'";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

?>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Your Consultation Slots</h3>
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
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($slot = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $slot["slot_id"]; ?></td>
                        <td><?php echo $slot['slot_date']; ?></td>
                        <td><?php echo $slot['start_time']; ?></td>
                        <td><?php echo $slot['end_time']; ?></td>
                        <td><?php echo $slot['is_booked'] ? 'Booked' : 'Available'; ?></td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default">Action</button>
                                <button type="button" class="btn btn-default dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="consultation_slots.php?delete_id=<?php echo $slot['slot_id']; ?>">Delete</a>
                                </div>
                            </div>
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
<div class="col-12">
<form method="POST">
    <label for="slot_date">Date:</label>
    <input type="date" id="slot_date" name="slot_date" required>

    <label for="start_time">Start Time:</label>
    <input type="time" id="start_time" name="start_time" required>

    <label for="end_time">End Time:</label>
    <input type="time" id="end_time" name="end_time" required>

    <button type="submit">Create Slot</button>
</form>
</div>
<?php
if (isset($_GET['delete_id'])) {
    $slot_id = $_GET['delete_id'];

    // Prepare and execute the delete query
    $sql = "DELETE FROM consultation_slots WHERE slot_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $slot_id);

    if ($stmt->execute()) {
        echo "<script>alert('Slot deleted successfully'); window.location.href='consultation_slots.php';</script>";
    } else {
        echo "Error deleting slot: " . $con->error;
    }

    $stmt->close();
}


include 'includes/footer.php';
}
?>