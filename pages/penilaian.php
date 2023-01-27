<?php

    session_start();
    require_once "../koneksi.php";

    if(!$_SESSION['login']) {
        header("Location: ../index.php");
    }
    
    if(isset($_POST['input'])) {
      $lengt = count($_POST['kode_sub']);
      $id = $_POST['id_warga'];
      $status = 1;
      for($i = 0; $i < $lengt; $i++) {
        $hasil = explode(" ", $_POST['kode_sub'][$i]);
        mysqli_query($conn, "INSERT INTO penilaian (id_warga, kode_kriteria, nilai, status) VALUES ('$id', '$hasil[0]', '$hasil[1]', '$status')");
      }
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
                    <h4 class="card-title">Penilaian</h4>
                    <table id="example1" class="table table-striped mb-4">
                      <thead>
                        <tr>
                          <th> No </th>
                          <th> Nama Warga </th>
                          <th> Opsi </th>
                          
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                            $i = 1;
                            $query = "SELECT * FROM data_klasifikasi WHERE status_kelayakan = 'Layak'";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_assoc($result)) {
                              $idWar = $row['id'];
                              $queryStatus = mysqli_query($conn, "SELECT * FROM penilaian WHERE id_warga = '$idWar'");
                              $rowStatus = mysqli_fetch_assoc($queryStatus);
                              // $id = $row['id'];
                          ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?php if(!isset($rowStatus['status'])) { ?> <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#input<?= $row['id']; ?>">Input</button><?php } else {
                              echo "<a href='input-penilaian.php?id=$row[id]' class='btn btn-info btn-sm'><i class='mdi mdi-eye menu-icon'></i></a>";
                            } ?></td>
                        </tr>
                        <div class="modal fade" id="input<?= $row['id']?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Input Penilaian</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <?php
                                  $sqlQuery = mysqli_query($conn, "SELECT * FROM kriteria");
                                  while($r1 = mysqli_fetch_assoc($sqlQuery)) :
                                ?>
                                <form class="forms-sample" method="POST">
                                  <div class="form-group">
                                      <input type="hidden" name="id_warga" value="<?=$row['id'];?>">
                                      <label for="exampleInputEmail1"><?= $r1['nama_kriteria'] ?></label>
                                      <select name="kode_sub[]" class="form-select" required>
                                        <option value="">Pilih</option>
                                          <?php
                                              $sql = "SELECT * FROM sub_kriteria WHERE kode_kriteria='$r1[kode_kriteria]'";
                                              $show = mysqli_query($conn, $sql);
                                              
                                              while($r = mysqli_fetch_assoc($show)) {
                                                  // if($r['kode_kriteria'] == $row['kode_kriteria']) {
                                                      echo "<option value='$r[kode_kriteria] $r[nilai]'>$r[nama_kriteria]</option>";
                                                  // } else {
                                                  // }
                                              }
                                          ?>
                                      </select>
                                  </div>
                                  <?php endwhile; ?>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="input">Submit</button>
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