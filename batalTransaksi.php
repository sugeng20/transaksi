<?php
    include "koneksi.php";
    $id_transaksi = $_POST['id_transaksi'];

    $sql = "DELETE FROM detail_transaksi WHERE id_transaksi = '$id_transaksi'";
    mysqli_query($koneksi, $sql);

?>