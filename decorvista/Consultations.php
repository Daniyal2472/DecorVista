<?php
include("header.php");
if ($_SESSION['role'] !== 'User') {
  echo "<script>
  window.location.href = 'login.php';
  </script>";
  exit();
}

if (!isset($_SESSION['role'])) {
  echo "<script>
      alert('Kindly log in to schedule a consultation.');
      window.location.href = '/DecorVista/decorvista/login.php';
  </script>";
  exit();
}

if ($_SESSION['role'] === 'User') {
?>
<style>
  /* Existing styles remain unchanged */
  @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@200;300;400;500;600;700&display=swap");



  body::before {
    content: "";
    position: absolute;
    width: 100%;
    height: 910px;
    background: url("https://img.freepik.com/premium-psd/living-room-wall-mockup-psd-modern-interior-design_53876-130139.jpg") no-repeat center center/cover;
    filter: blur(4px) brightness(50%);
    z-index: -1;
    
  }

  .wrapper {
    width: 400px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    padding: 30px;
    text-align: center;
    border: 3px solid #24d278;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    position: relative;
    margin-right: 5%;
    margin-top: 30px;
    margin-bottom: 30px;
    margin-left: 480px;
  }

  form {
    display: flex;
    flex-direction: column;
  }

  h2 {
    font-size: 2.5rem;
    margin-bottom: 20px;
    color: #000000;
    letter-spacing: 1px;
  }

  .input-field {
    position: relative;
    border-bottom: 2px solid #000000;
    margin: 15px 0;
  }

  .input-field label {
    position: absolute;
    top: 50%;
    left: 0;
    transform: translateY(-50%);
    color: #000000;
    font-size: 16px;
    pointer-events: none;
    transition: 0.3s ease;
  }

  .input-field input {
    width: 100%;
    height: 40px;
    background: transparent;
    border: none;
    outline: none;
    font-size: 16px;
    color: #000000;
  }

  .input-field input:focus~label,
  .input-field input:valid~label {
    font-size: 0.8rem;
    top: 10px;
    transform: translateY(-120%);
  }

  .forget {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 25px 0 35px 0;
    color: #000000;
  }

  #remember {
    accent-color: #24d278;
  }

  .forget label {
    display: flex;
    align-items: center;
  }

  .forget label p {
    margin-left: 8px;
  }

  .wrapper a {
    color: #000000;
    text-decoration: none;
  }

  .wrapper a:hover {
    text-decoration: underline;
  }

  button {
    background: #24d278;
    color: #000000;
    font-weight: 600;
    border: none;
    padding: 12px 20px;
    cursor: pointer;
    border-radius: 3px;
    font-size: 16px;
    border: 2px solid transparent;
    transition: 0.3s ease;
  }

  button:hover {
    color: #24d278; /* Keep the text color change */
    border-color: #000000; /* Keep the border color change */
    background: transparent; /* Remove the hover background color change */
}

  .register {
    text-align: center;
    margin-top: 30px;
    color: #000000;
  }
</style>
<body>
  <div class="wrapper">
  <form action="" method="POST">
    <h2>Book Consultation</h2>
    
    <!-- Dropdown for available slots -->
    <div class="input-field">
        <select name="slot_id" required>
            <option value="" disabled selected>Select a slot</option>

            <?php
            // Get the designer_id from the previous page
            $designer_id = $_GET['id']; // Ensure to sanitize this input in production code

            // Fetch available slots for the given designer_id
            $sql = "SELECT slot_id, slot_date, start_time, end_time 
                    FROM consultation_slots 
                    WHERE designer_id = ? AND is_booked = 0"; // Fetch only available slots
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $designer_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if any slots are available
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $slot_id = $row['slot_id'];
                    $slot_date = $row['slot_date'];
                    $start_time = $row['start_time'];
                    $end_time = $row['end_time'];

                    // Display the slot in the dropdown
                    echo "<option value='$slot_id'>$slot_date - $start_time to $end_time</option>";
                }
            } else {
                echo "<option value='' disabled>No slots available</option>";
            }
            $stmt->close();
            ?>
        </select>
    </div>

    <!-- Message input field -->
    <div class="input-field">
        <input type="text" name="message" required>
        <label>
            <i class="fas fa-comment pr-1"></i>
            Message
        </label>
    </div>
    
    <button type="submit" class="mt-3">Book</button>
</form>
  </div>
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
<?php


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $slot_id = $_POST['slot_id'];
    $message = $_POST['message'];
    $status = "Pending approval";

    // Insert booking into the database
    $insert_sql = "INSERT INTO consultations (user_id, designer_id, slot_id, message, status) VALUES (?, ?, ?, ?, ?)";
    $insert_stmt = $con->prepare($insert_sql);
    $insert_stmt->bind_param("iiiss", $user_id, $designer_id, $slot_id, $message, $status);

    if ($insert_stmt->execute()) {
        echo "<script>alert('Consultation booked successfully!');</script>";
        echo "<script>window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Error booking consultation. Please try again.');</script>";
    }

    $insert_stmt->close();
}


include("footer.php");
?>
</body>
</html>
<?php
}
?>