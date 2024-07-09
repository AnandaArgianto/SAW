<?php
include 'header.php'; 
?>

<div class="container">
    <div class="container">
        <ol class="breadcrumb">KRITERIA</ol>
    </div>
    
    <div class="panel panel-container">
        <a href="kriteria-aksi.php?aksi=tambah" class="btn btn-primary">TAMBAH DATA</a>
        <hr>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama kriteria</th>
                        <th class="text-center">Bobot kriteria</th>
                        <th class="text-center">Subkriteria</th>
                        <th class="text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $data = mysqli_query($con, "SELECT * FROM kriteria ORDER BY id_kriteria");
                        $no=1;
                        while ($a=mysqli_fetch_array($data)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $no++ ?></td>
                                <td class="text-center"><?php echo $a['nama_kriteria'] ?></td>
                                <td class="text-center"><?php echo $a['bobot_kriteria'] ?></td>
                                <td class="text-center">
                                    <a href="subkriteria.php?id_kriteria=<?php echo $a['id_kriteria'] ?>" class="btn btn-info">Subkriteria</a> <!-- Mengarahkan ke file subkriteria.php dengan parameter id_kriteria -->
                                </td>
                                <td class="text-center">
                                    <a href="kriteria-aksi.php?id_kriteria=<?php echo $a['id_kriteria'] ?>&aksi=ubah" class="btn btn-primary">UBAH</a>
                                    <a href="kriteria-prosess.php?id_kriteria=<?php echo $a['id_kriteria'] ?>&proses=hapus" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">HAPUS</a>
                                </td>
                            </tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
