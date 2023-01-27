<?php

    require 'koneksi.php';

    function jmlBobot() {
        global $conn;

        return (int) mysqli_fetch_row(mysqli_query($conn, "SELECT SUM(bobot) FROM kriteria"))[0];
    }

    function nilaiKriteria($kode) {
        global $conn;
        $sql = "SELECT bobot FROM kriteria WHERE kode_kriteria= '$kode'";

        $nilai = (int) mysqli_fetch_row(mysqli_query($conn, $sql))[0];

        return $nilai;
    }
    
    function normalisasiNilaiBobot($kode) {
        $nilai = nilaiKriteria($kode) / jmlBobot();

        return $nilai;
    }
    
    function maxPenilaian($kode) {
        global $conn;

        $sql = "SELECT MAX(nilai) FROM penilaian WHERE kode_kriteria= '$kode'";    
        
        $max = (int) mysqli_fetch_row(mysqli_query($conn, $sql))[0];
        return $max;
    }

    function minPenilaian($kode) {
        global $conn;

        $sql = "SELECT MIN(nilai) FROM penilaian WHERE kode_kriteria= '$kode'";    
        
        $max = (int) mysqli_fetch_row(mysqli_query($conn, $sql))[0];
        return $max;
    }

    function getNilaiUser($id) {
        global $conn;

        $sql = "SELECT nilai FROM penilaian p JOIN kriteria k ON p.kode_kriteria = k.kode_kriteria WHERE id_warga = '$id' ORDER BY k.kode_kriteria";

        $getNilai = (int) mysqli_fetch_row(mysqli_query($conn, $sql))[0];

        return $getNilai;
    }

    // function normalisasiKriteriaUser($id) {
    //     $normal['C1'] = (getNilaiUser($id)['C1'] - minPenilaian()['C1'])/(maxPenilaian()['C1']-minPenilaian()['C1']);
    //     $normal['C2'] = (getNilaiUser($id)['C2'] - minPenilaian()['C2'])/(maxPenilaian()['C2']-minPenilaian()['C2']);
    //     $normal['C3'] = (getNilaiUser($id)['C3'] - minPenilaian()['C3'])/(maxPenilaian()['C3']-minPenilaian()['C3']);
    //     $normal['C4'] = (getNilaiUser($id)['C4'] - minPenilaian()['C4'])/(maxPenilaian()['C4']-minPenilaian()['C4']);

    //     return $normal;
    // }
    
    // function preferensiNilai($id) {
    //     $preferensi = (normalisasiNilaiBobot()['C1'] * normalisasiKriteriaUser($id)['C1'])+(normalisasiNilaiBobot()['C2'] * normalisasiKriteriaUser($id)['C2']) + (normalisasiNilaiBobot()['C3'] * normalisasiKriteriaUser($id)['C3']) + (normalisasiNilaiBobot()['C4'] * normalisasiKriteriaUser($id)['C4']);

    //     return $preferensi;
    // }

    function totalDataset() {
        global $conn;
        
        return (int) mysqli_fetch_row(mysqli_query($conn, "SELECT count(*) FROM datasets"))[0];
    }

    function jmlStatusKelayakan() {
        global $conn;
        $sql = "SELECT count(*) FROM datasets WHERE status_kelayakan=";

        $status['Layak'] = (int) mysqli_fetch_row(mysqli_query($conn, $sql . "'Layak'"))[0];
        $status['Tidak Layak'] = (int) mysqli_fetch_row(mysqli_query($conn, $sql . "'Tidak Layak'"))[0];

        return $status;
    }


    function priorProbability() {
        $penerima['Layak'] = jmlStatusKelayakan()['Layak'] / totalDataset();
        $penerima['Tidak Layak'] = jmlStatusKelayakan()['Tidak Layak'] / totalDataset();

        return $penerima;
    }

    function conditionalProbability($nama_kolom, $nilai) {
        global $conn;

        if($nama_kolom == 'pendapatan') {
            $kat = '';
            if($nilai > 3500000) {
                $kat = 'tinggi';
            } elseif($nilai >= 1500000 && $nilai <= 2500000) {
                $kat = 'sedang';
            } elseif($nilai < 1500000) {
                $kat = 'rendah';
            }
            $query = "SELECT count(*) as jml FROM (
                SELECT pendapatan, status_kelayakan,
                CASE
                WHEN pendapatan > 3000000 THEN 'tinggi'
                WHEN pendapatan >= 1500000 AND pendapatan <= 2500000 THEN 'sedang'
                WHEN pendapatan < 1500000 THEN 'rendah'
                ELSE ''
                END AS c_jml_penghasilan
                FROM datasets 
                ) as conversi_jml_penghasilan  WHERE c_jml_penghasilan ='$kat' AND status_kelayakan =";

        } else {
            $query = "SELECT COUNT($nama_kolom) FROM datasets WHERE $nama_kolom = '$nilai' AND status_kelayakan=";
        }

            $condProbab['Layak'] = (int) mysqli_fetch_row(mysqli_query($conn, $query . "'Layak'"))[0] / jmlStatusKelayakan()['Layak']; 
            $condProbab['Tidak Layak'] = (int) mysqli_fetch_row(mysqli_query($conn, $query . "'Tidak Layak'"))[0] / jmlStatusKelayakan()['Tidak Layak']; 

            return $condProbab;

    }

    function posteriorProbability($data) {
        $atribut['jenis_kelamin'] = conditionalProbability('jenis_kelamin', $data['jenis_kelamin']);
        $atribut['jml_tanggungan'] = conditionalProbability('jml_tanggungan', $data['jml_tanggungan']);
        $atribut['status_rumah'] = conditionalProbability('status_rumah', $data['status_rumah']);
        $atribut['jenis_bangunan'] = conditionalProbability('jenis_bangunan', $data['jenis_bangunan']);
        $atribut['jenis_lantai'] = conditionalProbability('jenis_lantai', $data['jenis_lantai']);
        $atribut['sumber_air'] = conditionalProbability('sumber_air', $data['sumber_air']);
        $atribut['pendapatan'] = conditionalProbability('pendapatan', $data['pendapatan']);

        $probabilitas['Layak'] = $atribut['jenis_kelamin']['Layak'] * $atribut['jml_tanggungan']['Layak'] * $atribut['status_rumah']['Layak'] * $atribut['jenis_bangunan']['Layak'] * $atribut['jenis_lantai']['Layak'] * $atribut['sumber_air']['Layak'] * $atribut['pendapatan']['Layak'] * priorProbability()['Layak'];

        $probabilitas['Tidak Layak'] = $atribut['jenis_kelamin']['Tidak Layak'] * $atribut['jml_tanggungan']['Tidak Layak'] * $atribut['status_rumah']['Tidak Layak'] * $atribut['jenis_bangunan']['Tidak Layak'] * $atribut['jenis_lantai']['Tidak Layak'] * $atribut['sumber_air']['Tidak Layak'] * $atribut['pendapatan']['Tidak Layak'] * priorProbability()['Tidak Layak'];

        if($probabilitas['Layak'] > $probabilitas['Tidak Layak']) {
          return "Layak";
        } else {
          return "Tidak Layak";
        }        
    }
    