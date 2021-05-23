<?php 
session_start();
require 'functions.php';

// bgtu kita masuk ke index , tanpa melalui isi form login dengan baik maka lansung di tendang lagi ke halaman login
// krn $_SESSION["login"] ga ada , jadi bisa masuk index hanya si user mengisi login dengan baik dan benar 
if( !isset($_SESSION["login"]) ){
    echo"
        <script>
            alert('Anda harus log in untuk mengakses halaman ini!');
            document.location.href='login.php';
        </script>
    ";
    exit;
}


// ambil data id dari url dan gw simpan ke dalam variabel $id
// nah logika di bawah adalah jika user memasukkan id nya lewat url dan ternyata id nya tidak ada di dalam database maka 
// maupun yg di ketik di url nya itu tidak benar / tidak lengkap tulisan id nya , maka secara langsung akan di lempar
// ke halaman index.php
/* yg terpenting adalah gw amanin dulu nih pada saat ngirim datanya ke url , soalnya ngeri user masukin id nya dari url 
  trus ama user diapit kome id nya , nah itu bahaya tuh , caranya adalah Menggunakan casting input. Misalnya nilai harus 
  berupa integer, gw bisa juga melakukan casting dengan fungsi int(). ini contohnya : $id = (int)$_GET["id"];
  atau juga bisa pake fungsi bawaan php mysqli_real_escape_string(); , tpi menurut gw pake yg fungsi yg mysqli ajh
  */
$id = mysqli_real_escape_string($conn,$_GET["id"]);
$bajudisplay = query("SELECT * FROM bajudisplay WHERE id=$id");
if( $id == '' || $bajudisplay == FALSE ){
    header("Location: index.php");
}


// nih kenapa saat gw tulisa id=$id , nah si $id nya ga gw pakein tanda kutip ? nah krn hasil $id itu integer , beda lagi
// kalo dia string
$bajudisplay = query("SELECT * FROM bajudisplay WHERE id=$id");

if ( isset($_POST["ubah"]) ){  
    /*
    Nah if di bawah ini adlah jika admin , tidak mengubah data sama sekali , dan lsngung pencet tombol button simpannya .
    maka yg terjadi akan memunculkna pop up data tidak di ubah dan akan di redirect ke halaman index.php
    */
    if( $_FILES["gambar"]["name"] == ''  &&
        $_POST["brand"] == $bajudisplay[0]["brand"] && 
        $_POST["artikel"] == $bajudisplay[0]["artikel"] &&    
        $_POST["warna"] == $bajudisplay[0]["warna"] && 
        $_POST["size"] == $bajudisplay[0]["size"] && 
        $_POST["harga"] == $bajudisplay[0]["harga"] 
    ){
        echo "
        <script>
            alert('Data Tidak Diubah !');
            document.location.href='index.php';
        </script> 
        ";
    }

    // krn function bisa ngirim 2 argumen , jadi nya gw disini ngirim 2 argumen yaitu data data nya yg kita ambil 
    // menggunakan $_POST dan argumen ke 2 $id yg dimana $id berisi data get yg gw simpen di $id
    $hasil = queryUbah($_POST,$id);

    if ( $hasil > 0 ){
        /*
        kalo mysqli_affected_rows itu dia menerima 2 kondisi , kondisi pertama jika hasil nya sama dengan integer 1 maka
        dia true , artinya berhasil di tambahkan , maka akan mengeksekusi kode di dalam if ini ,
        Dan jika hasilnya 0 / false , maka dia akan mengeksekusi kondisi di dalam else yg di mana datanya gagal di ubah
        */
        echo "
            <script>
                alert('Data Berhasil Diubah!');
                document.location.href = 'index.php'; 
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data Gagal Diubah!');
                document.location.href = 'index.php'; 
            </script>
        ";
        // sbnrnya si ya menurut gw , pesan error ini tidak di perlukan , knp ? ya krn kan sintaks/query sql nya sudah 
        // dituliskan di dalam code , dan kita user/gw input data nya udh bentuk interface yg dimana tinggal kita 
        // isi isikan kolom nya tidak perlu lagi menuliskan query , mknya si mnurut gw ga diperlukan lagi , itu opini gw
        echo mysqli_error($conn); //nah knp gw bisa gunain $conn dan juga di atas tidak ada koneksi database dan tidak
                                  // $conn ?, nah krn tdi gw udh menghubungkan halaman ini dgn hal functions.php , jadi nya 
                                  // funsi2 atau variable yg di halaman funtions bisa gw panggil disni
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Baju Display</title>
    <link rel="stylesheet" href="bootstrap.min.css">    
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="popper.min.js"></script>
</head>
<body>
    

<div class="container">
  <h2>Ubah Data Baju Display</h2><br>
  <form action="" method="post" enctype="multipart/form-data">
  <?php foreach ($bajudisplay as $bjy) : ?>
  <input type="hidden" name="gambarLama" value="<?= $bjy["gambar"] ?>">
    <div class="form-group">
      <label for="brand">Brand :</label>
      <input type="brand" class="form-control" id="brand" name="brand" value="<?= $bjy["brand"]; ?>" required>
    </div>
    <div class="form-group">
      <label for="artikel">Artikel :</label>
      <input type="artikel" class="form-control" id="artikel" name="artikel" value="<?= $bjy["artikel"]; ?>" required>
    </div>
    <div class="form-group">
      <label for="warna">Warna :</label>
      <input type="warna" class="form-control" id="warna" name="warna" value="<?= $bjy["warna"]; ?>" required>
    </div>
    <div class="form-group">
      <label for="size">Size :</label>
      <input type="size" class="form-control" id="pwd" name="size" value="<?= $bjy["size"]; ?>" required>
    </div>
    <div class="form-group">
      <label for="harga">Harga :</label>
      <input type="harga" class="form-control" id="harga" name="harga" value="<?= $bjy["harga"]; ?>" required>
    </div>
    Gambar :
    <br>
    <img style="margin:5px 0px 0px 0px" src="img/<?= $bjy["gambar"]; ?>" width="150">
    <div style="margin:10px 0px 0px 0px" class="custom-file">
        <input type="file" class="custom-file-input" id="customFile" name="gambar">
        <label class="custom-file-label" for="customFile">Masukan gambar</label>
    </div>
    <button style="margin:10px 0px 40px 0px" type="submit" class="btn btn-primary" name="ubah">Ubah</button>
    <?php endforeach; ?>
  </form>
</div>

<!-- Script di bawah ini adalh , jika user menginputkan gambar , maka nama gambar nya akan berubah , yg tadi nya default
Masukkan gambar , akan berubah menjadi nama file gambar yg di inputkan user  -->
<script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>

    
</body>
</html>