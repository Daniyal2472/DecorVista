<?php
include("header.php");
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

  /* Heading Styling */
  .page-heading {
    text-align: center;
    font-size: 2.5rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  /* Card Styling */
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

  .card-header {
    color: white;
    padding: 10px 15px;
    font-size: 1.25rem;
    font-weight: 500;
    border-bottom: none;
    border-radius: 15px 15px 0 0;
  }

  .card-body {
    padding: 15px;
  }

  /* Image Styling */
  .img-circle {
    border-radius: 50%;
    max-width: 120px;
    margin: 10px 0;
  }

  /* Footer Button Styling */
  .card-footer {
    padding: 10px;
    background-color: #f8f9fa;
    border-radius: 0 0 15px 15px;
  }

  .btn-sm {
    padding: 6px 12px;
    font-size: 0.875rem;
    line-height: 1.5;
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

  .bg-teal {
    background-color: #20c997;
    color: #fff;
    transition: background-color 0.3s;
  }

  .bg-teal:hover {
    background-color: #138f75;
  }

  /* Modal Styling */
  .modal-header {
    background-color: #007bff;
    color: white;
  }

  .modal-body {
    padding: 20px;
  }

  /* List and Icon Styling */
  .fa-ul {
    margin: 0;
    padding-left: 1.5em;
  }

  .fa-ul li {
    margin-bottom: 0.75rem;
  }

  .fa-building, .fa-phone {
    color: #6c757d;
  }

  /* Pagination Styling */
  .pagination {
    margin-top: 20px;
  }

  .page-link {
    color: #007bff;
  }

  .page-link:hover {
    color: #0056b3;
  }

  .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
  }

  .page-item .page-link {
    padding: 5px 10px;
    border-radius: 5px;
    border: 1px solid #ddd;
  }

  /* Responsive Adjustments */
  @media (max-width: 768px) {
    .col-7, .col-5 {
      flex: 100%;
      max-width: 100%;
    }

    .card-body .row {
      flex-direction: column;
    }

    .img-box img {
      max-width: 80px;
      height: auto;
    }

    .pagination {
      flex-wrap: wrap;
    }
  }
</style>

<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <!-- Main content -->
  <section class="content">

    <!-- Heading -->
    <div class="heading_container">
      <h2 class="pb-4">
        Interior Designers
      </h2>
    </div>
    
    <!-- Default box -->
    <div class="card card-solid">
      <div class="card-body pb-0">
        <div class="row">
        <?php
          $sql = "SELECT * FROM users WHERE role='Designer'";
          $result = $con->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
          ?>
          <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
            <div class="card bg-light d-flex flex-fill">
              <div class="card-header text-muted border-bottom-0">
                <?php echo $row["username"]; ?>
              </div>
              <div class="card-body pt-0">
                <div class="row">
                  <div class="col-7">
                    <h2 class="lead pt-2"><b><?php echo $row["first_name"]; ?> <?php echo $row["last_name"]; ?></b></h2>
                     
                    <p class="text-muted text-sm"><b>Username: </b><?php echo $row['username']; ?></p>
                    <p class="text-muted text-sm"><b>Email: </b><?php echo $row['email']; ?></p>
                    <p class="text-muted text-sm"><b>Portfolio URL: </b><?php echo $row['portfolio_url']; ?></p>
                    <p class="text-muted text-sm"><b>Experience: </b><?php echo $row['years_of_experience']; ?> years</p>
                    <p class="text-muted text-sm"><b>Specialization: </b><?php echo $row['specialization']; ?></p>
                    <p class="text-muted text-sm"><b>Role: </b><?php echo $row['role']; ?></p>
                    <p class="text-muted text-sm"><b>Account Created On: </b><?php echo date('F j, Y', strtotime($row['created_at'])); ?></p>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                       
                      <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone: <?php echo $row['contact']; ?></li>
                    </ul>
                  </div>
                  <div class="col-5 text-center">
                    <img src="../admin/uploads/profile_pictures/<?php echo $row['profile_photo']; ?>" alt="user-avatar" class="img-circle img-fluid">
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="text-right">
                  <a href="javascript:void(0);" class="btn btn-sm bg-teal" data-toggle="modal" data-target="#chatModal" data-fullname="<?php echo $row['first_name'] . ' ' . $row['last_name']; ?>" data-userid="<?php echo $row['user_id']; ?>">
                    <i class="fas fa-comments"></i> Feedback
                  </a>
                  <a href="portfolio.php?id=<?php echo $row['user_id']; ?>" class="btn btn-sm bg-teal">
                    <i class="fas fa-briefcase"></i> Portfolio
                  </a>
                  <a href="Consultations.php?id=<?php echo $row['user_id']; ?>" class="btn btn-sm bg-teal">
                    <i class="fas fa-calendar"></i> Book Appointment
                  </a>
                </div>
              </div>
            </div>
          </div>
          <?php
            }
          } else {
            echo "<tr><td colspan='7'>No Designers found</td></tr>";
          }
          ?>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

    
    <!-- client section -->
    <section class="client_section layout_padding-bottom">
      <div class="container">
        <div class="heading_container">
          <h2>
            Testimonial
          </h2>
        </div>
      </div>

      <div class="container">
        <div class="client_container layout_padding2">
        <?php
    $sql = "SELECT 
    CONCAT(u1.first_name, ' ', u1.last_name) AS reviewer_full_name,
    u1.profile_photo AS reviewer_profile_photo,  -- Fetch reviewer's profile photo
    CONCAT(u2.first_name, ' ', u2.last_name) AS designer_full_name,
    u2.profile_photo AS designer_profile_photo,  -- Fetch designer's profile photo
    r.comment
