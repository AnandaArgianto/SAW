<?php
include '../asset/conn/config.php'; 

if(isset($_GET['proses'])){
    if($_GET['proses'] == 'simpan'){  
        $nama_alternatif = $_POST['nama_alternatif'];

        $query = $con->prepare("INSERT INTO alternatif (nama_alternatif) VALUES (?)");
        $query->bind_param("s", $nama_alternatif);
        if ($query->execute()) {
            header("Location: alternatif.php");
        } else {
            echo "Error: " . $query->error;
        }
        exit();

    } elseif ($_GET['proses'] == 'ubah') {
        $id_alternatif = $_POST['id_alternatif'];
        $nama_alternatif = $_POST['nama_alternatif'];

        $query = $con->prepare("UPDATE alternatif SET nama_alternatif = ? WHERE id_alternatif = ?");
        $query->bind_param("si", $nama_alternatif, $id_alternatif);
        if ($query->execute()) {
            header("Location: alternatif.php");
        } else {
            echo "Error: " . $query->error;
        }
        exit();

    } elseif ($_GET['proses'] == 'hapus') {
        $id_alternatif = $_GET['id_alternatif'];

        // First delete related rows in 'nilai' table
        $query = $con->prepare("DELETE FROM nilai WHERE id_alternatif = ?");
        $query->bind_param("i", $id_alternatif);
        if (!$query->execute()) {
            echo "Error: " . $query->error;
            exit();
        }

        // Then delete the row in 'alternatif' table
        $query = $con->prepare("DELETE FROM alternatif WHERE id_alternatif = ?");
        $query->bind_param("i", $id_alternatif);
        if ($query->execute()) {
            header("Location: alternatif.php");
        } else {
            echo "Error: " . $query->error;
        }
        exit();
    }
}
?>
