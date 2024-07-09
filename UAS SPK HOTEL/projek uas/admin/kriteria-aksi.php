<?php
include 'header.php'; 

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'tambah') { ?>
        <div class="container">
            <div>
                <ol class="breadcrumb">KRITERIA/TAMBAH DATA</ol>
            </div>

            <div class="panel panel-container">
                <form action="kriteria-prosess.php?proses=simpan" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Nama kriteria</label>
                        <input type="text" name="nama_kriteria" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Bobot kriteria</label>
                        <input type="text" name="bobot_kriteria" class="form-control" required>
                    </div>

                    <div class="modal-footer">
                        <a href="kriteria.php" class="btn btn-danger">BATAL</a>
                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>

    <?php } elseif ($_GET['aksi'] == 'ubah') {
        if (isset($_GET['id_kriteria'])) { 
            $id_kriteria = $_GET['id_kriteria'];
    ?>
        <div class="container">
            <div>
                <ol class="breadcrumb">KRITERIA/UBAH DATA</ol>
            </div>

            <div class="panel panel-container">
                <form action="kriteria-prosess.php?proses=ubah" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_kriteria" value="<?php echo $id_kriteria; ?>">
                    <div class="form-group">
                        <label>Nama kriteria</label>
                        <input type="text" name="nama_kriteria" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Bobot kriteria</label>
                        <input type="text" name="bobot_kriteria" class="form-control" required>
                    </div>

                    <div class="modal-footer">
                        <a href="kriteria.php" class="btn btn-danger">BATAL</a>
                        <button type="submit" class="btn btn-primary">UBAH</button>
                    </div>
                </form>
            </div>
        </div>
    <?php } else {
            echo "ID kriteria tidak valid.";
        }
    } 
}
?>
