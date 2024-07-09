<?php
include 'header.php';

if(isset($_GET['id_kriteria'])) {
    $id_kriteria = $_GET['id_kriteria'];
    
    $query_kriteria = "SELECT nama_kriteria FROM kriteria WHERE id_kriteria = $id_kriteria";
    $result_kriteria = mysqli_query($con, $query_kriteria);
    $kriteria = mysqli_fetch_assoc($result_kriteria);
    $nama_kriteria = $kriteria['nama_kriteria'];
?>
<div class="container">
    <div class="container">
        <ol class="breadcrumb">KRITERIA/SUBKRITERIA/<?php echo $nama_kriteria; ?> </ol>
    </div>
    
    <div class="panel panel-container">
        <a href="subkriteria-aksi.php?aksi=tambah&id_kriteria=<?php echo $id_kriteria; ?>" class="btn btn-primary">TAMBAH DATA</a>
        <hr>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Subkriteria</th>
                        <th class="text-center">Nilai Subkriteria</th>
                        <th class="text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query_subkriteria = "SELECT * FROM subkriteria WHERE id_kriteria = $id_kriteria ORDER BY id_subkriteria";
                        $data = mysqli_query($con, $query_subkriteria);
                        $no = 1;
                        while ($a = mysqli_fetch_array($data)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $no++ ?></td>
                                <td class="text-center"><?php echo $a['nama_subkriteria'] ?></td>
                                <td class="text-center"><?php echo $a['nilai_subkriteria'] ?></td>
                                <td class="text-center">
                                    <a href="subkriteria-aksi.php?id_subkriteria=<?php echo $a['id_subkriteria'] ?>&aksi=ubah" class="btn btn-primary">UBAH</a>
                                    <a href="subkriteria-prosess.php?id_subkriteria=<?php echo $a['id_subkriteria'] ?>&proses=hapus" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">HAPUS</a>
                                </td>
                            </tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php 
} else {
    echo "ID kriteria tidak ditemukan.";
}
?>
