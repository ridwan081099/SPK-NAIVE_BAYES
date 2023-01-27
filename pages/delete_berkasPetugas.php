<?php

	$id = $_GET['id'];

	$result = mysqli_query($conn, "DELETE FROM berkas_petugas WHERE id = '$id'");

	if($result) {
		header("Location: upload_petugas.php");
	}