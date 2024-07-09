<?php
include '../asset/conn/config.php'; 

if(isset($_GET['proses'])){
    if($_GET['proses'] == 'simpan'){  
        $nama_kriteria = $_POST['nama_kriteria'];
        $bobot_kriteria = $_POST['bobot_kriteria'];

        $stmt = $con->prepare("INSERT INTO kriteria (nama_kriteria, bobot_kriteria) VALUES (?, ?)");
        $stmt->bind_param("ss", $nama_kriteria, $bobot_kriteria);
        if ($stmt->execute()) {
            header("Location: kriteria.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();

    } elseif ($_GET['proses'] == 'ubah') {
        $id_kriteria = $_POST['id_kriteria'];
        $nama_kriteria = $_POST['nama_kriteria'];
        $bobot_kriteria = $_POST['bobot_kriteria'];

        $stmt = $con->prepare("UPDATE kriteria SET nama_kriteria=?, bobot_kriteria=? WHERE id_kriteria=?");
        $stmt->bind_param("ssi", $nama_kriteria, $bobot_kriteria, $id_kriteria);
        if ($stmt->execute()) {
            header("Location: kriteria.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();

    } elseif ($_GET['proses'] == 'hapus') {
        $id_kriteria = $_GET['id_kriteria'];

        // Hapus data terkait di tabel nilai terlebih
        $stmt = $con->prepare("DELETE FROM nilai WHERE id_subkriteria IN (SELECT id_subkriteria FROM subkriteria WHERE id_kriteria=?)");
        $stmt->bind_param("i", $id_kriteria);
        if ($stmt->execute()) {
            // Hapus data di tabel subkriteria
            $stmt = $con->prepare("DELETE FROM subkriteria WHERE id_kriteria=?");
            $stmt->bind_param("i", $id_kriteria);
            if ($stmt->execute()) {
                // Hapus data di tabel kriteria
                $stmt = $con->prepare("DELETE FROM kriteria WHERE id_kriteria=?");
                $stmt->bind_param("i", $id_kriteria);
                if ($stmt->execute()) {
                    header("Location: kriteria.php");
                    exit();
                } else {
                    echo "Error deleting from kriteria: " . $stmt->error;
                }
            } else {
                echo "Error deleting from subkriteria: " . $stmt->error;
            }
        } else {
            echo "Error deleting from nilai: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
