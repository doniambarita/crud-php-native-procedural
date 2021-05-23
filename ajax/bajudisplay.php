<?php 
/*
Kekurangan dari aplikasi live search ini adalah :
1.Misal gw di halaman 1 nih , trus gw masukin keyword di pencarian dan data nya ada , nah kan tabel nya lngsung ditampil
kan ya , nah pada saat di tampilkan , url nya itu masih berada di halaman 1 , nah cara ganti nya gw masih rada binggung 
, 
tpi gw lakukan riset di yutub , ternyata bisa tuh url nya di ganti , pada saat kita pencet tombol mundur , nah nnti 
halaman yutub yg lagi kita tonton akan berpindah ke sisi pojok kanan bawah , NAH GW YAKIN ITU PAKE LIVE PAGE , 
MENGGUNAKAN AJAX , nah konsep nya maunya gw kaya gtu , tpi punya gw live search 

2.Masih bisa di enter kalo user masukin keyword , misal gw nyari baju yg nama brand nya leaf , trus gw enter , nha itu
masih bisa , jadi ga pure live search , masih ada minusnya lah

Tapi kalo make yg enter itu dia ga bakal nembus , cuman yg di perbolehkan harus sama persis spasinya atapun penulisan
hrufnya , DAN JUGA KALO GW MASUKIN SIMBOL #,&,+ , kan biasanya ketiga itu nampilin semua data , nah kalo di enter ini kaga
bisa

3.Di keyword masih bisa tembus dimasukin simbol tertentu , misal #/&/+ , trus di sambung dengan simbol atau huruf maka hasil
nya data nya tampil semua , contoh #''' , tampilnya semua data 
*/

require '../functions.php';

$keyword = $_GET["keyword"];    


$halamanAktif = 1;
$jumlahHalaman = 4;
?>

<?php if(isset($keyword)){ ?>
    <?php if( !preg_match("/^[0-9a-zA-Z\.\ ]*$/", $keyword) ) { ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Aksi</th>
                    <th>Gambar</th>
                    <th>Brand</th>
                    <th>Artikel</th>
                    <th>Warna</th>
                    <th>Size</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align:center; color:red; font-style:italic;" colspan="8"><b>Data Tidak Di Temukan</b></td>
                </tr>
            </tbody>
        </table>      
    <?php exit; } ?>

    
    <?php
    $query = " SELECT * FROM bajudisplay 
    WHERE
    brand LIKE '%$keyword%' OR
    artikel LIKE '%$keyword%' OR
    warna LIKE '%$keyword%' OR
    size LIKE '%$keyword%' OR
    harga LIKE '%$keyword%' ";

    $bajudisplay = query($query);
    if(
     !isset($bajudisplay[0]["brand"]) &&
     !isset($bajudisplay[0]["artikel"]) &&
     !isset($bajudisplay[0]["warna"]) &&
     !isset($bajudisplay[0]["size"]) &&
     !isset($bajudisplay[0]["harga"])
    ){ 
    ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Aksi</th>
                    <th>Gambar</th>
                    <th>Brand</th>
                    <th>Artikel</th>
                    <th>Warna</th>
                    <th>Size</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align:center; color:red; font-style:italic;" colspan="8"><b>Data Tidak Di Temukan</b></td>
                </tr>
            </tbody>
        </table>
    <?php exit; } ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap.css">
</head>
<body>
    
<table class="table table-hover">
    <thead>
        <tr>
            <th>No.</th>
            <th>Aksi</th>
            <th>Gambar</th>
            <th>Brand</th>
            <th>Artikel</th>
            <th>Warna</th>
            <th>Size</th>
            <th>Harga</th>
        </tr>
    </thead>

    <tbody>
    <?php $i=1; foreach($bajudisplay as $bdy) : ?>
        <tr>
            <td><?= $i; ?></td>
            <td>
                <a class='btn btn-primary' href="ubah.php?id=<?= $bdy["id"]; ?>">Ubah</a> |
                <a class='btn btn-danger'  href="hapus.php?id=<?= $bdy["id"]; ?>" onclick="return confirm('yakin menghapus data ?');">Hapus</a>
            </td>
            <td><img src="../img/<?php echo $bdy["gambar"]; ?>" width="60"></td>
            <td><?= $bdy["brand"]; ?></td>
            <td><?= $bdy["artikel"]; ?></td>
            <td><?= $bdy["warna"]; ?></td>
            <td><?= $bdy["size"]; ?></td>
            <td><?= $bdy["harga"]; ?></td>
        </tr>     
    <?php $i++; endforeach; ?>
    </tbody>

</table>
<?php } ?>


</body>
</html>