<?php 

session_start();

require_once '../functions.php';
require '../koneksi.php';

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Perhitungan Naive Bayes</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Hasil Klasifikasi</h4>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                      <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#tambah"><a href="datauji.php">Kembali </a></button>
                    </div>
                    <?php
                      if(isset($_SESSION['message'])) :
                    ?>
                        <div class="alert alert-success" role="alert">
                          Dapat disimpulkan Bahwa Warga Dari Hasil Klasifikasi <u><?= $_SESSION['message']; ?></u> Dapat Bantuan Dari Pemerintah.
                        </div>
                    <?php unset($_SESSION['message']); endif; ?>
                    <table class="table table-bordered table-striped mb-4">
                      <thead>
                        <tr>
                          <td>Jumlah Data</td>
                          <td>Layak</td>
                          <td>Tidak Layak</td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><?= totalDataset(); ?></td>
                          <td><?= jmlStatusKelayakan()['Layak']; ?></td>
                          <td><?= jmlStatusKelayakan()['Tidak Layak']; ?></td>
                        </tr>
                      </tbody>
                    </table>
                    ----Probabilitas Prior-----<br>
                    <table class="mt-2 table table-bordered table-striped mb-3">
                      <thead>
                        <tr>
                          <td>Layak</td>
                          <td>Tidak Layak</td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><?= priorProbability()['Layak']; ?></td>
                          <td><?= priorProbability()['Tidak Layak']; ?></td>
                        </tr>
                      </tbody>
                    </table>
                    ----Probabilitas Data Klasifikasi-----<br>
                    <table class="mt-2 table table-bordered table-striped">
                      <thead>
                        <tr>
                          <td></td>
                          <td>Jenis Kelamin</td>
                          <td>Jml Tanggungan</td>
                          <td>Status Rumah</td>
                          <td>Jenis Bangunan</td>
                          <td>Jenis Lantai</td>
                          <td>Sumber Air</td>
                          <td>Pendapatan</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $query = mysqli_query($conn, "SELECT * FROM data_klasifikasi ORDER BY id DESC LIMIT 1");

                          $row = mysqli_fetch_assoc($query);
                        ?>
                        <tr>
                          <td>Layak</td>
                          <td><?= conditionalProbability('jenis_kelamin', $row['jenis_kelamin'])['Layak']; ?></td>
                          <td><?= conditionalProbability('jml_tanggungan', $row['jml_tanggungan'])['Layak']; ?></td>
                          <td><?= conditionalProbability('status_rumah', $row['status_rumah'])['Layak']; ?></td>
                          <td><?= conditionalProbability('jenis_bangunan', $row['jenis_bangunan'])['Layak']; ?></td>
                          <td><?= conditionalProbability('jenis_lantai', $row['jenis_lantai'])['Layak']; ?></td>
                          <td><?= conditionalProbability('sumber_air', $row['sumber_air'])['Layak']; ?></td>
                          <td><?= conditionalProbability('pendapatan', $row['pendapatan'])['Layak']; ?></td>
                        </tr>
                        <tr>
                          <td>Tidak Layak</td>
                          <td><?= conditionalProbability('jenis_kelamin', $row['jenis_kelamin'])['Tidak Layak']; ?></td>
                          <td><?= conditionalProbability('jml_tanggungan', $row['jml_tanggungan'])['Tidak Layak']; ?></td>
                          <td><?= conditionalProbability('status_rumah', $row['status_rumah'])['Tidak Layak']; ?></td>
                          <td><?= conditionalProbability('jenis_bangunan', $row['jenis_bangunan'])['Tidak Layak']; ?></td>
                          <td><?= conditionalProbability('jenis_lantai', $row['jenis_lantai'])['Tidak Layak']; ?></td>
                          <td><?= conditionalProbability('sumber_air', $row['sumber_air'])['Tidak Layak']; ?></td>
                          <td><?= conditionalProbability('pendapatan', $row['pendapatan'])['Tidak Layak']; ?></td>
                        </tr>
                      </tbody>
                    </table>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
      <!-- endinject -->
      <!-- Plugin js for this page -->
      <!-- End plugin js for this page -->
      <!-- inject:js -->
      <script src="../assets/js/off-canvas.js"></script>
      <script src="../assets/js/hoverable-collapse.js"></script>
      <script src="../assets/js/misc.js"></script>
      <!-- endinject -->
      <!-- Custom js for this page -->
      <script src="../assets/js/file-upload.js"></script>
  
      <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  </body>
  <!-- plugins:js -->
</html>