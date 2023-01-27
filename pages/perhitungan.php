<?php

    session_start();
    require_once "../koneksi.php";
    require '../functions.php';

  if(!$_SESSION['login']) {
      header("Location: ../index.php");
  }

  $hapus_hasil = mysqli_query($conn, "DELETE FROM hasil_maut");
  $reset = mysqli_query($conn, "ALTER TABLE hasil_maut AUTO_INCREMENT=0");

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
              <div class="col-lg-12 stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Data Evaluasi Berdasarkan Penilaian </h4>
                    <table id="example1" class="table table-striped ">
                      <thead>
                        <tr>
                          <th> No </th>
                          <th> Nama </th>
                          <th> C1 </th>
                          <th> C2 </th>
                          <th> C3 </th>
                          <th> C4 </th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                            $i = 1;
                            $sqlQuery = mysqli_query($conn, "SELECT * FROM kriteria");
                            $r = mysqli_fetch_assoc($sqlQuery);

                            $query = "SELECT * FROM penilaian p JOIN data_klasifikasi d ON p.id_warga = d.id GROUP BY id_warga";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_assoc($result)) {
                              $id_warga = $row['id'];
                          ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $row['nama'] ?></td>
                                <?php 
                                    $resultNilai = mysqli_query($conn, "SELECT * FROM penilaian p JOIN kriteria k ON p.kode_kriteria = k.kode_kriteria WHERE id_warga = '$id_warga' ORDER BY k.kode_kriteria");
                                    while($rowNilai = mysqli_fetch_assoc($resultNilai)) {
                                        echo "<td>$rowNilai[nilai]</td>";
                                    }
                                ?>
                        </tr>
                        <?php }?>
                      </tbody>
                      <tfoot>
                        <tr>
                            <td colspan="2">Nilai Max</td>
                            <?php
                              $queryKriteria = mysqli_query($conn, "SELECT * FROM kriteria");

                              while($rowMaxNilai = mysqli_fetch_assoc($queryKriteria)) {
                                echo "<td>" . maxPenilaian($rowMaxNilai['kode_kriteria']) . "</td>";
                              }
                            ?>
                        </tr>
                        <tr>
                            <td colspan="2">Nilai min</td>
                            <?php
                              $queryKriteria = mysqli_query($conn, "SELECT * FROM kriteria");

                              while($rowMinNilai = mysqli_fetch_assoc($queryKriteria)) {
                                echo "<td>" . minPenilaian($rowMinNilai['kode_kriteria']) . "</td>";
                              }
                            ?>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Data Normalisasi Matrik</h4>
                    
                    <table id="example1" class="table table-striped ">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Nama</td>
                                <td>C1</td>
                                <td>C2</td>
                                <td>C3</td>
                                <td>C4</td>
                            </tr>
                        </thead>
                        <tbody>
                              <?php
                                $query = "SELECT * FROM penilaian p JOIN data_klasifikasi d ON p.id_warga = d.id GROUP BY id_warga";
                                $result = mysqli_query($conn, $query);
                                $i =1;
                                while($row = mysqli_fetch_assoc($result)) {
                                  $id_warga = $row['id'];
                                  ?>
                            <tr>
                              <td><?= $i++;?></td>
                              <td><?= $row['nama'] ?></td>
                              <?php
                                $resultNilai = mysqli_query($conn, "SELECT * FROM penilaian p JOIN kriteria k ON p.kode_kriteria = k.kode_kriteria WHERE id_warga = '$id_warga' ORDER BY k.kode_kriteria");
                                while($rowNilai = mysqli_fetch_assoc($resultNilai)) {
                                  $nilai = intval($rowNilai['nilai']);
                                  
                                  $hasil = round(($nilai-minPenilaian($rowNilai['kode_kriteria']))/(maxPenilaian($rowNilai['kode_kriteria']) - minPenilaian($rowNilai['kode_kriteria'])), 2);
                                  
                                  echo "<td>" . $hasil . "</td>";
                                }
                              ?>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                  
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Data Nilai Evaluasi</h4>
                    
                    <table id="example1" class="table table-striped ">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Nama</td>
                                <td>C1</td>
                                <td>C2</td>
                                <td>C3</td>
                                <td>C4</td>
                                <td>Preferensi</td>
                            </tr>
                        </thead>
                        <tbody>
                              <?php
                                $query = "SELECT * FROM penilaian p JOIN data_klasifikasi d ON p.id_warga = d.id GROUP BY id_warga";
                                $result = mysqli_query($conn, $query);
                                $i =1;
                                $totalArr = array();
                                while($row = mysqli_fetch_assoc($result)) {
                                  $id_warga = $row['id'];
                              ?>
                            <tr>
                              <td><?= $i++;?></td>
                              <td><?= $row['nama'] ?></td>
                              <?php
                                  $resultNilai = mysqli_query($conn, "SELECT * FROM penilaian p JOIN kriteria k ON p.kode_kriteria = k.kode_kriteria WHERE id_warga = '$id_warga' ORDER BY k.kode_kriteria");
                                  $total = 0;
                                  $totalRank = 0;
                                  while($rowNilai = mysqli_fetch_assoc($resultNilai)) {
                                    $nilai = intval($rowNilai['nilai']);
                                    
                                    $hasil = round(($nilai-minPenilaian($rowNilai['kode_kriteria']))/(maxPenilaian($rowNilai['kode_kriteria']) - minPenilaian($rowNilai['kode_kriteria'])), 2);
                                    
                                    $id_war = $rowNilai['id_warga'];
                                    $total = normalisasiNilaiBobot($rowNilai['kode_kriteria']) * $hasil;
                                    $totalRank = $totalRank + $total;
                                    
                                    echo "<td>(" . round(normalisasiNilaiBobot($rowNilai['kode_kriteria']), 2) . " * " . round($hasil, 2) . ")</td>";

                                  }
                                  echo "<td>" . round($totalRank, 2) . "</td>"
                                ?>
                            </tr>
                            <?php
                            
                            mysqli_query($conn, "INSERT INTO hasil_maut(id_warga, preferensi) VALUES('$id_war', '$totalRank')");
                            
                            } ?>  
                        </tbody>
                    </table>
                  
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Hasil ranking berdasarkan perhitungan MAUT</h4>
                    
                    <table id="example1" class="table table-striped ">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Nama</td>
                                <td>Rank</td>
                            </tr>
                        </thead>
                        <tbody>
                              <?php
                                $query = "SELECT * FROM hasil_maut h JOIN data_klasifikasi d ON h.id_warga = d.id ORDER BY preferensi DESC";
                                $result = mysqli_query($conn, $query);
                                $i =1;
                                $totalArr = array();
                                while($row = mysqli_fetch_assoc($result)) {
                              ?>
                            <tr>
                              <td><?= $i++;?></td>
                              <td><?= $row['nama'] ?></td>
                              <td><?= round($row['preferensi'], 2) ?></td>
                            </tr>
                            <?php } ?>  
                        </tbody>
                    </table>
                  
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal -->
          
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