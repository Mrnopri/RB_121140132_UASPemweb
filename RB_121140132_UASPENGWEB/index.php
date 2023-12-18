<?php

$host="localhost";
$user="root";
$password="";
$db="toko";

$koneksi = mysqli_connect($host,$user,$password,$db);
if (!$koneksi){
        die("Koneksi Gagal:".mysqli_connect_error());
        
}
$nomor      = "";
$nama       = "";
$keterangan = "";
$bargo      = "";
$sukses     = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from barang where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from barang where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $nomor      = $r1['nomor'];
    $nama       = $r1['nama'];
    $keterangan = $r1['keterangan'];
    $bargo      = $r1['bargo'];

    if ($nomor == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $nomor      = $_POST['nomor'];
    $nama       = $_POST['nama'];
    $keterangan = $_POST['keterangan'];
    $bargo      = $_POST['bargo'];

    if ($nomor && $nama && $keterangan && $bargo) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update barang set nomor = '$nomor', nama = '$nama', keterangan = '$keterangan', bargo ='$bargo' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into barang(nomor,nama,keterangan,bargo) values ('$nomor','$nama','$keterangan','$bargo')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiaras Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto{ width: 900px;}
    </style>
</head>

<body>
    <div class="mx-auto">
        <div class="card">
            <h5 class="card-header">Create / edit data</h5>
            <div class="card-body">
                    <?php
                    if ($error) {
                    ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error ?>
                        </div>
                    <?php
                        header("refresh:5;url=index.php");//5 : detik
                    }
                    ?>
                    <?php
                    if ($sukses) {
                    ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $sukses ?>
                        </div>
                    <?php
                    header("refresh:5;url=index.php");
                    }
                    ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nomor" class="form-label">Jumlah Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nomor" name="nomor" value="<?php echo $nomor ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo $keterangan ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="bargo" class="form-label">Tersedia</label>
                        <div class="col-sm-10">
                            <select id="bargo" class="form-control" name="bargo">
                                <option value="">- Ketersediaan -</option>
                                <option value="ada" <?php if ($bargo == "ada") echo "selected" ?>> - ADA - </option>
                                <option value="tidak" <?php if ($bargo == "tidak") echo "selected" ?>> - TIDAK -</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>

        <!--Keluardata-->
        <div class="card">
            <h5 class="card-header bg-danger">Data Toko</h5>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nomor</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Ketersediaan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                        <tbody>
                            <?php
                            $sql2 =  "select * from barang order by id desc";
                            $q2 = mysqli_query($koneksi,$sql2);
                            $urut   = 1;

                            while ($r2 = mysqli_fetch_array($q2)){
                                $id         = $r2['id'];
                                $nomor      = $r2['nomor'];
                                $keterangan = $r2['keterangan'];
                                $bargo      = $r2['bargo'];

                                ?>
                                <tr>
                                    <th scope="row"><?php echo $urut++ ?></th>
                                    <td scope="row"><?php echo $nomor ?></td>
                                    <td scope="row"><?php echo $r2['nama'] ?></td>
                                    <td scope="row"><?php echo $keterangan ?></td>
                                    <td scope="row"><?php echo $bargo ?></td>
                                    <td scope="row">
                                        <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                        <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                    </td>
                                </tr>

                                <?php
                            }
                            ?>
                        </tbody>
                    </thead>
                </table>
            </div>
        </div>
        
    </div>
</body>
</html>