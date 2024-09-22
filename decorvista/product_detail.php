<?php
include("header.php"); // Ensure the database connection is included
$user_id = $_SESSION['user_id'];
// Check if product ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = mysqli_real_escape_string($con, $_GET['id']);
    
    // Fetch the product details from the products table
    $query = "SELECT * FROM `products` WHERE `product_id` = '$product_id'";
    $result = mysqli_query($con, $query);

    // Check if the query was successful
    if (!$result) {
        die("Query failed: " . mysqli_error($con)); // Display SQL error if query fails
    }

    // Check if the product was found
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        die("No product found with the given ID."); // Display message if no product is found
    }
} else {
    die("Invalid or missing ID parameter."); // Handle invalid or missing product ID
}

if (isset($_POST['add_to_cart'])) {
    $product_id = intval($_POST['product_id']); // Sanitize input

    // Check if the product is already in the cart
    $checkQuery = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $con->prepare($checkQuery);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If the product is already in the cart
        echo "<script>alert('Product is already in the cart!');</script>";
    } else {
        // Insert the product into the cart
        $insertQuery = "INSERT INTO `cart`(`product_id`, `user_id`) VALUES (?, ?)";
        $insertStmt = $con->prepare($insertQuery);
        $insertStmt->bind_param("ii", $product_id, $user_id);

        if ($insertStmt->execute()) {
            echo "<script>alert('Product has been added to your cart!');</script>";
        } else {
            echo "<script>alert('Failed to add product to cart: " . $insertStmt->error . "');</script>"; // Display error
        }

        $insertStmt->close();
    }}
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
    }

    .section-header {
        font-size: 1.75rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 30px;
        border-bottom: 3px solid #3b71ca;
        padding-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .btn-primary {
        background-color: black;
        border-color: black #333;
        color: #fff;
        font-size: 1rem;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-primary:hover {
        background-color: #24d278;
        border-color: #24d278;
        color: white;
    }

    .icon-hover:hover {
        border-color: #3b71ca !important;
        background-color: white !important;
        color: #3b71ca !important;
    }

    .icon-hover:hover i {
        color: #3b71ca !important;
    }

    h4.title {
        font-size: 2rem;
        font-weight: 600;
        color: black;
    }

    .product-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #e63946;
    }

    .product-description {
        font-size: 1rem;
        line-height: 1.8;
        color: #555;
        margin-bottom: 20px;
    }

    .stars, .stock-info {
        font-size: 1rem;
        font-weight: 500;
        color: #ff9800;
    }

    .stock-info {
        color: #4caf50;
        font-weight: 600;
    }

    .btn-group {
        display: flex;
        justify-content: start;
        gap: 15px;
        margin-top: 20px;
    }

    img.fit {
        object-fit: cover;
        border-radius: 10px;
    }

    /* Media queries for responsiveness */
    @media (max-width: 768px) {
        h4.title {
            font-size: 1.5rem;
        }
        
        .product-price {
            font-size: 1.25rem;
        }

        .product-description {
            font-size: 0.9rem;
        }

        .section-header {
            font-size: 1.5rem;
        }
    }
</style>

<!-- content -->
<section class="py-5">
    <div class="container">
        <div class="row gx-5">
            <!-- Product Image -->
            <aside class="col-lg-6">
                <div class="border rounded-4 mb-3 d-flex justify-content-center">
                    <a data-fslightbox="mygallery" class="rounded-4" target="_blank" data-type="image">
                        <img style="max-width: 100%; max-height: 60vh; margin: auto;" class="rounded-4 fit" src="../admin/uploads/products/<?php echo $row['image_url']; ?>" alt="Product Image"/>
                    </a>
                </div>
            </aside>
            <!-- Product Details -->
            <main class="col-lg-6">
                <div class="ps-lg-3">
                    <h4 class="title">
                        <?php echo htmlspecialchars($row['product_name']); ?>
                    </h4>
                    <div class="d-flex flex-row my-3 align-items-center">
    <div class="stars mb-1 me-2">
        <i class="fas fa-star text-yellow"></i>
        <i class="fas fa-star text-yellow"></i>
        <i class="fas fa-star text-yellow"></i>
        <i class="fas fa-star text-yellow"></i>
        <i class="fas fa-star text-yellow"></i>
        <span class="ms-1 text-dark">4.5</span>
    </div>
</div>
                        <span class="stock-info ms-2 text-dark">In stock</span>
                    </div>

                    <div class="mb-3">
                        <span class="product-price">PKR: <?php echo htmlspecialchars($row['price']); ?></span>
                    </div>

                    <p class="product-description"><?php echo htmlspecialchars($row['description']); ?></p>

                    <hr />

                    <!-- Action Buttons -->
                    <div class="btn-group">
                       
                        <form method="POST" action="">
        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">

        <?php
        if ($_SESSION['role'] === 'User') {
        
        ?>
        <button type="submit" name="add_to_cart" class="btn btn-primary shadow-0">
            <i class="me-1 fa fa-shopping-cart"></i> Add to cart
        </button>
        <div class="mb-3 pt-3">
    <textarea id="feedback" name="feedback" class="form-control" rows="3" cols="50" placeholder="Write your feedback here..."></textarea>
</div>
<div class="mb-3">
    <button type="submit" name="submit_feedback" class="btn btn-primary">Submit Feedback</button>
</div>

<?php
}?>

<?php
if (isset($_POST['submit_feedback'])) {  // Use the name attribute of the button

    // Get the current logged-in user ID and product ID from the session and URL
    $user_id = $_SESSION['user_id']; 
    $product_id = $_GET['id']; 

    // Get the feedback comment from the textarea
    $comment = mysqli_real_escape_string($con, $_POST['feedback']);

    // Check if feedback is not empty
    if (!empty($comment)) {
        // Prepare the SQL query to insert the feedback
        $sql = "INSERT INTO reviews (user_id, product_id, comment) VALUES (?, ?, ?)";

        // Prepare the statement
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iis", $user_id, $product_id, $comment); // Bind parameters

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('Thank you for your feedback!');</script>";
        } else {
            echo "<script>alert('Failed to submit feedback.');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Feedback cannot be empty.');</script>";
    }
}
?>
        
    </form>
    
            </main>
            
        </div>
    </div>
</section>

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
    // Get the product ID from the URL
$product_id = $_GET['id'];

// Simple SQL query to fetch reviews for the specified product_id
$query = "SELECT 
            CONCAT(u.first_name, ' ', u.last_name) AS reviewer_full_name, 
            p.product_name, 
            p.image_url, 
            r.comment 
          FROM reviews r
          JOIN users u ON r.user_id = u.user_id 
          JOIN products p ON r.product_id = p.product_id
          WHERE r.product_id = $product_id"; // Filter by product_id
    // Execute the query
$result = mysqli_query($con, $query);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
    ?>
        <div class="client_box b-1">
          <div class="client-id">
            <div class="col-5 text-center">
                    <img src="../admin/uploads/products/<?php echo $row["image_url"]; ?>" alt="user-avatar" class="img-circle img-fluid">
                  </div>
            <div class="name">
              <h5>
              <?php echo $row["product_name"]; ?>
              </h5>
              <p>
              <?php echo $row["reviewer_full_name"]; ?>
              </p>
            </div>
          </div>
          <div class="detail">
            <p>
            <?php echo $row["comment"]; ?>
            </p>
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

<?php include("footer.php"); ?>
