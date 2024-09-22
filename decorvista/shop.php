<?php 
include("header.php");
?>

<body class="sub_page">

  <!-- brand section -->
  <section class="brand_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Our Products
        </h2>
      </div>
      <div class="brand_container layout_padding2">
        <?php
        // SQL query to fetch all products from the 'products' table
        $sql = "SELECT * FROM `products` WHERE 1";
        $result = $con->query($sql);

        // Check if there are any products returned from the query
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            // Extract product details (adjust the column names based on your database schema)
            $product_id = $row['product_id'];  // Assuming 'id' is the product's unique identifier
            $product_name = $row['product_name'];  // Assuming 'product_name' is the name of the product
            $product_price = $row['price']; // Assuming 'product_price' is the price of the product
            $product_image = $row['image_url']; // Assuming 'product_image' is the image of the product
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
                PKR: <?php echo $product_price; ?>
              </h6>
              <!-- Display the product name -->
              <h6>
                <?php echo $product_name; ?>
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
      $(".indicator-2").find("[data-slide-to='" + indicators + "']").addClass("active");
    });
  </script>

</body>

<?php 
include("footer.php");
?>
</html>
