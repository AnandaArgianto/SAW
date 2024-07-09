<?php
session_start(); 
include '../asset/conn/config.php'; 

if (!isset($_SESSION['username'])) {
    header("location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>PENERAPAN METODE SAW</title>
    <link rel="stylesheet" type="text/css" href="../asset/css/cosmo.min.css">
</head>
<body>
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <div class="navbar navbar-inverse navbar-static-top">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="alternatif.php">ALTERNATIF</a></li>
                    <li><a href="kriteria.php">KRITERIA</a></li>
                    <li><a href="nilai.php">NILAI</a></li>
                    <li><a href="hasil.php">HASIL</a></li>
                    <li><a href="laporan.php">LAPORAN</a></li>
                    <li><a href="logout.php">LOGOUT</a></li>
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>
