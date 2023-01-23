<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index.php" class="brand-link">
    <img src="asset/image/logoschool.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8;">
    <span class="brand-text font-weight-light">โรงเรียนอนุบาลร่มเย็น</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <!-- <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
      </div>
      <div class="info">
        <a href="#" class="d-block"><?= $_SESSION['user_fullname'] ?></a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item menu-open">
          <a href="#" class="nav-link active">
            <i class="fas fa-user-graduate"></i>
            <p>
              การจัดการนักเรียน
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="./index.php" class="nav-link" id="nav-link1">
                <i class="far fa-circle nav-icon"></i>
                <p>รายชื่อนักเรียน</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./change_status_student.php" class="nav-link" id="nav-link2">
                <i class="far fa-circle nav-icon"></i>
                <p>เปลี่ยนสถานะนักเรียน</p>
              </a>
            </li>
            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="จัดการจ่ายค่าใช้จ่ายเเละค่าเทอมนักเรียน">
              <a href="management_order_term.php" class="nav-link" id="nav-link3">
                <i class="far fa-circle nav-icon"></i>
                <p>ชำระค่าเล่าเรียน</p>
              </a>
            </li>
          </ul>
        </li>
        <li <?= $_SESSION['user_role'] == 'admin' ? 'class="nav-item menu-open"' : 'class="nav-item menu-open d-none"'; ?>>
          <a href="#" class="nav-link active">
            <i class="fas fa-tasks"></i>
            <p>
              จัดการค่าใช้จ่ายทั่วไป
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item ">
              <a href="./menu_cost_product.php" class="nav-link" id="nav-link5">
                <i class="far fa-circle nav-icon"></i>
                <p>รายการสินค้า/ค่าใช้จ่าย</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link active">
            <i class="fas fa-info-circle"></i>
            <p>
              ทั่วไป
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li <?= $_SESSION['user_role'] == 'admin' ? 'class="nav-item"' : 'class="nav-item d-none"'; ?>>
              <a href="management_member.php" class="nav-link" id="nav-link8">
                <i class="far fa-circle nav-icon"></i>
                <p>จัดการสมาชิก</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./order_pay_term.php" class="nav-link" id="nav-link9">
                <i class="far fa-circle nav-icon"></i>
                <p>กำหนดค่าเทอมค่าใช้จ่าย</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="setting_general.php" class="nav-link" id="nav-link10">
                <i class="far fa-circle nav-icon"></i>
                <p>ตั้งค่า</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>