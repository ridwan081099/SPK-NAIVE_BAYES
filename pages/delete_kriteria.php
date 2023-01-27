<?php 

    require_once '../koneksi.php';
    $id = $_GET['id'];

    $query = mysqli_query($conn, "DELETE FROM kriteria WHERE id = '$id'");

    if($query) {
        header('Location: data-kriteria.php');
    }