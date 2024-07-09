<?php
session_start();
include '../asset/conn/config.php'; 
if (isset($_SESSION['username'])){
    header("location: admin/index.php");
    exit;
}
?>
