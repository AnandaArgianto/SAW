<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'header.php'; 
include '../asset/conn/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metode SAW</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .bar-chart {
            display: flex;
            align-items: flex-end;
            justify-content: space-around;
            height: auto;
            margin-top: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            overflow-x: auto;
        }
        .bar {
            min-width: 50px;
            background-color: rgba(75, 192, 192, 0.7);
            text-align: center;
            margin: 0 10px;
            border: 1px solid rgba(75, 192, 192, 1);
            position: relative;
            transition: height 0.3s;
        }
        .bar span {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            display: block;
            color: #000;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
        .bar-label {
            text-align: center;
            margin-top: 5px;
            font-size: 14px; /* Ukuran font diperbesar */
        }
        .bar-container {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <center>
            <strong><h3>SELAMAT DATANG DI APLIKASI PENERAPAN METODE SAW</h3></strong>
            <strong><h3>SISTEM PENDUKUNG KEPUTUSAN</h3></strong>
            <strong><h3>REKOMENDASI HOTEL DI SOLO</h3></strong>
        </center>

        <h4>Data Rangking</h4>
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
                    $alternatifData = [];
                    $maxValue = 0;
                    while ($alternatif = mysqli_fetch_array($alternatifQuery)) {
                        $updateQuery = "UPDATE alternatif SET rangking = $no WHERE id_alternatif = {$alternatif['id_alternatif']}";
                        mysqli_query($con, $updateQuery);

                        echo "<tr>";
                        echo "<td class='text-center'>{$no}</td>";
                        echo "<td class='text-center'>{$alternatif['nama_alternatif']}</td>";
                        echo "<td class='text-center'>{$alternatif['nilai_saw']}</td>";
                        echo "<td class='text-center'>{$no}</td>";
                        echo "</tr>";

                        $alternatifData[] = [
                            'name' => $alternatif['nama_alternatif'],
                            'value' => $alternatif['nilai_saw']
                        ];
                        if ($alternatif['nilai_saw'] > $maxValue) {
                            $maxValue = $alternatif['nilai_saw'];
                        }

                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <style>
    .bar {
        background-color: #007bff; /* Warna latar belakang bar */
        color: #fff; /* Warna teks di dalam bar */
    }
</style>

<!-- Bar Chart Container -->
<div class="bar-chart">
    <?php
    foreach ($alternatifData as $alternatif) {
        $height = ($alternatif['value'] / $maxValue) * 400;
        $width = max(50, (int)(1000 / count($alternatifData)));

        echo "<div class='bar-container'>";
        echo "<div class='bar' style='height: {$height}px; width: {$width}px'>";
        echo "<span>{$alternatif['value']}</span>";
        echo "</div>";
        echo "<div class='bar-label'>{$alternatif['name']}</div>";
        echo "</div>";
    }
    ?>
</div>

    </div>
</body>
</html>
