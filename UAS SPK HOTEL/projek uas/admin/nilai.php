<?php
include 'header.php'; 
include '../asset/conn/config.php';
?>

<div class="container">
    <div class="container">
        <ol class="breadcrumb">NILAI</ol>
    </div>
    
    <div class="panel panel-container">
        <a href="nilai-aksi.php?aksi=tambah" class="btn btn-primary">TAMBAH DATA</a>
        <hr>

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
                        <th class="text-center">Opsi</th>
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

                        echo "<td class='text-center'>
                            <a href='nilai-aksi.php?id_nilai={$alternatif['id_alternatif']}&aksi=ubah' class='btn btn-primary'>UBAH</a>
                            <a href='nilai-prosess.php?proses=hapus&id_alternatif={$alternatif['id_alternatif']}' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?');\" class='btn btn-danger'>HAPUS</a>
                        </td>";
                        echo "</tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
?>
