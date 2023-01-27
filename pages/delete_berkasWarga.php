<?php

	require_once '../koneksi.php';

	$id = $_GET['id'];

	$query = "DELETE FROM berkas_warga WHERE id = '$id'";

	$result = mysqli_query($conn, $query);

	if($result) {
		header("Location: tambah-berkas.php");
	}