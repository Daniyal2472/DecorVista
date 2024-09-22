<?php
include("header.php"); // Include the database connection
if ($_SESSION['role'] !== 'User') {
    echo "<script>
    window.location.href = 'login.php';
    </script>";
    exit();
}

$user_id = $_SESSION['user_id'] ?? null;

if ($user_id) {
    // Fetch user data
    $query = "SELECT `user_id`, `username`, `email`, `first_name`, `last_name`, `contact`, `password`, `role`, `profile_photo`, `created_at`, `portfolio_url`, `years_of_experience`, `specialization` FROM `users` WHERE `user_id` = '$user_id'";
    $result = mysqli_query($con, $query);
    
    if ($result) {
        $user_data = mysqli_fetch_assoc($result);
    } else {
        die("Query failed: " . mysqli_error($con));
    }
} else {
    die("User not logged in.");
}
?>

<style>
   /* Dashboard container */
.dashboard-container {
    max-width: 1200px;
    margin: 50px auto;
    padding: 20px;
    background-color: aliceblue;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

h2 {
    text-align: center;
    margin-bottom: 40px;
    color: #333;
}

/* Card layout */
.dashboard-cards {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
}

/* Individual card styling */
.dashboard-card {
    background: linear-gradient(135deg, #a8e063, #56ab2f); /* Default green gradient */
    width: 300px;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    text-align: center;
    transition: transform 0.3s ease;
}

/* Card hover effect */
.dashboard-card:hover {
    transform: translateY(-5px);
}

/* Card icons */
.dashboard-card i {
    font-size: 50px;
    color: #fff;
    margin-bottom: 20px;
}

.dashboard-card h3 {
    color: #fff;
    margin-bottom: 15px;
}

.dashboard-card p {
    color: #fff;
}

/* Saved Designs - Custom Green Gradient */
.dashboard-card.saved-designs {
    background: linear-gradient(135deg, #6DD5FA, #28a745); /* Light green to deep green */
}

/* Notifications - Custom Green Gradient */
.dashboard-card.notifications {
    background: linear-gradient(135deg, #11998e, #38ef7d); /* Dark teal green to vibrant green */
}

/* Upcoming consultations - Custom Green Gradient */
.dashboard-card.upcoming-consultations {
    background: linear-gradient(135deg, #6DD5FA, #28a745); /* Gradient similar to default but reversed */
}

/* Button styling */
.view-more-btn {
    display: block;
    margin: 20px auto;
    background-color: #000000;
    color: #333;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    border: 1px solid transparent;
    transition: all 0.3s ease;
}

.view-more-btn:hover {
    background-color: #24d278;
    color: #fff;
    border: 1px solid #fff;
}

/* Media Queries for Responsive Design */
@media (max-width: 768px) {
    .dashboard-cards {
        flex-direction: column;
        align-items: center;
    }
}


    /* Background for the entire body */
    body::before {
        content: "";
        position: absolute;
        width: 100%;
        height: 1800px;
        background: url("https://img.freepik.com/premium-psd/living-room-wall-mockup-psd-modern-interior-design_53876-130139.jpg") no-repeat center center/cover;
        filter: blur(4px) brightness(50%);
        z-index: -1;
    }

    /* Wrapper for the form */
    .wrapper {
        width: 400px;
        background: rgba(255, 255, 255, 0.8); /* Adjust opacity for better visibility */
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        border: 3px solid #24d278;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        position: relative;
        margin: 0 auto; /* Center the wrapper */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional shadow for the form */
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

    .input-field input:focus ~ label,
    .input-field input:valid ~ label {
        font-size: 0.8rem;
        top: 10px;
        transform: translateY(-120%);
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

  

    /* Profile Image */
    .profile-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 20px;
        border: 2px solid #24d278; /* Optional border */
    }
</style>
</head>
<body>

    <div class="dashboard-container">
        <div class="heading_container justify-content-center">
            <h2>User Dashboard</h2>
        </div>
        <div class="dashboard-cards">
            <!-- Saved Designs Card -->
            <div class="dashboard-card saved-designs">
                <i class="fa fa-folder-open"></i>
                <h3>Saved Designs</h3>
                <p>View all your saved designs.</p>
                <a href="whishlist.php" class="view-more-btn mt-5 text-white">View Designs</a>
            </div>

            <!-- Notifications Card -->
            <!-- <div class="dashboard-card notifications">
                <i class="fa fa-bell"></i>
                <h3>Notifications</h3>
                <p>Check your latest updates and alerts.</p>
                <a href="#" class="view-more-btn mt-4 text-white">View Notifications</a>
            </div> -->

            <!-- Upcoming Consultations Card -->
            <div class="dashboard-card upcoming-consultations">
                <i class="fa fa-calendar"></i>
                <h3>Upcoming Consultations</h3>
                <p>See your upcoming consultations schedule.</p>
                <a href="upcoming_consultation.php?id=<?php echo $user_id; ?>" class="view-more-btn mt-4 text-white">View Schedule</a>
            </div>
        </div>

        <!-- Profile Section -->
        <div class="wrapper">
    <form action="update_profile.php" method="POST" enctype="multipart/form-data">
        <h2>Profile Information</h2>
        <img src="../admin/uploads/profile_pictures/<?php echo $user_data['profile_photo']; ?>" 
    alt="Profile Photo" 
    class="profile-image" 
    id="profileImage" 
    onerror="this.onerror=null;this.src='path/to/default-profile.png';">

        
        <div class="input-field">
            <input type="text" name="username" value="<?php echo htmlspecialchars($user_data['username']); ?>" required>
            <label>
                <i class="fas fa-user pr-1"></i>
                Enter your Username 
            </label>
        </div>

        <div class="input-field">
            <input type="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
            <label>
                <i class="fas fa-envelope pr-1"></i>
                Enter your Email
            </label>
        </div>

        <div class="input-field">
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($user_data['first_name']); ?>" required>
            <label>
                <i class="fas fa-user-tag pr-1"></i>
                First Name
            </label>
        </div>

        <div class="input-field">
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($user_data['last_name']); ?>" required>
            <label>
                <i class="fas fa-user-tag pr-1"></i>
                Last Name
            </label>
        </div>

       

        <div class="input-field">
            <input type="password" name="password" placeholder="Leave blank to keep current password">
            <label>
                <i class="fas fa-lock pr-1"></i>
                Change Password
            </label>
        </div>

        <div class="input-field">
            <input type="file" id="profile_photo" name="profile_photo" accept="image/*" onchange="previewImage(event)">
        </div>



        <button type="submit" class="mt-3 view-more-btn text-white">Update Profile</button>
    </form>
</div>


        <script>
            function previewImage(event) {
                const image = document.getElementById('profileImage');
                image.src = URL.createObjectURL(event.target.files[0]);
            }
        </script>
    </div>
   
</body>

</html>
<?php
    include("footer.php");
    
    ?>
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