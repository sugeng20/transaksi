<?php
    include "koneksi.php";
    $id_transaksi = $_POST['id_transaksi'];
    $id_masakan = $_POST['id_masakan'];
    $jumlah = $_POST['jumlah'];
    $total = $_POST['total'];
    $sql = "INSERT INTO `detail_transaksi`(`id_order`, `id_transaksi`, `id_masakan`, `qty`, `total`) VALUES
    (NULL, $id_transaksi,$id_masakan,$jumlah,$total)";
    $query = mysqli_query($koneksi, $sql);

?>