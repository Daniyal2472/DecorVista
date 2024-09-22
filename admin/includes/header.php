<?php
include __DIR__ . '/../../connection.php';
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Descorvista Panel </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->

      <!-- Messages Dropdown Menu -->
      <li class="nav-item">
    <a class="nav-link" href=""> <!-- Change 'home.php' to your home page URL -->
        <i class="fas fa-home"></i> <!-- Font Awesome home icon -->
        <span class="nav-text">Home</span> <!-- Optional: Add text next to the icon -->
    </a>
</li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">

      <span class="brand-text font-weight-light pl-4"><?php echo $_SESSION['role']; ?> Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="uploads/profile_pictures/<?php echo $_SESSION['profile_photo']; ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <?php if(isset($_SESSION['username'])): ?>
            <a href="" class="d-block"><?php echo $_SESSION['username']; ?></a>
          <?php else: ?>
            <a href="login.php" class="d-block">Please Login</a>
          <?php endif; ?>
        </div>
      </div>

      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <?php
               if ($_SESSION['role'] === 'Designer') {
          ?>
               <li class="nav-item">
            <a href="designer_profile.php" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
              <p>
              Designer Profile
              </p>
            </a>
          </li>
          <?php
               }
          ?>
               <?php
               if ($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Designer') {?>
               <li class="nav-item">
            <a href="consultations.php" class="nav-link">
            <i class="nav-icon fas fa-list"></i>
              <p>
              Consultations
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="reviews.php" class="nav-link">
            <i class="nav-icon fas fa-star"></i>              <p>
                Reviews
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="order_list.php" class="nav-link">
            <i class="nav-icon fas fa-receipt"></i>
            <p>
              Order List 
              </p>
            </a>
          </li>
          <?php
               }
               if ($_SESSION['role'] === 'Designer') {
          ?>
          <li class="nav-item">
            <a href="consultation_slots.php" class="nav-link">
            <i class="nav-icon fas fa-columns"></i>
              <p>
              Consultation slots
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="designer_portfolio.php" class="nav-link">
            <i class="nav-icon fas fa-briefcase"></i>
              <p>
              Portfolio
              </p>
            </a>
          </li>
          <?php
               }
               if ($_SESSION['role'] === 'Admin') {
          ?>
          
               <li class="nav-item">
            <a href="users.php" class="nav-link">
              <i class="nav-icon far fa-user"></i>
              <p>
                Users
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="categories.php" class="nav-link">
              <i class="nav-icon fas fa-tags"></i>
              <p>
              Categories
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="products.php" class="nav-link">
              <i class="nav-icon fas fa-shopping-basket"></i>
              <p>
                Products
              </p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="interior_designers.php" class="nav-link">
              <i class="nav-icon  fas fa-pencil-alt"></i>
              <p>
                Designers
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="inspiration_gallery.php" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
              Inspiration Gallery
              </p>
            </a>
          </li>
          
          <?php
               }
          ?>
          <li class="nav-item">
          <a href="/DecorVista/logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
              Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

      <!-- Main content -->
      <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">