FROM 
    reviews r
JOIN 
    users u1 ON r.user_id = u1.user_id  -- user who gave the review
JOIN 
    users u2 ON r.designer_id = u2.user_id
";
    $result = $con->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
    ?>
          <div class="client_box b-1">
            <div class="client-id">
            <div class="col-5 text-center">
                    <img src="../admin/uploads/profile_pictures/<?php echo $row['reviewer_profile_photo']; ?>" alt="user-avatar" class="img-circle img-fluid">
                  </div>
              <!-- <div class="img-box">
                <img src="images/client-1.png" alt="" />
              </div> -->
              <div class="name pl-5">
                <h5>
                <?php echo $row["reviewer_full_name"]; ?>
                </h5>
                <p>
                <?php echo $row["designer_full_name"]; ?>
                </p>
              </div>
            </div>
            <div class="detail">
              <p><?php echo $row["comment"]; ?></p>
              <div>
                <div class="arrow_img">
                </div>
              </div>
            </div>
          </div>
          <?php
        }
    } else {
        echo "<p>Be the first to leave a review!</p>";
    }
    ?>
          
        </div>
      </div>
    </section>
    <!-- end client section -->

    <!-- Chat Modal -->
    <div class="modal fade" id="chatModal" tabindex="-1" role="dialog" aria-labelledby="chatModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="chatModalLabel">User Name</h5> <!-- This will be replaced with full name -->
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- DIRECT CHAT SUCCESS -->
            <div class="card card-success card-outline direct-chat direct-chat-success shadow-sm">
              <div class="card-body">
                <!-- Conversations are loaded here -->
              </div>
              <div class="card-footer">
                <!-- Feedback Label -->
                <label for="feedbackMessage" class="form-label">Leave your feedback:</label>
                <form action="" method="post">
                  <div class="input-group">
                    <input type="text" id="feedbackMessage" name="message" placeholder="Type Message ..." class="form-control" required>
                    <input type="hidden" name="designer_id" id="designer_id">
                    <span class="input-group-append">
                      <button type="submit" name="submit_feedback" class="btn btn-success">Send</button>
                    </span>
                  </div>
                </form>
              </div>
            </div>
            <!--/.direct-chat -->
          </div>
        </div>
      </div>
    </div>
    <?php
    if (isset($_POST['submit_feedback'])) {
      $comment = mysqli_real_escape_string($con, $_POST['message']); // Sanitize input
      $user_id = $_SESSION['user_id']; // Assuming you are storing the logged-in user's ID in session
      $designer_id = $_POST['designer_id']; // Fetch designer ID from the query parameter

      // Insert into the reviews table
      $query = "INSERT INTO reviews (user_id, designer_id, comment) 
            VALUES ('$user_id', '$designer_id', '$comment')";

      if ($con->query($query) === TRUE) {
        echo "<script>alert('Feedback submitted successfully!');</script>";
        echo "<script>window.location.href='interior_design.php';</script>";
      } else {
        echo "<script>alert('Error submitting feedback: " . $con->error . "');</script>";
      }
    }
    ?>

    <script>
     $('#chatModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); // Button that triggered the modal
  var fullName = button.data('fullname'); // Extract full name from data-* attributes
  var userId = button.data('userid'); // Extract user ID

  var modal = $(this);
  modal.find('.modal-title').text(fullName); // Set modal title to full name
  modal.find('input#designer_id').val(userId); // Set the hidden input with designer ID
});

    </script>
    <!-- End Chat Modal -->

  </section>
  <!-- /.content -->
</div>
<!-- /.wrapper -->

<?php
include("footer.php");
?>
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
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
</body>
</html>
