<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h2 style="text-align: center;">Bakso Sederhana</h2>
    <p style="text-align: center;">Jalan Amburadul No. 123</p>

    <?php
    include "koneksi.php";
    $id = $_GET['id'];
    $sql = "SELECT * FROM transaksi INNER JOIN user ON transaksi.id_user=user.id_user WHERE transaksi.id_transaksi = '$id'";
    $query = mysqli_query($koneksi, $sql);
    while ($data=mysqli_fetch_array($query)) {
        ?>
            <p style="text-align: center;">Nama Kasir : <?= $data['nama_user']; ?></p>
            <p style="text-align: center;">Tanggal : <?= $data['tanggal']; ?></p>
    <?php } ?>

    <table align="center" width="50%"  style="text-align: center;" >
        <thead>
            <tr>
                <td>No</td>
                <td>Masakan</td>
                <td>Harga</td>
                <td>Jumlah</td>
                <td>Total</td>
            </tr>
        </thead>
        <tbody>
        <?php
        $id = $_GET['id'];
        $sql = "SELECT * FROM transaksi INNER JOIN user ON transaksi.id_user=user.id_user JOIN detail_transaksi ON transaksi.id_transaksi=detail_transaksi.id_transaksi JOIN masakan ON detail_transaksi.id_masakan = masakan.id_masakan WHERE transaksi.id_transaksi = '$id'";
        $query = mysqli_query($koneksi, $sql);
        $no = 1;
        $jumlah = 0;
        while ($data=mysqli_fetch_array($query)) { ?>
            
            <tr>
                <td><?= $no; ?></td>
                <td><?= $data['nama_masakan'] ?></td>
                <td><?= number_format($data['harga']) ?></td>
                <td><?= $data['qty'] ?></td>
                <td><?= number_format($data['total']) ?></td>
            </tr>
            
        <?php $jumlah += $data['total'];  $no++;  } ?>
            <tr>
                <td colspan="4">Total Bayar</td>
                <td>Rp. <?= number_format($jumlah); ?></td>
            </tr>
        </tbody>
    </table>
    <script>
        window.print();
    </script>
</body>

</html>



