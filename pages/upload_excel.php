<?php

    session_start();
    include '../src/SimpleXLSX.php';

    $target = basename($_FILES['file']['name']);
    $dir = move_uploaded_file($_FILES['file']['tmp_name'], $target);
    

    $xlsx = new SimpleXLSX($target);

    try {
        $conn = new PDO( "mysql:host=localhost;dbname=spk_pkh", "root", "");
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     }
     catch(PDOException $e)
     {
         echo $sql . "<br>" . $e->getMessage();
     }
     $stmt = $conn->prepare( "INSERT INTO datasets 
     (nama, jenis_kelamin, jml_tanggungan, status_rumah, jenis_bangunan, jenis_lantai, sumber_air, pendapatan, status_kelayakan) VALUES (?, ?, ?, ?, ?, ?, ? ,?, ?)");
     $stmt->bindParam( 1, $nama);
     $stmt->bindParam( 2, $jenkel);
     $stmt->bindParam( 3, $jml_tanggungan);
     $stmt->bindParam( 4, $status_rumah);
     $stmt->bindParam( 5, $jen_bangunan);
     $stmt->bindParam( 6, $jen_lantai);
     $stmt->bindParam( 7, $sumber_air);
     $stmt->bindParam( 8, $pendapatan);
     $stmt->bindParam( 9, $status);

    foreach($xlsx->rows() as $keys => $rows) {

        if($keys < 1) continue;
        $nama = $rows[0];
        $jenkel = $rows[1];
        $jml_tanggungan = $rows[2];
        $status_rumah = $rows[3];
        $jen_bangunan = $rows[4];
        $jen_lantai = $rows[5];
        $sumber_air = $rows[6];
        $pendapatan = $rows[7];
        $status = $rows[8];

        $stmt->execute();
        
    }

    header("location: dataset.php");
    unlink($_FILES['file']['name']);