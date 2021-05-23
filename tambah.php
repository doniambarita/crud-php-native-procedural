<?php 
session_start();
require 'functions.php';   

// bgtu kita masuk ke index , tanpa melalui isi form login dengan baik maka lansung di tendang lagi ke halaman login
// krn $_SESSION["login"] ga ada , jadi bisa masuk index hanya si user mengisi login dengan baik dan benar 
if( !isset($_SESSION["login"]) ){
    echo"
        <script>
            alert('Anda harus login untuk mengakses halaman ini!');
            document.location.href='login.php';
        </script>
    ";
    exit;
}


if ( isset($_POST["simpan"]) ){

    // jadi gw manggil fungsi tambah dari halaman funtions.php yg fungsinya gw simpan di variabel $hasil
    $hasil = tambah($_POST);
    if ( $hasil > 0 ){
        /*
        kalo mysqli_affected_rows itu dia menerima 2 kondisi , kondisi pertama jika hasil nya sama dengan integer 1 maka
        dia true , artinya berhasil di tambahkan , maka akan mengeksekusi kode di dalam if ini ,
        Dan jika hasilnya 0 / false , maka dia akan mengeksekusi kondisi di dalam else yg di mana datanya gagal di ubah
        */
        echo "
            <script>
                alert('Data Berhasil Ditambahkan!');
                document.location.href = 'index.php'; 
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data Gagal Ditambahkan!');
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
    <title>Tambah Data Baju Display</title>
    <link rel="stylesheet" href="bootstrap.min.css">    
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="popper.min.js"></script>
</head>
<body>
    

<!-- 
gw tambahin sbuah atribut , yg diunakan untuk mengelola file gambar , jdi nnti seolah olah form nya mempunyai 2 
buah jalur gtu , untuk string akan di kelola oleh $_POST dan untuk file akan di kelola oleh $_FILES
Jadi ini enctype="multipart/form-data" harus dibuat dulu supaya file nya bisa di ambil
-->
<div class="container">
  <h2>Tambah Data Baju Display</h2><br>
  <form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label for="brand">Brand :</label>
      <input type="brand" class="form-control" id="brand" placeholder="Masukkan nama brand" name="brand" required>
    </div>
    <div class="form-group">
      <label for="artikel">Artikel :</label>
      <input type="artikel" class="form-control" id="artikel" placeholder="Masukkan nama artikel" name="artikel" required>
    </div>
    <div class="form-group">
      <label for="warna">Warna :</label>
      <input type="warna" class="form-control" id="warna" placeholder="Masukkan warna" name="warna" required>
    </div>
    <div class="form-group">
      <label for="size">Size :</label>
      <input type="size" class="form-control" id="pwd" placeholder="Masukkan size" name="size" required>
    </div>
    <div class="form-group">
      <label for="harga">Harga :</label>
      <input type="harga" class="form-control" id="harga" placeholder="Masukkan harga" name="harga" required>
    </div>
    Gambar :
    <div style="margin:7px 0px 0px 0px" class="custom-file">
        <input type="file" class="custom-file-input" id="customFile" name="gambar">
        <label class="custom-file-label" for="customFile">Masukan gambar</label>
    </div>
    <button style="margin:10px 0px 40px 0px" type="submit" class="btn btn-primary" name="simpan">Simpan</button>
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