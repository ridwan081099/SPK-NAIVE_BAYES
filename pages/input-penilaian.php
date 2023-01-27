<?php

    session_start();
    require_once "../koneksi.php";

  if(!$_SESSION['login']) {
      header("Location: ../index.php");
  }

  $id = $_GET['id'];
  $query = mysqli_query($conn, "SELECT * FROM data_klasifikasi WHERE id = '$id'");
  $nama = mysqli_fetch_assoc($query);

  if(isset($_POST['kode_sub'])) {
    $idSubKriteria = $_POST['kode_sub'];
    $sql = "SELECT * FROM sub_kriteria WHERE id = '$idSubKriteria'";
    $idNilai = $_POST['id_nilai'];

    $update = mysqli_query($conn, $sql);
    $r = mysqli_fetch_assoc($update);
    $nilai = $r['nilai'];

    $result = mysqli_query($conn, "SELECT * FROM kriteria");
    mysqli_query($conn, "UPDATE penilaian SET nilai = '$nilai' WHERE id_nilai = '$idNilai'");
  }


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Penilaian</title>
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
                    <h4 class="card-title">Isi Data Penilaian <?= $nama['nama']; ?></h4>
                    <a href="penilaian.php" class="btn btn-success mb-4">Kembali</a>
                    <?php
                        // var_dump($idSubKriteria); 
                        
                        $query = mysqli_query($conn, "SELECT * FROM penilaian AS p JOIN kriteria AS k ON p.kode_kriteria = k.kode_kriteria WHERE id_warga = '$id'");

                        while($row = mysqli_fetch_assoc($query)) {
                    ?>
                    <form class="forms-sample" method="POST">
                        <input type="hidden" name="id_nilai" value="<?php echo $row['id_nilai']; ?>">
                        <form class="forms-sample" method="GET" action="">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?= $row['nama_kriteria'] ?></label>
                                <select name="kode_sub" class="form-control" onchange="this.form.submit()">
                                <option value="">Pilih Kriteria</option>
                                    <?php
                                        $sql = "SELECT * FROM sub_kriteria WHERE kode_kriteria='$row[kode_kriteria]'";
                                        $show = mysqli_query($conn, $sql);
                                        
                                        while($r = mysqli_fetch_assoc($show)) {
                                            if($r['kode_kriteria'] == $row['kode_kriteria']) {
                                                echo "<option value='$r[id]'>$r[nama_kriteria]</option>";
                                            } else {
                                                echo "<option value='$r[id]'>$r[nama_kriteria]</option>";
                                            }
                                        }
    
                                    ?>
                                </select>
                            </div>
                        </form>
                    </form>
                    <?php } ?>
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
        function status(value, id) {
            alert(value);
        }
    </script>
  </body>
</html>