<?php
include '../asset/conn/config.php'; 

if (isset($_GET['proses'])) {
    if ($_GET['proses'] == 'simpan') {
        $nama_subkriteria = $_POST['nama_subkriteria'];
        $nilai_subkriteria = $_POST['nilai_subkriteria'];
        $id_kriteria = isset($_POST['id_kriteria']) ? $_POST['id_kriteria'] : null;

        if (empty($id_kriteria)) {
            echo "Error: Missing 'id_kriteria'";
            exit();
        }

        $query = "INSERT INTO subkriteria (id_kriteria, nama_subkriteria, nilai_subkriteria) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "iss", $id_kriteria, $nama_subkriteria, $nilai_subkriteria);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: subkriteria.php?id_kriteria=$id_kriteria");
            exit();
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } elseif ($_GET['proses'] == 'ubah') {
        $id_subkriteria = $_POST['id_subkriteria'];
        $nama_subkriteria = $_POST['nama_subkriteria'];
        $nilai_subkriteria = $_POST['nilai_subkriteria'];
        $id_kriteria = isset($_POST['id_kriteria']) ? $_POST['id_kriteria'] : null;

        if (empty($id_kriteria)) {
            echo "Error: Missing 'id_kriteria'";
            exit();
        }

        $query = "UPDATE subkriteria SET id_kriteria=?, nama_subkriteria=?, nilai_subkriteria=? WHERE id_subkriteria=?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "issi", $id_kriteria, $nama_subkriteria, $nilai_subkriteria, $id_subkriteria);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: subkriteria.php?id_kriteria=$id_kriteria");
            exit();
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } elseif ($_GET['proses'] == 'hapus') {
        $id_subkriteria = $_GET['id_subkriteria'];

        $query_get_id_kriteria = "SELECT id_kriteria FROM subkriteria WHERE id_subkriteria=?";
        $stmt_get_id_kriteria = mysqli_prepare($con, $query_get_id_kriteria);
        mysqli_stmt_bind_param($stmt_get_id_kriteria, "i", $id_subkriteria);
        mysqli_stmt_execute($stmt_get_id_kriteria);
        mysqli_stmt_bind_result($stmt_get_id_kriteria, $id_kriteria);
        mysqli_stmt_fetch($stmt_get_id_kriteria);
        mysqli_stmt_close($stmt_get_id_kriteria);

        // Hapus semua data terkait di tabel nilai
        $query_delete_nilai = "DELETE FROM nilai WHERE id_subkriteria=?";
        $stmt_delete_nilai = mysqli_prepare($con, $query_delete_nilai);
        mysqli_stmt_bind_param($stmt_delete_nilai, "i", $id_subkriteria);
        mysqli_stmt_execute($stmt_delete_nilai);
        mysqli_stmt_close($stmt_delete_nilai);

        // Hapus subkriteria
        $query_delete_subkriteria = "DELETE FROM subkriteria WHERE id_subkriteria=?";
        $stmt_delete_subkriteria = mysqli_prepare($con, $query_delete_subkriteria);
        mysqli_stmt_bind_param($stmt_delete_subkriteria, "i", $id_subkriteria);

        if (mysqli_stmt_execute($stmt_delete_subkriteria)) {
            header("Location: subkriteria.php?id_kriteria=$id_kriteria");
            exit();
        } else {
            echo "Error: " . mysqli_stmt_error($stmt_delete_subkriteria);
        }
        mysqli_stmt_close($stmt_delete_subkriteria);
    }
}
?>
