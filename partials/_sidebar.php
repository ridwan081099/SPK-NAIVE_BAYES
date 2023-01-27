<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2"><?= $_SESSION['name']; ?></span>
          <span class="text-secondary text-small"><?= $_SESSION['role']; ?></span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="home.php">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>
    <?php 
      if($_SESSION['role'] === 'Admin') {
    ?>
    <li class="nav-item">
      <a class="nav-link" href="users.php">
        <span class="menu-title">Data User</span>
        <i class="mdi mdi-account-circle menu-icon"></i>
      </a>
    </li>
    <?php
     } if($_SESSION['role'] === 'Warga') {
    ?>
    <li class="nav-item">
      <a class="nav-link" href="tambah-berkas.php">
        <span class="menu-title">Data Upload Warga</span>
        <i class="mdi mdi-account menu-icon"></i>
      </a>
    </li>
    <?php } if ($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Petugas') { ?>
    <li class="nav-item">
      <a class="nav-link" href="dataset.php">
        <span class="menu-title">Dataset Warga</span>
        <i class="mdi mdi-folder-multiple menu-icon"></i>
      </a>
    </li>
    <?php } if($_SESSION['role'] === 'Petugas')  { ?>
    <li class="nav-item">
      <a class="nav-link" href="upload_petugas.php">
        <span class="menu-title">Data Upload Petugas</span>
        <i class="mdi mdi-account menu-icon"></i>
      </a>
    </li>
    <?php 
      }
      if ($_SESSION['role'] === 'Admin') {
     ?>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <span class="menu-title">Kriteria</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-code-equal menu-icon"></i>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="data-kriteria.php">Data Kriteria</a></li>
          <li class="nav-item"> <a class="nav-link" href="data-subkriteria.php">Data Sub Kriteria</a></li>
        </ul>
      </div>
    </li>
    <?php 
    }
      if($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Kepala') :
    ?>
    <li class="nav-item">
      <a class="nav-link" href="datauji.php">
        <span class="menu-title">Klasifikasi Data</span>
        <i class="mdi mdi-monitor-multiple menu-icon"></i>
      </a>
    </li>
    <?php endif; ?>
    <?php
      if ($_SESSION['role'] === 'Admin') {
    ?>
    <li class="nav-item">
      <a class="nav-link" href="penilaian.php">
        <span class="menu-title">Penilaian</span>
        <i class="mdi mdi-checkbox-marked-outline menu-icon"></i>
      </a>
    </li>
    <?php 
    }
      if($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Kepala' || $_SESSION['role'] === 'Warga') :
    ?>
    <li class="nav-item">
      <a class="nav-link" href="perhitungan.php">
        <span class="menu-title">Data Penilaian MAUT</span>
        <i class="mdi mdi-calculator menu-icon"></i>
      </a>
    </li>
    <?php endif; ?>
    <li class="nav-item">
      <a class="nav-link" href="laporan.php">
        <span class="menu-title">Laporan</span>
        <i class="mdi mdi-content-paste menu-icon"></i>
      </a>
    </li>
</nav>