<?php
include("header.php"); // Assuming header.php includes the database connection
if ($_SESSION['role'] !== 'User') {
    echo "<script>
    window.location.href = 'login.php';
    </script>";
    exit();
  }

  $user_id = $_SESSION['user_id'];

  // Prepare the query
  $query = "SELECT 
    u.user_id,
    u.first_name,
    u.last_name,
    c.booking_id,
    c.booking_date,
    c.message,
    c.status,
    cs.slot_date,
    cs.start_time,
    cs.end_time,
    CONCAT(d.first_name, ' ', d.last_name) AS designer_full_name -- Fetch designer's full name
FROM 
    users u
JOIN 
    consultations c ON u.user_id = c.user_id
JOIN 
    consultation_slots cs ON c.slot_id = cs.slot_id
JOIN 
    users d ON c.designer_id = d.user_id -- Join to get designer's details
WHERE 
    u.user_id = ?"; // Use a placeholder for user ID

  
  // Prepare and execute the statement
  $stmt = $con->prepare($query);
  $stmt->bind_param("i", $user_id); // Bind the user ID as an integer
  $stmt->execute();
  
  // Get the result
  $result = $stmt->get_result();

if (!$result) {
    die("Query failed: " . mysqli_error($con)); // In case the query fails
}



// Check if the cancel button was pressed
if (isset($_POST['cancel_consultation'])) {
    $booking_id = $_POST['booking_id'];

    // Prepare the DELETE statement
    $deleteQuery = "DELETE FROM consultations WHERE booking_id = ?";
    $stmt = $con->prepare($deleteQuery);
    $stmt->bind_param("i", $booking_id);

    if ($stmt->execute()) {
        echo "<script>alert('Consultation cancelled successfully.');</script>";
    } else {
        echo "<script>alert('Failed to cancel the consultation.');</script>";
    }

    $stmt->close();
}

?>

<style>
    .wrapper {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .content {
        padding: 20px;
    }

    .heading_container h2 {
        text-align: center;
        font-size: 2.5rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .card {
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        margin-bottom: 20px;
        transition: transform 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-body {
        padding: 15px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .no-records {
        text-align: center;
        font-size: 1.5rem;
        color: #777;
    }
</style>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <section class="content">
        <div class="heading_container">
            <h2 class="pb-4">All Consultations</h2>
        </div>

        <?php
if (mysqli_num_rows($result) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Consultation ID: <?php echo htmlspecialchars($row['booking_id']); ?></h5>
                <p class="card-text">Date: <?php echo date("F j, Y", strtotime($row['slot_date'])); ?></p>
                <p class="card-text">Time: <?php echo date("g:i A", strtotime($row['start_time'])) . " - " . date("g:i A", strtotime($row['end_time'])); ?></p>
                <p class="card-text">Designer Name: <?php echo htmlspecialchars($row['designer_full_name']); ?></p>
                <p class="card-text">Status: <?php echo htmlspecialchars($row['status']); ?></p>
                <div class="text-right">
    <form method="POST" action="">
        <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
        <button type="submit" name="cancel_consultation" class="btn btn-danger">Cancel</button>
    </form>
</div>

            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <div class="alert alert-info no-records" role="alert">
        No consultations found.
    </div>
<?php endif; ?>


    </section>
</div>

<?php include("footer.php"); ?>
</body>
</html>
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js">
  </script>
  <script type="text/javascript">
    $(".owl-carousel").owlCarousel({
      loop: true,
      margin: 10,
      nav: true,
      navText: [],
      autoplay: true,
      autoplayHoverPause: true,
      responsive: {
        0: {
          items: 1
        },
        420: {
          items: 2
        },
        1000: {
          items: 5
        }
      }

    });
  </script>
  <script>
    var nav = $("#navbarSupportedContent");
    var btn = $(".custom_menu-btn");
    btn.click
    btn.click(function (e) {

      e.preventDefault();
      nav.toggleClass("lg_nav-toggle");
      document.querySelector(".custom_menu-btn").classList.toggle("menu_btn-style")
    });
  </script>
  <script>
    $('.carousel').on('slid.bs.carousel', function () {
      $(".indicator-2 li").removeClass("active");
      indicators = $(".carousel-indicators li.active").data("slide-to");
      a = $(".indicator-2").find("[data-slide-to='" + indicators + "']").addClass("active");
      console.log(indicators);

    })
  </script>