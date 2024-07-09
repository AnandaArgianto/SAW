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
    <br>
    <br>
    <br>
    <br>

    <div class="container">
        <center>
            <h3><b>LAPORAN HASIL PENERAPAN METODE SAW</b></h3>
        </center>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Alternatif</th>
                        <th class="text-center">Nilai SAW</th>
                        <th class="text-center">Rangking</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $alternatifQuery = mysqli_query($con, "SELECT * FROM alternatif ORDER BY nilai_saw DESC");
                    $no = 1;
                    while ($alternatif = mysqli_fetch_array($alternatifQuery)) {
                        $updateQuery = "UPDATE alternatif SET rangking = $no WHERE id_alternatif = {$alternatif['id_alternatif']}";
                        mysqli_query($con, $updateQuery);

                        echo "<tr>";
                        echo "<td class='text-center'>{$no}</td>";
                        echo "<td class='text-center'>{$alternatif['nama_alternatif']}</td>";
                        echo "<td class='text-center'>{$alternatif['nilai_saw']}</td>";
                        echo "<td class='text-center'>{$no}</td>";
                        echo "</tr>";

                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <hr>
    </div>
</body>
</html>

<script> window.print()</script>
