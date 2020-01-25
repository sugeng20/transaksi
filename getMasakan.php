<?php
    include 'koneksi.php';
    $id = $_POST['id'];
    $sql = "SELECT * FROM masakan WHERE id_masakan = $id";
    $query = mysqli_query($koneksi, $sql);
    $data = mysqli_fetch_array($query);

    echo $data['harga'];

?>