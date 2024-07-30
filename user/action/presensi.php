<?php
session_start();
include('../../config.php');
date_default_timezone_set('Asia/Jakarta');
if (isset($_POST['masuk'])) {
    $id = $_SESSION['id_user'];
    $tanggal = date('Y-m-d H:i:s');
    $sekarang = date('H:i:s');
    $telat = date('H');
    $ipAddress = gethostbyname(gethostname());
    $cariIp = "SELECT * FROM tb_ip WHERE id = 1";
    $ip = 0;
    if (mysqli_query($db, $cariIp)->num_rows > 0) {
        $data = mysqli_query($db, $cariIp)->fetch_assoc();
        $ip = $data['ip'];
    }
    if ($ipAddress == $ip) {
        if ($telat <= '10') {
            $sql = "INSERT INTO tb_presensi(nis, masuk, status) VALUES ($id, '$tanggal', 'hadir')";
            $query = mysqli_query($db, $sql);
            if ($query) {
                $_SESSION['pesan'] = "Berhasil Presensi untuk Tanggal " . $sekarang;
                header("Location: ../dashboard.php");
                exit();
            }
        } else {
            $sql = "INSERT INTO tb_presensi(nis, masuk, status) VALUES ($id, '$tanggal', 'telat')";
            $query = mysqli_query($db, $sql);
            if ($query) {
                $_SESSION['pesan'] = "Berhasil Presensi untuk Tanggal " . $sekarang;
                header("Location: ../dashboard.php");
                exit();
            }
        }
    } else {
        $_SESSION['pesan'] = "Kamu tidak ada di kampus!!";
        header("Location: ../dashboard.php");
        exit();
    }
}

if (isset($_POST['keluar'])) {
    $id = $_SESSION['id_user'];
    $tanggal = date('Y-m-d');
    $ipAddress = gethostbyname(gethostname());
    $cari = "SELECT * FROM tb_presensi WHERE nis = $id AND masuk LIKE '%$tanggal%'";
    $cariIp = "SELECT * FROM tb_ip WHERE id = 1";
    $ip = 0;
    if (mysqli_query($db, $cariIp)->num_rows > 0) {
        $data = mysqli_query($db, $cariIp)->fetch_assoc();
        $ip = $data['ip'];
    }

    if ($ipAddress === $ip) {
        if (mysqli_query($db, $cari)->num_rows > 0) {
            $sekarang = date('Y-m-d H:i:s');
            $sql = "UPDATE tb_presensi SET keluar = '$sekarang' WHERE nis = $id";
            $query = mysqli_query($db, $sql);
            if ($query) {
                $_SESSION['pesan'] = "Berhasil Presensi untuk Tanggal " . $tanggal;
                header("Location: ../dashboard.php");
                exit();
            }
        }
    } else {
        $_SESSION['pesan'] = "Kamu tidak ada di kampus!!";
        header("Location: ../dashboard.php");
        exit();
    }
}
