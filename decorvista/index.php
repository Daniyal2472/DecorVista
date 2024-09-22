<?php
include __DIR__ . '/../connection.php';
if (!isset($_SESSION['role'])) {
  $_SESSION['role'] = ''; // Set to an empty string if not defined
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
  
    <title>Decorvista</title>
  
    <!-- Slider Stylesheet -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />
  
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  
    <!-- Fonts Style -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Poppins:400,700&display=swap" rel="stylesheet" />
  
    <!-- Custom Styles for This Template -->
    <link href="css/style.css" rel="stylesheet" />
  
    <!-- Responsive Style -->
    <link href="css/responsive.css" rel="stylesheet" />
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  </head>

<body >
  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
  <div class="container-fluid">
    <nav class="navbar navbar-expand-lg custom_nav-container">
      <a class="navbar-brand" href="index.php">
        <img src="images/logo a.png" alt="" />
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.php"> About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="shop.php">Shop </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="gallery.php">Our Gallery</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="interior_design.php">Interior Design </a>
          </li>
        </ul>

        <!-- Dropdown button with z-index for proper layering -->
        <div class="dropdown" style="position: relative; z-index: 1000;">
  <a href="#" class="dropdown-toggle" style="color: black; display: flex; align-items: center;" id="loginDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <img src="images/user.png" alt="" style="width: 20px; margin-right: 10px; filter: brightness(0) saturate(100%) invert(53%) sepia(93%) saturate(544%) hue-rotate(74deg) brightness(94%) contrast(89%);">
  </a>
  <div class="dropdown-menu mt-4" aria-labelledby="loginDropdown" style="min-width: 180px; padding: 15px; background-color: #f1f1f1; box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2); border-radius: 8px; transition: all 0.3s ease; opacity: 0; transform: translateY(-10px);">
  <?php
  if ($_SESSION['role'] !== 'User') {
  ?>  
  <a class="dropdown-item" href="login.php" style="color: #222; padding: 10px 15px; margin-bottom: 5px; border-radius: 5px; background-color: transparent; font-weight: bold; display: block; transition: all 0.3s ease;">
      <i class="fas fa-sign-in-alt"></i> Login
    </a>
    <a class="dropdown-item" href="register.php" style="color: #222; padding: 10px 15px; margin-bottom: 5px; border-radius: 5px; background-color: transparent; font-weight: bold; display: block; transition: all 0.3s ease;">
      <i class="fas fa-user-plus"></i> Register
    </a>
    <?php }?>
    <?php
  if ($_SESSION['role'] === 'User') {
  ?>  
  <a class="dropdown-item" href="/DecorVista/logout.php" style="color: #222; padding: 10px 15px; margin-bottom: 5px; border-radius: 5px; background-color: transparent; font-weight: bold; display: block; transition: all 0.3s ease;">
      <i class="fas fa-sign-in-alt"></i> Logout
    </a><?php }?>


    
    <a class="dropdown-item" href="cart.php" style="color: #222; padding: 10px 15px; margin-bottom: 5px; border-radius: 5px; background-color: transparent; font-weight: bold; display: block; transition: all 0.3s ease;">
      <i class="fas fa-shopping-cart"></i> Your Cart
    </a>
    <a class="dropdown-item" href="Dashboard.php" style="color: #222; padding: 10px 15px; margin-bottom: 5px; border-radius: 5px; background-color: transparent; font-weight: bold; display: block; transition: all 0.3s ease;">
      <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
  </div>
</div>







<!-- Add inline script to handle dropdown animation -->
<script>
  document.querySelector('#loginDropdown').addEventListener('click', function(e) {
    e.preventDefault();
    const dropdownMenu = this.nextElementSibling;
    if (dropdownMenu.style.opacity === '1') {
      dropdownMenu.style.opacity = '0';
      dropdownMenu.style.transform = 'translateY(-10px)';
    } else {
      dropdownMenu.style.opacity = '1';
      dropdownMenu.style.transform = 'translateY(0)';
    }
  });
</script>


        <!-- Search form -->
        <form class="form-inline my-2 my-lg-0 ml-0 ml-lg-4 mb-3 mb-lg-0">
          <button class="btn my-2 my-sm-0 nav_search-btn" type="submit"></button>
        </form>
      </div>

      <div>
        <div class="custom_menu-btn">
          <button>
            <span class="s-1"></span>
            <span class="s-2"></span>
            <span class="s-3"></span>
          </button>
        </div>
      </div>
    </nav>
  </div>
</header>

    <!-- end header section -->

    <!-- slider section -->
    <section class="slider_section ">
      <div class="play_btn">
        <a href="">
          <img src="images/play.png" alt="">
        </a>
      </div>
      <div class="number_box">
        <div>
          <ol class="carousel-indicators indicator-2">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active">01</li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1">02</li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2">03</li>
            <li data-target="#carouselExampleIndicators" data-slide-to="3">04</li>
          </ol>
        </div>
      </div>
      <div class="container">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="row">
                <div class="col-md-6">
                  <div class="detail-box">
                    <h1>
                      The Latest
                      <span>
                        Furniture
                      </span>
                    </h1>
                    <p> 

                      At DecorVista, we specialize in creating stylish and functional furniture that enhances the beauty and comfort of your home. Our wide range of carefully crafted pieces caters to diverse tastes, ensuring quality and design excellence. Transform your space with DecorVista’s unique, elegant, and affordable furniture solutions.
                    </p>
                    <div class="btn-box">
                      <a href="shop.php" class="btn-1">
                        Read More
                      </a>
                      <a href="contact.php" class="btn-2">
                        Contact us
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 img-container">
                  <div class="img-box">
                    <img src="images/slider-img.png" alt="">
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item ">
              <div class="row">
                <div class="col-md-6">
                  <div class="detail-box">
                    <h1>
                      The Latest
                      <span>
                        Furniture
                      </span>
                    </h1>
                    <p> At DecorVista, we specialize in creating stylish and functional furniture that enhances the beauty and comfort of your home. Our wide range of carefully crafted pieces caters to diverse tastes, ensuring quality and design excellence. Transform your space with DecorVista’s unique, elegant, and affordable furniture solutions.
                    </p>
                    <div class="btn-box">
                      <a href="shop.php" class="btn-1">
                        Read More
                      </a>
                      <a href="contact.php" class="btn-2">
                        Contact us
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 img-container">
                  <div class="img-box">
                    <img src="images/slider-img.png" alt="">
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item ">
              <div class="row">
                <div class="col-md-6">
                  <div class="detail-box">
                    <h1>
                      The Latest
                      <span>
                        Furniture
                      </span>
                    </h1>
                    <p>
                    At DecorVista, we specialize in creating stylish and functional furniture that enhances the beauty and comfort of your home. Our wide range of carefully crafted pieces caters to diverse tastes, ensuring quality and design excellence. Transform your space with DecorVista’s unique, elegant, and affordable furniture solutions.
                    </p>
                    <div class="btn-box">
                      <a href="shop.php" class="btn-1">
                        Read More
                      </a>
                      <a href="contact.php" class="btn-2">
                        Contact us
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 img-container">
                  <div class="img-box">
                    <img src="images/slider-img.png" alt="">
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item ">
              <div class="row">
                <div class="col-md-6">
                  <div class="detail-box">
                    <h1>
                      The Latest
                      <span>
                        Furniture
                      </span>
                    </h1>
                    <p>
                    At DecorVista,  specialize in creating stylish and functional furniture that enhances the beauty and comfort of your home. Our wide range of carefully crafted pieces caters to diverse tastes, ensuring quality and design excellence. Transform your space with DecorVista’s unique, elegant, and affordable furniture solutions.
                    </p>
                    <div class="btn-box">
                      <a href="" class="btn-1">
                        Read More
                      </a>
                      <a href="" class="btn-2">
                        Contact us
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 img-container">
                  <div class="img-box">
                    <img src="images/slider-img.png" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- end slider section -->
  </div>




  <!-- trending section -->

  <section class="trending_section layout_padding pt-5">
    <div id="accordion">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="detail-box">
              <div class="heading_container">
                <h2>
                  Trending Categories
                </h2>
              </div>
              <div class="tab_container">
                <div class="t-link-box" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                  aria-controls="collapseOne">
                  <div class="number">
                    <h5>
                      01
                    </h5>
                  </div>
                  <hr>
                  <div class="t-name">
                    <h5>
                    Living Rooms
                    </h5>
                  </div>
                </div>
                <div class="t-link-box collapsed" data-toggle="collapse" data-target="#collapseTwo"
                  aria-expanded="false" aria-controls="collapseTwo">
                  <div class="number">
                    <h5>
                      02
                    </h5>
                  </div>
                  <hr>
                  <div class="t-name">
                    <h5>
                    Bedrooms 
                    </h5>
                  </div>
                </div>
                <div class="t-link-box collapsed" data-toggle="collapse" data-target="#collapseThree"
                  aria-expanded="false" aria-controls="collapseThree">
                  <div class="number">
                    <h5>
                      03
                    </h5>
                  </div>
                  <hr>
                  <div class="t-name">
                    <h5>
                    Kitchens
                    </h5>
                  </div>
                </div>
                <div class="t-link-box collapsed" data-toggle="collapse" data-target="#collapseFour"
                  aria-expanded="false" aria-controls="collapseFour">
                  <div class="number">
                    <h5>
                      04
                    </h5>
                  </div>
                  <hr>
                  <div class="t-name">
                    <h5>
                    Offices
                    </h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="collapse show" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordion">
              <div class="img_container ">
                <div class="box b-1">
                  <div class="img-box">
                    <img src="images/t-1.jpg" alt="">
                  </div>
                  <div class="img-box">
                    <img src="images/t-2.jpg" alt="">
                  </div>
                </div>
                <div class="box b-2">
                  <div class="img-box">
                    <img src="images/t-3.jpg" alt="">
                  </div>
                  <div class="img-box">
                    <img src="images/t-4.jpg" alt="">
                  </div>
                </div>
              </div>
            </div>
            <div class="collapse" id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordion">
              <div class="img_container ">
                <div class="box b-1">
                  <div class="img-box">
                    <img src="images/t-3.jpg" alt="">
                  </div>
                  <div class="img-box">
                    <img src="images/t-4.jpg" alt="">
                  </div>
                </div>
                <div class="box b-2">

                  <div class="img-box">
                    <img src="images/t-1.jpg" alt="">
                  </div>
                  <div class="img-box">
                    <img src="images/t-2.jpg" alt="">
                  </div>
                </div>
              </div>
            </div>
            <div class="collapse" id="collapseThree" aria-labelledby="headingThree" data-parent="#accordion">
              <div class="img_container ">
                <div class="box b-1">
                  <div class="img-box">
                    <img src="images/t-4.jpg" alt="">
                  </div>
                  <div class="img-box">
                    <img src="images/t-1.jpg" alt="">
                  </div>
                </div>
                <div class="box b-2">
                  <div class="img-box">
                    <img src="images/t-3.jpg" alt="">
                  </div>
                  <div class="img-box">
                    <img src="images/t-2.jpg" alt="">
                  </div>
                </div>
              </div>
            </div>
            <div class="collapse" id="collapseFour" aria-labelledby="headingfour" data-parent="#accordion">
              <div class="img_container ">
                <div class="box b-1">
                  <div class="img-box">
                    <img src="images/t-1.jpg" alt="">
                  </div>

                  <div class="img-box">
                    <img src="images/t-4.jpg" alt="">
                  </div>
                </div>
                <div class="box b-2">
                  <div class="img-box">
                    <img src="images/t-3.jpg" alt="">
                  </div>
                  <div class="img-box">
                    <img src="images/t-2.jpg" alt="">
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </section>

  <!-- end trending section -->


    <!-- brand section -->
  <!-- brand section -->
  <section class="brand_section layout_padding">
  <div class="container">
    <div class="heading_container">
      <h2>Our Products</h2>
    </div>
    <div class="brand_container layout_padding2">
      <?php
      // SQL query to fetch the top 4 products from the 'products' table, ordered by 'product_id'
      $sql = "SELECT * FROM `products` ORDER BY `product_id` DESC LIMIT 3";
      $result = $con->query($sql);

      // Check if there are any products returned from the query
      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          // Extract product details (adjust the column names based on your database schema)
          $product_id = $row['product_id'];  // Assuming 'product_id' is the product's unique identifier
          $product_name = $row['product_name'];  // Assuming 'product_name' is the name of the product
          $product_price = $row['price']; // Assuming 'price' is the price of the product
          $product_image = $row['image_url']; // Assuming 'image_url' is the path to the product image
      ?>
      <div class="box">
        <!-- Make the whole card clickable and redirect to 'product_detail.php' with the product's ID -->
        <a href="product_detail.php?id=<?php echo $product_id; ?>">
        <div class="img-box">
              <!-- Display the product image -->
              <img src="../admin/uploads/products/<?php echo $row['image_url']; ?>" alt="Product Image">
            </div>
          <div class="detail-box">
            <!-- Display the product price -->
            <h6 class="price pt-4">
              PKR: <?php echo htmlspecialchars($product_price); ?>
            </h6>
            <!-- Display the product name -->
            <h6>
              <?php echo htmlspecialchars($product_name); ?>
            </h6>
          </div>
        </a>
      </div>
      <?php
        }
      } else {
        echo "<p>No products found.</p>";
      }
      ?>
    </div>
  </div>
