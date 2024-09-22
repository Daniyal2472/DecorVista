<?php
include __DIR__ . '/../connection.php';
?>


<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Digitf</title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Poppins:400,700&display=swap" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
</head>

<body class="sub_page">
<div>
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
        <div class="custom_menu-btn ">
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

  
  </div>    