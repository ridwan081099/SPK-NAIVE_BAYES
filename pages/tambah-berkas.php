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

    $nama_file = $_FILES['berkas']['name'];
    $targetDir = '../assets/uploads/' . $nama_file;
    $file_ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

    $allowed_ext = array('pdf', 'jpg', 'jpeg', 'png');
    // var_dump();die;
    // move_uploaded_file(filename, destination);

    if(in_array($file_ext, $allowed_ext)) {
      move_uploaded_file($_FILES['berkas']['tmp_name'], $targetDir);
      
        $query = "INSERT INTO berkas_warga (nama, nik, alamat, jenis_kelamin, file_berkas) VALUES ('$nama', '$nik', '$alamat', '$jenkel', '$nama_file')";

        $result = mysqli_query($conn, $query);

        if($result) {
          header('Location: tambah-berkas.php');
        }
    } else {
      print_r("File harus berekstensi pdf, jpg, jpeg");
    }
  }

  if(isset($_POST['ubah'])) {
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $alamat = $_POST['alamat'];
    $jenkel = $_POST['jenkel'];
    $id = $_POST['id'];

    // var_dump($id);die;     

    $query = "UPDATE berkas_warga SET nama = '$nama', nik = '$nik', alamat = '$alamat', jenis_kelamin = '$jenkel' WHERE id = '$id'";

    $result = mysqli_query($conn, $query);

    if($result) {
      header("Location: tambah-berkas.php");
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tambah Berkas Warga</title>
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
                          <th> Berkas </th>
                          <th> Opsi </th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                            $i = 1;
                            $query = "SELECT * FROM berkas_warga";
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
                            <td><?= '../assets/uploads/' . $row['file_berkas'] ?></td>
                            <td><button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id']; ?>">Edit</button> <a class="btn btn-danger" href="delete_berkasWarga.php?id=<?=$row['id'];?>">Delete</a></td>

                        </tr>

                        <div class="modal fade" id="edit<?= $row['id']; ?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Edit Berkas Warga</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <form class="forms-sample" method="POST">
                                  <input type="hidden" name="id" value="<?= $row['id']?>">
                                  <div class="form-group row">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Nama Warga</label>
                                    <div class="col-sm-9">
                                    <input type="text" name="nama" value="<?= $row['nama'] ?>" required class="form-control" placeholder="Nama">
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">NIK</label>
                                      <div class="col-sm-9">
                                      <input type="number" name="nik" value="<?= $row['nik'] ?>" required class="form-control" id="exampleInputUsername2" placeholder="NIK">
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Alamat</label>
                                    <div class="col-sm-9">
                                      <input type="text" name="alamat" value="<?= $row['alamat'] ?>" required class="form-control" placeholder="Alamat">
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-9">
                                      <select required name="jenkel" class="form-select">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                      </select>
                                    </div>
                                  </div>                                  
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="ubah">Submit</button>
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
                        <input type="number" name="nik" required class="form-control" id="exampleInputUsername2" placeholder="NIK">
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
                          <option value="L">Laki-laki</option>
                          <option value="P">Perempuan</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Berkas</label>
                      <div class="col-sm-9">
                        <input type="file" name="berkas" class="form-control" >
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