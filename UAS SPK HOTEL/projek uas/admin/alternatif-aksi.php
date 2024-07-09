<?php
include 'header.php'; 
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'tambah') { ?>
        <div class="container">
            <div>
                <ol class="breadcrumb">ALTERNATIF/ TAMBAH DATA</ol>
            </div>

            <div class="panel panel-container">
                <form action="alternatif-prosess.php?proses=simpan" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Nama Alternatif</label>
                        <input type="text" name="nama_alternatif" class="form-control" required>
                    </div>

                    <div class="modal-footer">
                        <a href="alternatif.php" class="btn btn-danger">BATAL</a>
                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>

    <?php } elseif ($_GET['aksi'] == 'ubah') { 
        // Menggunakan isset untuk memastikan variabel terdefinisi sebelum digunakan
        if(isset($_GET['id_alternatif'])) {
            $id_alternatif = $_GET['id_alternatif']; 
    ?>
        <div class="container">
            <div>
                <ol class="breadcrumb">ALTERNATIF/UBAH DATA</ol>
            </div>

            <div class="panel panel-container">
                <form action="alternatif-prosess.php?proses=ubah" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_alternatif" value="<?php echo $id_alternatif; ?>">
                    <div class="form-group">
                        <label>Nama Alternatif</label>
                        <input type="text" name="nama_alternatif" class="form-control" required>
                    </div>

                    <div class="modal-footer">
                        <a href="alternatif.php" class="btn btn-danger">BATAL</a>
                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    <?php 
        } else {
            // Menampilkan pesan jika id_alternatif tidak tersedia
            echo "ID Alternatif tidak valid.";
        }
    } 
}
?>
