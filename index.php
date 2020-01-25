<?php include 'koneksi.php'; 
    $sql = "SELECT * FROM transaksi ORDER BY id_transaksi DESC LIMIT 1";
    $query = mysqli_query($koneksi, $sql);

    $data = mysqli_fetch_array($query);
    $no_transaksi =  $data['id_transaksi'] + 1;

    $sql = "SELECT * FROM user WHERE username = 'kasir'";
    $query = mysqli_query($koneksi, $sql);

    $data = mysqli_fetch_array($query);
    $nama =  $data['nama_user'];
    $id_user = $data['id_user'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transaksi</title>
</head>

<body>
    <label for="no_transaksi">No Transaksi :</label>
    <input type="text" value="<?= $no_transaksi ?>" name="no_transaksi" id="no_transaksi" disabled>

    <label for="nama_user">Nama User</label>
    <input type="hidden" name="id_user" id="id_user" value="<?= $id_user ?>">
    <input type="text" name="nama_user" id="nama_user" value="<?= $nama; ?>" disabled>

    <label for="tanggal">Tanggal</label>
    <input type="text" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>" disabled>
    <p>
        <label for="bayar">Total Bayar</label>
        <input type="number" id="bayar" disabled>
        <button id="bayar_transaksi">Bayar</button>
        <button id="batal_transaksi">Batal</button>
    </p>

    <p>
        <label for="tanggal">Pilih Masakan</label>
        <select name="nama_masakan" id="nama_masakan">
            <option value="0">-- Pilih Masakan --</option>
            <?php
        
		$no = 1;
		$qry = mysqli_query($koneksi, "SELECT * FROM masakan");
		while ($data=mysqli_fetch_array($qry)) {
		 ?>
            <option data="<?= $data['nama_masakan'] ?>" value="<?= $data['id_masakan'] ?>"><?= $data['nama_masakan'] ?>
            </option>
            <?php }
		 ?>
        </select>

        <label for="jumlah">Jumlah</label>
        <input type="number" name="jumlah" id="jumlah">
    </p>
    <p>
        <label for="harga">Harga</label>
        <input type="number" name="harga" id="harga" disabled>
        <label for="total">Total</label>
        <input type="number" name="total" id="total" disabled>
    </p>
    <p>
        <button id="proses">Proses</button>
    </p>
    <h3>List Pesanan</h3>
    <table border="1" width="60%">
        <thead>
            <tr>
                <td>No</td>
                <td>Nama Masakan</td>
                <td>Harga</td>
                <td>Jumlah</td>
                <td>Total</td>
            </tr>
        </thead>
        <tbody id="list_pesan">

        </tbody>
    </table>
    <script src="jquery.js"></script>
    <script>
        $(function () {
            $('#nama_masakan').on('click', function () {
                let id_masakan = $('#nama_masakan option:selected').attr('value');
                let nama_masakan = $('#nama_masakan option:selected').attr('data');
                $.ajax({
                    url: 'http://localhost/transaksi/getMasakan.php',
                    data: {
                        id: id_masakan,
                        nama_masakan: nama_masakan
                    },
                    type: 'json',
                    method: 'post',
                    success: function (data) {
                        $('#harga').val(data);
                    }
                })
            })

            $('#jumlah').on('change', function () {
                let harga = $('#harga').val();
                let jumlah = $('#jumlah').val();
                let total = harga * jumlah;
                $('#total').val(total);
            })


            let bayar_kasir = 0;
            let order = [];
            let no = 1;
            $('#proses').on('click', function () {
                let list = [];

                // Mengambil nilai input
                let id_transaksi = $('#no_transaksi').val();
                let id_masakan = $('#nama_masakan option:selected').attr('value');
                let nama_masakan = $('#nama_masakan option:selected').attr('data');
                let harga = $('#harga').val()
                let jumlah = $('#jumlah').val()
                let total = parseInt($('#total').val())

                if (jumlah == "") {
                    alert("Isi Terlebih dahulu Pesanan");
                } else {
                    $.ajax({
                        url: 'http://localhost/transaksi/tambahDetail.php',
                        data: {
                            id_transaksi: id_transaksi,
                            id_masakan: id_masakan,
                            nama_masakan: nama_masakan,
                            harga: harga,
                            jumlah: jumlah,
                            total: total,
                        },
                        method: 'post',
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                        }
                    })

                    // Menambahkna ke array list
                    list.push({
                        'id_masakan': id_masakan,
                        'nama_masakan': nama_masakan,
                        'harga': harga,
                        'jumlah': jumlah,
                        'total': total
                    });

                    // Otomotis menjumlahkan total bayar
                    bayar_kasir += total;
                    $('#bayar').val(bayar_kasir);

                    // Melakukan pengulangan di list pesanan
                    $.each(list, function (i, data) {
                        $('#list_pesan').append(`
                        <tr>
                            <td>` + no++ + `</td>
                            <td>` + data.nama_masakan + `</td>
                            <td>` + data.harga + `</td>
                            <td>` + data.jumlah + `</td>
                            <td>` + data.total + `</td>
                        </tr>
                    `)
                    })

                    // Menghapus nilai
                    $('#nama_masakan').val("")
                    $('#harga').val("");
                    $('#jumlah').val("");
                    $('#total').val("")
                }
            })

            $('#batal_transaksi').on('click', function () {
                let id_transaksi = $('#no_transaksi').val();
                let total_bayar = $('#bayar').val();

                if (total_bayar == "") {
                    alert("Tambah menu terlebih dahulu");
                    console.log("oke")
                } else {
                    $.ajax({
                        url: 'http://localhost/transaksi/batalTransaksi.php',
                        data: {
                            id_transaksi: id_transaksi
                        },
                        method: 'post',
                        dataType: 'json',
                        success: function (data) {

                        }
                    })
                    alert("Transaksi Berhasil dibatalkan");
                    window.location.reload();
                }
            })

            $('#bayar_transaksi').on('click', function () {
                let id_user = $('#id_user').val();
                let id = $('#no_transaksi').val();
                let total_bayar = $('#bayar').val();

                if (total_bayar == "") {
                    alert("Tambah Menu Terlebih dahulu")
                } else {
                    $.ajax({
                        url: 'http://localhost/transaksi/bayarTransaksi.php',
                        data: {
                            id_user: id_user,
                            total_bayar: total_bayar
                        },
                        method: 'post',
                        dataType: 'json',
                        success: function (data) {

                        }
                    })
                    alert("Berhasil Menambahkan Transaksi");
                    window.location.reload();
                    window.location.href = 'http://localhost/transaksi/print.php?id=' + id
                }
            })
        })
    </script>
</body>

</html>