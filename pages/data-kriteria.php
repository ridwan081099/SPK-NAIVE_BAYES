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
    $query = "DELETE FROM data_warga";
    $result = mysqli_query($conn, $query);

    if($result) {
      header("location: data-warga.php");
    }
  }

  if(isset($_POST['tambah'])) {
      $kode = $_POST['kode'];
      $nama = $_POST['nama'];
      $bobot = $_POST['bobot'];

      $query = "INSERT INTO kriteria (kode_kriteria, nama_kriteria, bobot) VALUES ('$kode', '$nama', '$bobot')";

      $result = mysqli_query($conn, $query);

      if($result) {
        $_SESSION['message'] = 'Sukses';
        header("Location: data-kriteria.php");
      }
  }

  if(isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kode = $_POST['kode'];
    $bobot = $_POST['bobot'];

    $query = "UPDATE kriteria SET kode_kriteria = '$kode', nama_kriteria = '$nama', bobot = '$bobot' WHERE id = '$id'";

    $result = mysqli_query($conn, $query);

    if($result) {
        header("Location: data-kriteria.php");
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Data Kriteria</title>
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
                    <h4 class="card-title">Data Kriteria</h4>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah"> Tambah </button>
                    </div>
                    <table id="example1" class="table table-striped mb-4">
                      <thead>
                        <tr>
                          <th> No </th>
                          <th> Kode Kriteria </th>
                          <th> Nama Kriteria </th>
                          <th> Bobot </th>
                          <th> Opsi </th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                            $i = 1;
                            $query = "SELECT * FROM kriteria";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_assoc($result)) {
                              // $id = $row['id'];
                          ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $row['kode_kriteria'] ?></td>
                            <td><?= $row['nama_kriteria'] ?></td>
                            <td><?= $row['bobot'] ?></td>
                          <td><button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#nilai<?= $row['id']; ?>">Edit</button> <a class="btn btn-danger" href="delete_kriteria.php?id=<?=$row['id'];?>">Delete</a></td>
                        </tr>

                        <div class="modal fade" id="nilai<?= $row['id']; ?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <form class="forms-sample" method="POST">
                                  <div class="form-group row">
                                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Kode Kriteria</label>
                                      <div class="col-sm-9">
                                      <input type="text" required readonly value="<?= $row['kode_kriteria']; ?>" readonly name="kode" class="form-control" id="exampleInputUsername2" placeholder="Kode">
                                      </div>
                                  </div>
                                  <input type="hidden" value="<?= $row['id']; ?>" name="id">
                                  <div class="form-group row">
                                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Nama Kriteria</label>
                                      <div class="col-sm-9">
                                      <input type="text" name="nama" class="form-control" value="<?= $row['nama_kriteria']; ?>" placeholder="Nama Barang">
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Bobot</label>
                                      <div class="col-sm-9">
                                      <input type="text" name="bobot" class="form-control" value="<?= $row['bobot']; ?>" placeholder="Alamat">
                                      </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="update">Submit</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php }?>
                      </tbody>
                    </table>
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
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Kode Kriteria</label>
                        <div class="col-sm-9">
                        <input type="text" required name="kode" class="form-control" id="exampleInputUsername2" placeholder="Kode">
                        </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Nama Kriteria</label>
                      <div class="col-sm-9">
                        <input type="text" name="nama" class="form-control" placeholder="Nama Kriteria">
                      </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Bobot</label>
                        <div class="col-sm-9">
                        <input type="text" name="bobot" class="form-control" placeholder="Bobot">
                        </div>
                    </div>
                    <!-- <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Tanggal Beli</label>
                        <div class="col-sm-9">
                        <input type="text" name="tgl" class="form-control" required readonly value="<?= date('j F Y'); ?>">
                        </div>
                    </div> -->
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