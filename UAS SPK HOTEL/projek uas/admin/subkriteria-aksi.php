<?php
include 'header.php'; 

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'tambah') { ?>
        <div class="container">
            <div>
                <ol class="breadcrumb">SUBKRITERIA/TAMBAH DATA</ol>
            </div>

            <div class="panel panel-container">
                <form action="subkriteria-prosess.php?proses=simpan" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Nama subkriteria</label>
                        <input type="text" name="nama_subkriteria" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nilai subkriteria</label>
                        <input type="text" name="nilai_subkriteria" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kriteria</label>
                        <select name="id_kriteria" class="form-control" required>
                            <?php
                            $result = mysqli_query($con, "SELECT id_kriteria, nama_kriteria FROM kriteria");
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['id_kriteria']}'>{$row['nama_kriteria']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <a href="subkriteria.php?id_kriteria=<?php echo $_GET['id_kriteria']; ?>" class="btn btn-danger">BATAL</a>
                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>

    <?php } elseif ($_GET['aksi'] == 'ubah') {
        if (isset($_GET['id_subkriteria'])) { 
            $id_subkriteria = $_GET['id_subkriteria'];
            $query = "SELECT * FROM subkriteria WHERE id_subkriteria = $id_subkriteria";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);
    ?>
        <div class="container">
            <div>
                <ol class="breadcrumb">SUBKRITERIA/UBAH DATA</ol>
            </div>

            <div class="panel panel-container">
                <form action="subkriteria-prosess.php?proses=ubah" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_subkriteria" value="<?php echo $id_subkriteria; ?>">
                    <div class="form-group">
                        <label>Nama subkriteria</label>
                        <input type="text" name="nama_subkriteria" class="form-control" value="<?php echo $row['nama_subkriteria']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Nilai subkriteria</label>
                        <input type="text" name="nilai_subkriteria" class="form-control" value="<?php echo $row['nilai_subkriteria']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Kriteria</label>
                        <select name="id_kriteria" class="form-control" required>
                            <?php
                            $result = mysqli_query($con, "SELECT id_kriteria, nama_kriteria FROM kriteria");
                            while ($kriteria = mysqli_fetch_assoc($result)) {
                                $selected = ($kriteria['id_kriteria'] == $row['id_kriteria']) ? "selected" : "";
                                echo "<option value='{$kriteria['id_kriteria']}' $selected>{$kriteria['nama_kriteria']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <a href="subkriteria.php?id_kriteria=<?php echo $row['id_kriteria']; ?>" class="btn btn-danger">BATAL</a>
                        <button type="submit" class="btn btn-primary">UBAH</button>
                    </div>
                </form>
            </div>
        </div>
    <?php } else {
            echo "ID subkriteria tidak valid.";
        }
    } 
}
?>
