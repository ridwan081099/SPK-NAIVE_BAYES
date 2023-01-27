<?php

  session_start();
  require_once "../koneksi.php";

  if(!$_SESSION['login']) {
      header("Location: ../index.php");
  }

  if(isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $alamat = $_POST['alamat'];
    $jenkel = $_POST['jenkel'];
    $pendapatan = $_POST['pendapatan'];
    $anak = $_POST['anak'];
    $lansia = $_POST['lansia'];
    $disabilitas = $_POST['disabilitas'];
    $hamil = $_POST['hamil'];

    $query = "INSERT INTO berkas_petugas (nama, nik, alamat, jenis_kelamin, pendapatan, anak, lansia, disabilitas, hamil) VALUES ('$nama', '$nik', '$almat', '$jenkel', '$pendapatan', '$anak', '$lansia', '$disabilitas', '$hamil')";

    $result = mysqli_query($conn, $query);

    if($result) {
      header('Location: upload_petugas.php');
    }
  }

  if(isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $alamat = $_POST['alamat'];
    $jenkel = $_POST['jenkel'];
    $pendapatan = $_POST['pendapatan'];
    $anak = $_POST['anak'];
    $lansia = $_POST['lansia'];
    $disabilitas = $_POST['disabilitas'];
    $hamil = $_POST['hamil'];
    $id = $_POST['id'];

    $query = "UPDATE berkas_petugas SET nama = '$nama', nik = '$nik', alamat = '$alamat', jenis_kelamin = '$jenkel', pendapatan = '$pendapatan', anak = '$anak', lansia = '$lansia', disabilitas = '$disabilitas', hamil = '$hamil' WHERE id = '$id'";

    $result = mysqli_query($conn, $query);

    if($result) {
      header("Location: upload_petugas.php");
    }
  }
 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tambah Upload</title>
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
                    <h4 class="card-title">Berkas Warga</h4>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah"> Tambah </button>
                    </div>
                    <table id="example1" class="table table-striped mb-4">
                      <thead>
                        <tr>
                          <th> No </th>
                          <th> Nama </th>
                          <th> NIK </th>
                          <th> Alamat </th>
                          <th> Jenis Kelamin </th>
                          <th>Pendapatan</th>
                          <th>Anak</th>
                          <th>Lansia</th>
                          <th>Disabiitas</th>
                          <th>Hamil</th>
                          <th> Opsi </th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                            $i = 1;
                            $query = "SELECT * FROM berkas_petugas";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_assoc($result)) {
                              // $id = $row['id'];
                          ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['nik'] ?></td>
                            <td><?= $row['alamat'] ?></td>
                            <td><?= $row['jenis_kelamin'] ?></td>
                            <td><?= $row['pendapatan'] ?></td>
                            <td><?= $row['anak'] ?></td>
                            <td><?= $row['lansia'] ?></td>
                            <td><?= $row['disabilitas'] ?></td>
                            <td><?= $row['hamil'] ?></td>
                            <td><button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id']; ?>">Edit</button> <a class="btn btn-danger" href="delete_berkasPetugas.php?id=<?=$row['id'];?>">Delete</a></td>

                            <form>
                              
                            </form>

                        </tr>

                        <div class="modal fade" id="edit<?= $row['id']; ?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Edit Berkas</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <form class="forms-sample" method="POST">
                                  <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                  <div class="form-group row">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Nama Warga</label>
                                    <div class="col-sm-9">
                                    <input type="text" value="<?= $row['nama'] ?>" name="nama" required class="form-control" placeholder="Nama">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">NIK</label>
                                    <div class="col-sm-9">
                                    <input type="text" value="<?= $row['nik'] ?>" name="nik" required class="form-control" id="exampleInputUsername2" placeholder="NIK">
                                    </div>
                                </div>
                                <div class="form-group row">
                                  <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Alamat</label>
                                  <div class="col-sm-9">
                                    <input type="text" value="<?= $row['alamat'] ?>" name="alamat" required class="form-control" placeholder="Alamat">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                  <div class="col-sm-9">
                                    <select required name="jenkel" class="form-select">
                                      <option value="">Pilih Jenis Kelamin</option>
                                      <option value="L">Laki-Laki</option>
                                      <option value="P">Perempuan</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Pendapatn</label>
                                  <div class="col-sm-9">
                                    <input type="number" value="<?= $row['pendapatan'] ?>" name="pendapatan" class="form-control" >
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Anak</label>
                                  <div class="col-sm-9">
                                    <input type="number" value="<?= $row['anak'] ?>" name="anak" class="form-control" >
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Lansia</label>
                                  <div class="col-sm-9">
                                    <input type="number" value="<?= $row['lansia'] ?>" name="lansia" class="form-control" >
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Disabilitas</label>
                                  <div class="col-sm-9">
                                    <input type="number" value="<?= $row['disabilitas'] ?>" name="disabilitas" class="form-control" >
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Hamil</label>
                                  <div class="col-sm-9">
                                    <input type="number" value="<?= $row['hamil'] ?>" name="hamil" class="form-control" >
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
                  <form class="forms-sample" method="POST" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Nama Warga</label>
                        <div class="col-sm-9">
                        <input type="text" name="nama" required class="form-control" placeholder="Nama">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">NIK</label>
                        <div class="col-sm-9">
                        <input type="text" name="nik" required class="form-control" id="exampleInputUsername2" placeholder="NIK">
                        </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Alamat</label>
                      <div class="col-sm-9">
                        <input type="text" name="alamat" required class="form-control" placeholder="Alamat">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                      <div class="col-sm-9">
                        <select required name="jenkel" class="form-select">
                          <option value="">Pilih Jenis Kelamin</option>
                          <option value="L">Laki-Laki</option>
                          <option value="P">Perempuan</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Pendapatn</label>
                      <div class="col-sm-9">
                        <input type="number" name="pendapatan" class="form-control" >
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Anak</label>
                      <div class="col-sm-9">
                        <input type="number" name="anak" class="form-control" >
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Lansia</label>
                      <div class="col-sm-9">
                        <input type="number" name="lansia" class="form-control" >
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Disabilitas</label>
                      <div class="col-sm-9">
                        <input type="number" name="disabilitas" class="form-control" >
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Hamil</label>
                      <div class="col-sm-9">
                        <input type="number" name="hamil" class="form-control" >
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
    
  </body>
</html>