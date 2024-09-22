<?php 
include("header.php");
?>

<style>
    /* Container for the gallery */
    .gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Responsive grid */
        gap: 30px; /* Space between cards */
        justify-content: center;
        padding: 40px;
        font-family: 'Poppins', sans-serif; /* Modern font */
    }

    /* Individual gallery item (acts like a card) */
    .gallery-item {
        position: relative;
        border: 1px solid #dbdbdb;
        border-radius: 10px;
        overflow: hidden;
        background-color: #fff;
        transition: box-shadow 0.3s ease-in-out, transform 0.3s ease;
    }

    .gallery-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    /* Image wrapper */
    .img-wrapper {
        position: relative;
        width: 100%;
        height: 250px;
        overflow: hidden;
    }

    .img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease-in-out;
    }

    /* Wishlist overlay on hover */
    .wishlist-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4); /* Dark overlay */
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }

    .img-wrapper:hover .img {
        transform: scale(1.1); /* Zoom effect */
    }

    .img-wrapper:hover .wishlist-overlay {
        opacity: 1; /* Show overlay on hover */
    }

    /* Wishlist icon */
    .wishlist-icon {
        font-size: 2rem;
        color: #fff; /* White icon color */
        background-color: #DEAD6F; /* Accent color */
        border: none;
        border-radius: 50%; /* Circle background */
        padding: 15px;
        transition: transform 0.3s ease-in-out, background-color 0.3s ease-in-out;
        cursor: pointer; /* Change cursor to pointer */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Subtle shadow */
    }

    .wishlist-icon:hover {
        transform: scale(1.1); /* Slight enlargement on hover */
        background-color: #CFAF5B; /* Darker shade on hover */
    }

    /* Details section below image */
    .gallery-details {
        text-align: center;
        padding: 15px;
    }

    .gallery-details h3 {
        margin: 0;
        font-size: 1.3rem;
        color: #333;
        font-weight: 600;
    }

    .gallery-details p {
        margin: 5px 0 0;
        font-size: 1rem;
        color: #6995B1;
        font-weight: 400;
    }
</style>
</head>
<body>
<div class="heading_container pl-5 pt-4">
    <h2>Inspiration Gallery</h2>
</div>
<div class="gallery">
    <?php
    $sql = "SELECT 
                g.inspiration_id AS ID, 
                g.title AS Title, 
                g.description AS Description, 
                c.category_name AS Category_Name, 
                g.image_url AS Image
            FROM 
                inspiration_gallery g
            JOIN 
                categories c 
            ON 
                g.category = c.category_id;";
    $result = $con->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
    ?>
    <div class="gallery-item">
        <div class="img-wrapper">
            <img class="img" src="../admin/uploads/gallery/<?php echo $row["Image"]; ?>" alt="product-image">
            <div class="wishlist-overlay">
                <form action="" method="POST" style="display:inline;">
                    <input type="hidden" name="gallery_id" value="<?php echo $row['ID']; ?>">
                    <button type="submit" class="wishlist-icon" name="add_to_wishlist">
                        <i class="fa-solid fa-heart"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="gallery-details">
            <h3><?php echo $row["Title"]; ?></h3>
        </div>
    </div>
    <?php
        }
    } else {
        echo "<p>No items found in the gallery.</p>";
    }
    ?>
</div>

<?php 
// Handle wishlist addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_wishlist'])) {
    session_start(); // Start session to access user_id
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('User not logged in.');</script>";
        exit;
    }
    
    $user_id = $_SESSION['user_id'];
    $gallery_id = (int)$_POST['gallery_id']; // Ensure it's an integer

    // Prepare and execute the SQL statement
    $stmt = $con->prepare("INSERT INTO wishlist (user_id, gallery_id) VALUES (?, ?)");
    
    if ($stmt) {
        $stmt->bind_param("ii", $user_id, $gallery_id);
        if ($stmt->execute()) {
            echo "<script>alert('Product has been added to your wishlist!');</script>";
        } else {
            echo "<script>alert('Failed to add product to wishlist.');</script>";
        }
        $stmt->close();
    }
    exit; // Exit to prevent further output
}

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
</html>