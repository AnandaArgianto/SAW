<?php
include '../asset/conn/config.php'; 

if(isset($_GET['proses'])){
    if($_GET['proses'] == 'simpan'){  
        $id_alternatif = $_POST['id_alternatif'];

        $dnilai = mysqli_query($con, "SELECT * FROM nilai WHERE id_alternatif='$id_alternatif'");
        $dn = mysqli_num_rows($dnilai);

        if($dn > 0){
            header("location:nilai.php?pesan=gagal");
            exit();
        } else {
            $dkriteria = mysqli_query($con, "SELECT * FROM kriteria ORDER BY id_kriteria");
            while($dk = mysqli_fetch_array($dkriteria)){
                $idK = $dk['id_kriteria'];
                $id_subkriteria = $_POST["kriteria_$idK"] ?? null;

                // Check if id_subkriteria exists in subkriteria table
                $check_subkriteria = mysqli_query($con, "SELECT * FROM subkriteria WHERE id_subkriteria='$id_subkriteria'");
                if (mysqli_num_rows($check_subkriteria) > 0) {
                    $query = "INSERT INTO nilai(id_alternatif, id_kriteria, id_subkriteria) VALUES ('$id_alternatif', '$idK', '$id_subkriteria')";
                    mysqli_query($con, $query);
                } else {
                    // Handle the error appropriately, maybe log it or show a message
                    echo "Invalid subkriteria id: $id_subkriteria for kriteria id: $idK<br>";
                }
            }
            header("location:nilai.php");
            exit();
        }

    } elseif ($_GET['proses'] == 'ubah') {
        $id_alternatif = $_POST['id_alternatif'];

        // Debugging: print the POST data
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';

        // Ambil data kriteria dari database
        $dkriteria = mysqli_query($con, "SELECT * FROM kriteria ORDER BY id_kriteria");
        while($dk = mysqli_fetch_array($dkriteria)){
            $idK = $dk['id_kriteria'];
            $id_subkriteria_baru = $_POST["kriteria_$idK"] ?? null;
            
            // Check if id_subkriteria_baru exists in subkriteria table
            $check_subkriteria = mysqli_query($con, "SELECT * FROM subkriteria WHERE id_subkriteria='$id_subkriteria_baru'");
            if (mysqli_num_rows($check_subkriteria) > 0) {
                // Ambil data subkriteria lama dari database
                $dsubkriteria_lama = mysqli_query($con, "SELECT id_subkriteria FROM nilai WHERE id_alternatif='$id_alternatif' AND id_kriteria='$idK'");
                if(mysqli_num_rows($dsubkriteria_lama) > 0){
                    $subkriteria_lama = mysqli_fetch_assoc($dsubkriteria_lama)['id_subkriteria'];

                    // Cek apakah data subkriteria berubah
                    if($subkriteria_lama != $id_subkriteria_baru){
                        // Update data subkriteria jika berubah
                        $update_query = "UPDATE nilai SET id_subkriteria='$id_subkriteria_baru' WHERE id_alternatif='$id_alternatif' AND id_kriteria='$idK'";
                        mysqli_query($con, $update_query);
                    }
                } else {
                    // Jika tidak ada data lama, maka insert baru
                    $insert_query = "INSERT INTO nilai(id_alternatif, id_kriteria, id_subkriteria) VALUES ('$id_alternatif', '$idK', '$id_subkriteria_baru')";
                    mysqli_query($con, $insert_query);
                }
            } else {
                // Handle the error appropriately, maybe log it or show a message
                echo "Invalid subkriteria id: $id_subkriteria_baru for kriteria id: $idK<br>";
            }
        }
        header("location:nilai.php");
        exit();

    } elseif ($_GET['proses'] == 'hapus') {
        $id_alternatif = $_GET['id_alternatif'];

        // Hapus data terkait di tabel nilai terlebih dahulu
        $delete_query_nilai = "DELETE FROM nilai WHERE id_alternatif='$id_alternatif'";
        mysqli_query($con, $delete_query_nilai);

        // Tidak perlu menghapus dari tabel subkriteria dan kriteria karena tidak ada kolom id_alternatif di sana

        // Hapus data di tabel alternatif
        $delete_query_alternatif = "DELETE FROM alternatif WHERE id_alternatif='$id_alternatif'";
        mysqli_query($con, $delete_query_alternatif);

        header("location:nilai.php");
        exit();
    }
}
?>
