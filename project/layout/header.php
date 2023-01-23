  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto d-flex  align-items-center">
      <li class="nav-item">
        <a class="nav-link">
          <p class="mb-0">ตำเเหน่ง : <span class=" text-primary"><?= $_SESSION['user_role'] ?></span> </p>
        </a>
      </li>
      <li class="nav-item mx-1">
        <div class="position-relative dropstart">
          <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-ellipsis-h"></i>
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="personal_data.php"><i class="fas fa-user"></i> ข้อมูลส่วนตัว</a></li>
            <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->