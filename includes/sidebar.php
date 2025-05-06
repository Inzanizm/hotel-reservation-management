<?php
$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/")+1);
?>

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark d-flex flex-column justify-content-between" id="sidenav-main">
  <div>
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="#">
        <span class="ms-1 font-weight-bold text-white">Manage Resort</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white <?= $page == "dashboard.php" ? 'active bg-gradient-dark text-white':''; ?>" href="dashboard.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-symbols-rounded opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white <?= $page == "reservation.php" ? 'active bg-gradient-dark text-white':''; ?>" href="reservation.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-symbols-rounded opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Reservation</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white <?= $page == "rooms.php" ? 'active bg-gradient-dark text-white':''; ?>" href="rooms.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-symbols-rounded opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Rooms</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white <?= $page == "guest-info.php" ? 'active bg-gradient-dark text-white':''; ?>" href="guest-info.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-symbols-rounded opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Guest Information</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white <?= $page == "payments.php" ? 'active bg-gradient-dark text-white':''; ?>" href="payments.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-symbols-rounded opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Payments & Billing</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white <?= $page == "reports.php" ? 'active bg-gradient-dark text-white':''; ?>" href="reports.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-symbols-rounded opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Audit Log</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white <?= $page == "user-management.php" ? 'active bg-gradient-dark text-white':''; ?>" href="user-management.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-symbols-rounded opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">User Management</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white <?= $page == "inquiries_list.php" ? 'active bg-gradient-dark text-white':''; ?>" href="inquiries_list.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-symbols-rounded opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Email Inquiry & FAQs</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
  <div class="sidenav-footer w-100 mb-3">
    <div class="mx-3">
      <a class="btn bg-gradient-primary mt-4 w-100" href="logout.php" type="button">LOGOUT</a>
    </div>
  </div>
</aside>
