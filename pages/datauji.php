<?php

  session_start();
  require_once "../koneksi.php";
  require '../functions.php';

  if(!$_SESSION['login']) {
      header("Location: ../index.php");
  }

//   if(isset($_POST['uji'])) {
//       // Hitung total jumlah dataset 
//       $sql = mysqli_query($conn, "SELECT * FROM datasets ORDER BY id");
      
//       $arr_atribut = array();
//       $arr_label = array();
    
//       while($row = mysqli_fetch_row($sql)) {
//         array_push($arr_atribut, array_slice($row, 2, count($row)-1));
//         array_push($arr_label, $row[count($row)-1]);
//       }
    
//       $dataset = new ArrayDataset($arr_atribut, $arr_label);
    
//       $samples = $dataset->getSamples();
//       $targets = $dataset->getTargets();
    
//       $form_value = $_POST;
      
//       $formValue = array_slice($form_value, 1, count($form_value)-2);
//       $formValue = array_values($formValue);
      
//       $klasifikasi = new NaiveBayes();
//       $klasifikasi->train($samples, $targets);
//       $hasil = $klasifikasi->predict($formValue);

//       var_dump($hasil);die;
      
//   }

    if(isset($_POST['prediksi'])) {
      $data = [
        'jenis_kelamin' => $_POST['jenis_kelamin'],
        'jml_tanggungan' => $_POST['jml_tanggungan'],
        'status_rumah' => $_POST['status_rumah'],
        'jenis_bangunan' => $_POST['jenis_bangunan'],
        'jenis_lantai' => $_POST['jenis_lantai'],
        'sumber_air' => $_POST['sumber_air'],
        'pendapatan' => $_POST['pendapatan']
      ];

      $nama = $_POST['nama'];
      $jenkel = $_POST['jenis_kelamin'];
      $jml_tanggungan = $_POST['jml_tanggungan'];
      $status_rumah = $_POST['status_rumah'];
      $jen_bangunan = $_POST['jenis_bangunan'];
      $jen_lantai = $_POST['jenis_lantai'];
      $sumber_air = $_POST['sumber_air'];
      $pendapatan = $_POST['pendapatan'];
      $hasil = posteriorProbability($data);

      $result = mysqli_query($conn, "INSERT INTO data_klasifikasi (`nama`, `jenis_kelamin`, `jml_tanggungan`, `status_rumah`, `jenis_bangunan`, `jenis_lantai`, `sumber_air`, `pendapatan`, `status_kelayakan`) VALUES ('$nama', '$jenkel', '$jml_tanggungan', '$status_rumah', '$jen_bangunan', '$jen_lantai', '$sumber_air', '$pendapatan', '$hasil')");
      
      if($result) {
        $_SESSION['message'] = $hasil;
        header("Location: hitung.php");  
      }
    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Data Uji</title>
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
      <!-- partial:../../partials/_navbar.html -->
      <?php include '../partials/_navbar.php'; ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_sidebar.html -->
        <?php include '../partials/_sidebar.php' ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title mb-5">Klasifikasi Naive Bayes</h4>
                    <form class="forms-sample" method="POST">
                      <div class="form-group">
                        <label for="exampleInputUsername1">Nama</label>
                        <input type="text" required class="form-control" id="exampleInputUsername1" placeholder="Nama Warga" name="nama">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" required class="form-select form-control-lg">
                          <option value="">Pilih Jenis Kelamin</option>
                          <option value="L">Laki-laki</option>
                          <option value="P">Perempuan</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Jumlah Tanggungan</label>
                        <input type="number" required class="form-control" id="exampleInputEmail1" placeholder="Jumlah Tanggungan" name="jml_tanggungan">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Status Rumah</label>
                        <select name="status_rumah" required class="form-select">
                          <option value="">Pilih Status Rumah</option>
                          <option value="Milik Sendiri">Milik Sendiri</option>
                          <option value="Kontrak">Kontrak</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Jenis Bangunan</label>
                        <select name="jenis_bangunan" required class="form-select">
                          <option value="">Pilih Jenis Bangunan</option>
                          <option value="Tembok">Tembok</option>
                          <option value="Kayu">Kayu</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Jenis Lantai</label>
                        <select name="jenis_lantai" required class="form-select">
                          <option value="">Pilih Jenis Lantai</option>
                          <option value="Semen">Semen</option>
                          <option value="Tanah">Tanah</option>
                          <option value="Kramik">Kramik</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Sumber Air</label>
                        <select name="sumber_air" required class="form-select">
                          <option value="">Pilih Sumber Air</option>
                          <option value="Tanah">Tanah</option>
                          <option value="PDAM">PDAM</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Pendapatan</label>
                        <input type="number" required class="form-control" id="exampleInputEmail1" placeholder="Pendapatan" name="pendapatan">
                      </div>

                      <button class="btn btn-primary" type="submit" name="prediksi" target="_blank">Submit</button>
                    </form>

                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal -->
          <div class="modal fade" id="hasil">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hasil Data Klasifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <table class="table table-striped">
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
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="delete">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Semua Data Materials</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>Apakah anda yakin?</p>
                  <div class="modal-footer justify-content-center">
                    <form class="forms-sample" method="POST">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                      <button type="submit" class="btn btn-primary" name="delete">Ya</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <?php include '../partials/_footer.php' ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
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
    <!-- End custom js for this page -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
          $('#example1').DataTable({
            search: false
          });
      });
    </script>
  </body>
</html>