<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Kelurahan Ujung Menteng</title>
  </head>
  <body>
    <div class="container mt-5">
        <h2 class="text-center">Kelurahan Ujung Menteng</h2>
        <p class="text-center">Nama Peserta Yang Mendapatkan Bantuan Dari Pemerintah Jenis Bantuan PKH Layak dan Tidak Layak</p> 
        <p class="text-center">Kecamatan Cakung, Jakarta Timur, DKI Jakarta, Daerah Khusus Ibukota Jakarta 13930.</p>

        <table class="table table-striped">
            <thead>
                <tr class="text-center">
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
                <?php
                require_once '../koneksi.php';

                    $i = 1;
                    $query = "SELECT * FROM data_klasifikasi WHERE status_kelayakan = 'Layak' ORDER BY nama ASC";
                    $result = mysqli_query($conn, $query);

                    while($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr class="text-center">
                    <td><?= $i++; ?></td>
                    <td> <?= $row['nama']; ?> </td>
                    <td><?= $row['jenis_kelamin']; ?></td>
                    <td> <?= $row['jml_tanggungan']; ?> </td>
                    <td> <?= $row['status_rumah']; ?> </td>
                    <td> <?= $row['jenis_bangunan']; ?> </td>
                    <td> <?= $row['jenis_lantai']; ?> </td>
                    <td> <?= $row['sumber_air']; ?> </td>
                    <td> <?= $row['pendapatan']; ?> </td>
                    <td> <?= $row['status_kelayakan']; ?> </td>     
                </tr>
                <?php } ?>
            </thead>
        </table>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        window.print();
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>