</section>

  <!-- end brand section -->

  <!-- end brand section -->

  <!-- why choose us -->
  <section class="ftco-section ftco-no-pt ftco-no-pb" style="padding: 100px 0;">
    <div class="container">
        <div class="row no-gutters">
            <!-- Text Section -->
            <div class="col-md-7" style="padding: 0; box-sizing: border-box;">
                <div class="heading-section">
                    
                    <div class="heading_container">
      <h2>Why Choose Us?</h2>
    </div>
                    <hr style="border-top: 2px solid #DEAD6F; width: 50%; margin-bottom: 2rem;">
                </div>
                <div class="row">
                    <!-- Service 1 -->
                    <div class="col-md-6" style="margin-bottom: 20px;">
                        <div class="d-flex align-items-center" style="display: flex; align-items: center;">
                            <div class="text" style="flex: 1;">
                                <h4 style="font-size: 1.5rem; color: #222; margin-bottom: 0.5rem;">Custom Furniture Design</h4>
                                <p style="font-size: 1rem; color: #555;">We specialize in creating bespoke furniture tailored to your style and space, ensuring your home reflects your personality.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Service 2 -->
                    <div class="col-md-6" style="margin-bottom: 20px;">
                        <div class="d-flex align-items-center" style="display: flex; align-items: center;">
                            <div class="text" style="flex: 1;">
                                <h4 style="font-size: 1.5rem; color: #222; margin-bottom: 0.5rem;">Quality Craftsmanship</h4>
                                <p style="font-size: 1rem; color: #555;">Our furniture is crafted from high-quality materials, ensuring durability and longevity for all your furniture needs.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Service 3 -->
                    <div class="col-md-6" style="margin-bottom: 20px;">
                        <div class="d-flex align-items-center" style="display: flex; align-items: center;">
                            <div class="text" style="flex: 1;">
                                <h4 style="font-size: 1.5rem; color: #222; margin-bottom: 0.5rem;">Sustainable Practices</h4>
                                <p style="font-size: 1rem; color: #555;">We are committed to using sustainable materials and eco-friendly practices in our furniture production to protect our planet.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Service 4 -->
                    <div class="col-md-6" style="margin-bottom: 20px;">
                        <div class="d-flex align-items-center" style="display: flex; align-items: center;">
                            <div class="text" style="flex: 1;">
                                <h4 style="font-size: 1.5rem; color: #222; margin-bottom: 0.5rem;">Exceptional Customer Service</h4>
                                <p style="font-size: 1rem; color: #555;">Our team is dedicated to providing exceptional service and support, helping you find the perfect furniture for your home.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5" style="padding: 0;">
                <div class="img d-flex align-items-center justify-content-center"
                     style="background-image: url('https://atlas-content-cdn.pixelsquid.com/stock-images/mid-century-modern-dining-chair-mdaWQnA-600.jpg'); background-size: cover; background-position: center; height: 400px; width: 100%;">
                    <!-- Image section -->
                </div>
            </div>
        </div>
    </div>
</section>


  <!-- discount section -->

  <section class="discount_section  layout_padding">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="detail-box">
            <h2>
              The Latest Collection
            </h2>
            <h2 class="main_heading">
              50% DISCOUNT
            </h2>

            <div class="">
              <a href="shop.php">
                Buy Now
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="img-box">
            <img src="images/discount-img.png" alt="">
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- end discount section -->




  



 


  
</body>
</body>
<?php
include("footer.php");
?>
</html>....