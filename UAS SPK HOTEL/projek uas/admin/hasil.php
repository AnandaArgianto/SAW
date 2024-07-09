<?php
include 'header.php'; 
include '../asset/conn/config.php';
?>

<div class="container">
    <div class="container">
        <ol class="breadcrumb"></ol>
    </div>
    
    <div class="panel panel-container">
        <center>
            <h3>HASIL PENERAPAN METODE SAW</h3>
        </center>
        <hr>

        <h4>Data Nilai Kriteria</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Kriteria</th>
                        <th class="text-center">Bobot Kriteria</th>
                        <th class="text-center">Normalisasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data = mysqli_query($con, "SELECT * FROM kriteria ORDER BY id_kriteria");
                    $totalBobot = 0;
                    while ($row = mysqli_fetch_array($data)) {
                        $totalBobot += $row['bobot_kriteria'];
                    }
                    
                    mysqli_data_seek($data, 0);
                    $no = 1;
                    $normalizedWeights = [];
                    while ($row = mysqli_fetch_array($data)) { 
                        $normalisasi = $row['bobot_kriteria'] / $totalBobot;
                        $normalizedWeights[$row['id_kriteria']] = $normalisasi;
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $no++ ?></td>
                            <td class="text-center"><?php echo $row['nama_kriteria'] ?></td>
                            <td class="text-center"><?php echo $row['bobot_kriteria'] ?></td>
                            <td class="text-center"><?php echo round($normalisasi, 3) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <h4>Data Nilai Alternatif</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Alternatif</th>
                        <?php
                        $kriteriaQuery = mysqli_query($con, "SELECT * FROM kriteria ORDER BY id_kriteria");
                        $kriteriaList = [];
                        while ($kriteria = mysqli_fetch_array($kriteriaQuery)) {
                            $kriteriaList[] = $kriteria;
                            echo "<th class='text-center'>{$kriteria['nama_kriteria']}</th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $alternatifQuery = mysqli_query($con, "SELECT * FROM alternatif ORDER BY id_alternatif");
                    $no = 1;
                    while ($alternatif = mysqli_fetch_array($alternatifQuery)) {
                        echo "<tr>";
                        echo "<td class='text-center'>{$no}</td>";
                        echo "<td class='text-center'>{$alternatif['nama_alternatif']}</td>";

                        foreach ($kriteriaList as $kriteria) {
                            $subkriteriaQuery = "
                                SELECT subkriteria.nama_subkriteria
                                FROM nilai
                                JOIN subkriteria ON nilai.id_subkriteria = subkriteria.id_subkriteria
                                WHERE nilai.id_alternatif = {$alternatif['id_alternatif']}
                                AND nilai.id_kriteria = {$kriteria['id_kriteria']}
                            ";
                            $subkriteriaResult = mysqli_query($con, $subkriteriaQuery);
                            $subkriteria = mysqli_fetch_array($subkriteriaResult);
                            echo "<td class='text-center'>" . ($subkriteria ? $subkriteria['nama_subkriteria'] : '-') . "</td>";
                        }

                        echo "</tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <h4>Data Nilai Konversi Alternatif</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Alternatif</th>
                        <?php
                        foreach ($kriteriaList as $kriteria) {
                            echo "<th class='text-center'>{$kriteria['nama_kriteria']}</th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    mysqli_data_seek($alternatifQuery, 0);
                    $no = 1;
                    $maxValues = array_fill(0, count($kriteriaList), -PHP_FLOAT_MAX);
                    $nilaiAlternatifList = [];
                    while ($alternatif = mysqli_fetch_array($alternatifQuery)) {
                        $nilaiAlternatif = [];
                        echo "<tr>";
                        echo "<td class='text-center'>{$no}</td>";
                        echo "<td class='text-center'>{$alternatif['nama_alternatif']}</td>";

                        foreach ($kriteriaList as $index => $kriteria) {
                            $subkriteriaQuery = "
                                SELECT subkriteria.nilai_subkriteria
                                FROM nilai
                                JOIN subkriteria ON nilai.id_subkriteria = subkriteria.id_subkriteria
                                WHERE nilai.id_alternatif = {$alternatif['id_alternatif']}
                                AND nilai.id_kriteria = {$kriteria['id_kriteria']}
                            ";
                            $subkriteriaResult = mysqli_query($con, $subkriteriaQuery);
                            $subkriteria = mysqli_fetch_array($subkriteriaResult);
                            $nilai = $subkriteria ? $subkriteria['nilai_subkriteria'] : 0;
                            $nilaiAlternatif[] = $nilai;
                            
                            if ($nilai > $maxValues[$index]) $maxValues[$index] = $nilai;
                            
                            echo "<td class='text-center'>" . ($nilai ? $nilai : '-') . "</td>";
                        }

                        $nilaiAlternatifList[] = $nilaiAlternatif;
                        echo "</tr>";
                        $no++;
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center" colspan="2">Nilai Max</th>
                        <?php
                        foreach ($maxValues as $max) {
                            echo "<th class='text-center'>{$max}</th>";
                        }
                        ?>
                    </tr>
                </tfoot>
            </table>
        </div>

        <h4>Nilai Data Utiliti</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Alternatif</th>
                        <?php
                        foreach ($kriteriaList as $kriteria) {
                            echo "<th class='text-center'>{$kriteria['nama_kriteria']}</th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    mysqli_data_seek($alternatifQuery, 0);
                    while ($alternatif = mysqli_fetch_array($alternatifQuery)) {
                        echo "<tr>";
                        echo "<td class='text-center'>{$no}</td>";
                        echo "<td class='text-center'>{$alternatif['nama_alternatif']}</td>";

                        foreach ($kriteriaList as $index => $kriteria) {
                            $nilai = $nilaiAlternatifList[$no - 1][$index];
                            $max = $maxValues[$index];

                            $utilityValue = $max ? $nilai / $max * $nilai: 0;

                            echo "<td class='text-center'>" . round($utilityValue, 3) . "</td>";
                        }

                        echo "</tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <h4>Nilai SAW</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Alternatif</th>
                        <?php
                        foreach ($kriteriaList as $kriteria) {
                            echo "<th class='text-center'>{$kriteria['nama_kriteria']}</th>";
                        }
                        ?>
                        <th class="text-center">Nilai SAW</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    mysqli_data_seek($alternatifQuery, 0);
                    while ($alternatif = mysqli_fetch_array($alternatifQuery)) {
                        echo "<tr>";
                        echo "<td class='text-center'>{$no}</td>";
                        echo "<td class='text-center'>{$alternatif['nama_alternatif']}</td>";

                        $total = 0;
                        foreach ($kriteriaList as $index => $kriteria) {
                            $nilai = $nilaiAlternatifList[$no - 1][$index];
                            $max = $maxValues[$index];

                            $utilityValue = $max ? $nilai / $max * $nilai: 0;
                            $weightedValue = $utilityValue * $normalizedWeights[$kriteria['id_kriteria']];
                            $total += $weightedValue;

                            echo "<td class='text-center'>" . round($weightedValue, 3) . "</td>";
                        }

                        $updateQuery = "UPDATE alternatif SET nilai_saw = {$total} WHERE id_alternatif = {$alternatif['id_alternatif']}";
                        mysqli_query($con, $updateQuery);

                        echo "<td class='text-center'>" . round($total, 3) . "</td>";
                        echo "</tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <h4>Ranking</h4>
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

        <?php
        $topHotelQuery = mysqli_query($con, "SELECT nama_alternatif FROM alternatif ORDER BY nilai_saw DESC LIMIT 1");
        if ($topHotel = mysqli_fetch_array($topHotelQuery)) {
            echo "<p>Jadi hotel yang direkomendasikan di Solo yaitu <strong>{$topHotel['nama_alternatif']}</strong>.</p>";
        }
        ?>

    </div>
</div>


