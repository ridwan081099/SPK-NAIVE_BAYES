<?php

    session_start();
    require_once "../koneksi.php";

  if(!$_SESSION['login']) {
      header("Location: ../index.php");
  }

  // $halaman = 10;
  // $page = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
  // $mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;

  if(isset($_POST['delete'])) {
    $query = "DELETE FROM datasets";
    $result = mysqli_query($conn, $query);

    if($result) {
      header("location: dataset.php");
    }
  }

  if(isset($_POST['tambah'])) {
      $nik = $_POST['nik'];
      $nama = $_POST['nama'];
      $alamat = $_POST['alamat'];

      $query = "INSERT INTO data_warga (nik, nama, alamat) VALUES ('$nik', '$nama', '$alamat')";

      $result = mysqli_query($conn, $query);

      if($result) {
          header("Location: data-warga.php");
      }
  }

  if(isset($_POST['update'])) {
    $id = $_POST['id'];
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];

    $query = "UPDATE data_warga SET nik = '$nik', nama = '$nama', alamat = '$alamat' WHERE id = '$id'";

    $result = mysqli_query($conn, $query);

    if($result) {
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
    <title>Data Warga</title>
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
                    <h4 class="card-title">Data Set</h4>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah"> Tambah </button>
                      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete">Delete</button>
                    </div>
                    <table id="example1" class="table table-striped mb-4">
                      <thead>
                        <tr>
                          <th> No </th>
                          <th> Nama </th>
                          <th> Jenis Kelamin </th>
                          <th> Jml Tanggungan </th>
                          <th> Status Rumah </th>
                          <th> Jenis Bangunan </th>
                          <th> Jenis Lantai </th>
                          <th> Sumber Air </th>
                          <th> pendapatan </th>
                          <th> Status </th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                            $i = 1;
                            $query = "SELECT * FROM datasets ORDER BY nama ASC;";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_assoc($result)) {
                              // $id = $row['id'];
                          ?>
                        <tr>
                          <td> <?= $i++; ?> </td>
                          <td> <?= $row['nama']; ?> </td>
                          <td> <?= $row['jenis_kelamin']; ?> </td>
                          <td> <?= $row['jml_tanggungan']; ?> </td>
                          <td> <?= $row['status_rumah']; ?> </td>
                          <td> <?= $row['jenis_bangunan']; ?> </td>
                          <td> <?= $row['jenis_lantai']; ?> </td>
                          <td> <?= $row['sumber_air']; ?> </td>
                          <td> <?= $row['pendapatan']; ?> </td>
                          <td> <?= $row['status_kelayakan']; ?> </td>
                          <!-- <td><button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#edit">Edit</button> <a class="btn btn-danger" href="delete_warga.php?id=">Delete</a></td> -->
                        </tr>

                        <?php }?>
                      </tbody>
                    </table>

                    <form action="upload_excel.php" class="forms-sample" method="POST" enctype="multipart/form-data">
                      <div class="form-group-row">
                        <div class="col-lg-6 mt-4">
                          <input type="file" name="file" class="form-control">
                          <button type="submit" name="upload" class="btn btn-success mt-2">Upload</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal -->
          <div class="modal fade" id="tambah">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form class="forms-sample" method="POST">
                    <div class="form-group row">
                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Nama</label>
                      <div class="col-sm-9">
                        <input type="text" name="nama" class="form-control" placeholder="Nama Warga">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                      <div class="col-sm-9">
                        <select name="jenkel" class="form-select">
                          <option value="">Pilih Jenis Kelamin</option>
                          <option value="L">Laki-Laki</option>
                          <option value="P">Perempuan</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Jumlah Tanggungan</label>
                      <div class="col-sm-9">
                        <input type="text" name="jml_tanggung" class="form-control" placeholder="Nama Warga">
                      </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Status Rumah</label>
                        <div class="col-sm-9">
                        <select name="status_rumah" class="form-select">
                          <option value="">Pilih Status Rumah</option>
                          <option value="Kontrak">Kontrak</option>
                          <option value="Milik Sendiri">Milik Sendiri</option>
                        </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Jenis Bangunan</label>
                        <div class="col-sm-9">
                        <select name="jenis_bangunan" class="form-select">
                          <option value="">Pilih Jenis Bangunan</option>
                          <option value="Kayu">Kayu</option>
                          <option value="Tembok">Tembok</option>
                        </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Jenis Lantai</label>
                        <div class="col-sm-9">
                        <select name="jenis_lantai" class="form-select">
                          <option value="">Pilih Jenis Lantai</option>
                          <option value="Semen">Semen</option>
                          <option value="Kramik">Kramik</option>
                        </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Sumber Air</label>
                        <div class="col-sm-9">
                        <select name="sumber_air" class="form-select">
                          <option value="">Pilih Sumber Air</option>
                          <option value="Tanah">Tanah</option>
                          <option value="PDAM">PDAM</option>
                        </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Pendapatan</label>
                        <div class="col-sm-9">
                          <input type="text" name="pendapatan" class="form-control" placeholder="Pendapatan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Status Kelayakan</label>
                        <div class="col-sm-9">
                          <select name="status_kelayakan" class="form-select">
                            <option value="">Pilih</option>
                            <option value="Layak">Layak</option>
                            <option value="Tidak Layak">Tidak Layak</option>
                          </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" name="tambah">Submit</button>
                    </div>
                  </form>
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