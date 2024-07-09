<?php
include 'header.php'; 
include '../asset/conn/config.php';

$dalternatif = mysqli_query($con, "SELECT * FROM alternatif ORDER BY id_alternatif");
$dkriteria = mysqli_query($con, "SELECT * FROM kriteria ORDER BY id_kriteria");

$id_nilai = isset($_GET['id_nilai']) ? $_GET['id_nilai'] : '';

if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];
    
    // Tambah Data
    if ($aksi == 'tambah') { 
?>
        <div class="container">
            <div>
                <ol class="breadcrumb">NILAI/ TAMBAH DATA</ol>
            </div>

            <div class="panel panel-container">
                <form action="nilai-prosess.php?proses=simpan" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Nama Alternatif</label>
                        <select class="form-control" name="id_alternatif" required>
                            <option selected disabled>Pilih</option>
                            <?php
                            while ($da = mysqli_fetch_array($dalternatif)) {
                                echo "<option value='{$da['id_alternatif']}'>{$da['nama_alternatif']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <?php
                    while ($dk = mysqli_fetch_array($dkriteria)) {
                        $idK = $dk['id_kriteria'];
                        $labelK = $dk['nama_kriteria'];

                        echo "<div class='form-group'>";
                        echo "<label>$labelK</label>";
                        echo "<select class='form-control' name='kriteria_$idK' required>";
                        
                        $dsubkriteria = mysqli_query($con, "SELECT * FROM subkriteria WHERE id_kriteria='$idK' ORDER BY nilai_subkriteria DESC");
                        echo "<option selected disabled>Pilih</option>";
                        while ($ds = mysqli_fetch_array($dsubkriteria)) {
                            echo "<option value='{$ds['id_subkriteria']}'>{$ds['nama_subkriteria']}</option>";
                        }
                        
                        echo "</select></div>";
                    }
                    ?>

                    <div class="modal-footer">
                        <a href="nilai.php" class="btn btn-danger">BATAL</a>
                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
<?php 
    // Ubah Data
    } elseif ($aksi == 'ubah') {
        $query_nilai = "SELECT * FROM nilai WHERE id_alternatif='$id_nilai'";
        $result_nilai = mysqli_query($con, $query_nilai);
        $data_nilai = [];
        while ($row = mysqli_fetch_assoc($result_nilai)) {
            $data_nilai[$row['id_kriteria']] = $row['id_subkriteria'];
        }
?>
        <div class="container">
            <div>
                <ol class="breadcrumb">NILAI/UBAH DATA</ol>
            </div>

            <div class="panel panel-container">
                <form action="nilai-prosess.php?proses=ubah" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_nilai" value="<?php echo $id_nilai; ?>">
                    
                    <div class="form-group">
                        <label>Nama Alternatif</label>
                        <select class="form-control" name="id_alternatif" required>
                            <option selected disabled>Pilih</option>
                            <?php
                            while ($da = mysqli_fetch_array($dalternatif)) {
                                $selected = ($da['id_alternatif'] == $id_nilai) ? 'selected' : '';
                                echo "<option value='{$da['id_alternatif']}' $selected>{$da['nama_alternatif']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <?php
                    while ($dk = mysqli_fetch_array($dkriteria)) {
                        $idK = $dk['id_kriteria'];
                        $labelK = $dk['nama_kriteria'];

                        echo "<div class='form-group'>";
                        echo "<label>$labelK</label>";
                        echo "<select class='form-control' name='kriteria_$idK' required>";
                        
                        $dsubkriteria = mysqli_query($con, "SELECT * FROM subkriteria WHERE id_kriteria='$idK' ORDER BY nilai_subkriteria DESC");
                        echo "<option selected disabled>Pilih</option>";
                        while ($ds = mysqli_fetch_array($dsubkriteria)) {
                            $selected = ($data_nilai[$idK] == $ds['id_subkriteria']) ? 'selected' : '';
                            echo "<option value='{$ds['id_subkriteria']}' $selected>{$ds['nama_subkriteria']}</option>";
                        }
                        
                        echo "</select></div>";
                    }
                    ?>

                    <div class="modal-footer">
                        <a href="nilai.php" class="btn btn-danger">BATAL</a>
                        <button type="submit" class="btn btn-primary">UBAH</button>
                    </div>
                </form>
            </div>
        </div>
<?php 
    } else {
        echo "Data nilai tidak ditemukan.";
    }
} else {
    echo "ID nilai tidak valid.";
}
?>
