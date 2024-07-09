<?php
include 'header.php'; 
?>

<div class="container">
    <div class="container">
        <ol class="breadcrumb">ALTERNATIF</ol>
    </div>
    
    <div class="panel panel-container">
        <a href="alternatif-aksi.php?aksi=tambah" class="btn btn-primary">TAMBAH DATA</a>
        <hr>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Alternatif</th>
                        <th class="text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $data = mysqli_query($con, "SELECT * FROM alternatif ORDER BY id_alternatif");
                        $no=1;
                        while ($a=mysqli_fetch_array($data)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $no++ ?></td>
                                <td class="text-center"><?php echo $a['nama_alternatif'] ?></td>
                                
                                <td class="text-center">
                                    <a href="alternatif-aksi.php?id_alternatif=<?php echo $a['id_alternatif'] ?>&aksi=ubah" class="btn btn-primary">UBAH</a>
                                    <a href="alternatif-prosess.php?id_alternatif=<?php echo $a['id_alternatif'] ?>&proses=hapus" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">HAPUS</a>
                                </td>
                            </tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
