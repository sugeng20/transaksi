<?php
    include "koneksi.php";
    $id_user = $_POST['id_user'];
    $total_bayar = $_POST['total_bayar'];
    
    $sql = "INSERT INTO `transaksi`(`id_transaksi`, `id_user`, `tanggal`, `total_bayar`) VALUES (NULL,$id_user, now(), $total_bayar)";
    $query = mysqli_query($koneksi, $sql);
?>