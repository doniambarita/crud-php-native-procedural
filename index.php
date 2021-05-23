<?php 
// session start hanya di perbolehkan 1 kali penggunaan di 1 halaman 
session_start();
require 'functions.php'; 

$bajudisplay = query("SELECT * FROM bajudisplay");

/*
Pada umumnya nya kan men set cookie itu di halaman login ya dan jika benar maka stlh itu user refresh web nya maka akn
lsnguns masuk ke halaman index , nah tapi disini beda user harus ganti url nya dulu ke halaman index baru bisa masuk ke
halaman index jika cookie nya benar , 
*/
if( !isset($_SESSION["login"]) && !isset($_COOKIE["key"]) && !isset($_COOKIE["id"]) ){
    echo"
      <script>
          alert('Anda harus log in untuk mengakses halaman ini!');
          document.location.href='login.php';
      </script>
    ";
    exit;
}


/*
Di bawah ini adalah program untuk kasih salam kepada user , sesuai jam jakarta , dan user nya sesuai nama yg di inputkan
di username , jadi bener2 sma dgn username yg di buat pada saat registrasi
*/
if( isset($_COOKIE["id"]) && isset($_COOKIE["key"]) && isset($_SESSION["login"])){
    $id = $_COOKIE["id"];
    $key = $_COOKIE["key"];
    $result = mysqli_query($conn, "SELECT * FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
    if( $id !== $row['id'] && $key !== hash('sha256',$row['username']) && !isset($_SESSION["login"])){
        header("Location: logout.php");
        exit;
    }
    date_default_timezone_set('Asia/Jakarta');
    $user = $_SESSION["user"];
    $time = date("H:i");
    if($time > "00:00" && $time < "09:00"){
        $pagi = "Selamat Pagi $user";
    }elseif($time > "09:00" && $time < "15:00"){
        $siang = "Selamat Siang $user";
    }elseif($time > "15:00" && $time < "18:00"){
        $sore = "Selamat Sore $user";
    }elseif($time > "18:00" && $time < "24:00"){
        $malam = "Selamat Malam  $user";
    }
}elseif( !isset($_COOKIE["id"]) && !isset($_COOKIE["key"]) ){
    date_default_timezone_set('Asia/Jakarta');
    $user = $_SESSION["user"];
    $time = date("H:i");
    if($time > "00:00" && $time < "09:00"){
        $pagi = "Selamat Pagi $user";
    }elseif($time > "09:00" && $time < "15:00"){
        $siang = "Selamat Siang $user";
    }elseif($time > "15:00" && $time < "18:00"){
        $sore = "Selamat Sore $user";
    }elseif($time > "18:00" && $time < "24:00"){
        $malam = "Selamat Malam  $user";
    }
}elseif( isset($_COOKIE["id"])  && !isset($_COOKIE["key"]) && isset($_SESSION["login"]) ){
    // elseif ini adalah jika user sudah masuk di halaman index dan si user ngehapus cookie key nya dan id nya kaga di apus
    // dan juga id nya kaga di apus , maka hasilnya sprti di bawwah
    $id = $_COOKIE["id"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
    if( $id !== $row["id"] && !isset($_SESSION["login"])){
        header("Location: logout.php");
        exit;
    }
    date_default_timezone_set('Asia/Jakarta');
    $user = $_SESSION["user"];
    $time = date("H:i");
    if($time > "00:00" && $time < "09:00"){
        $pagi = "Selamat Pagi $user";
    }elseif($time > "09:00" && $time < "15:00"){
        $siang = "Selamat Siang $user";
    }elseif($time > "15:00" && $time < "18:00"){
        $sore = "Selamat Sore $user";
    }elseif($time > "18:00" && $time < "24:00"){
        $malam = "Selamat Malam  $user";
    }
}elseif( !isset($_COOKIE["id"])  && isset($_COOKIE["key"]) && isset($_SESSION["login"]) ){
    if(!isset($_SESSION["user"])){
        header("Location: logout.php");
        exit; 
    }

    date_default_timezone_set('Asia/Jakarta');
    $user = $_SESSION["user"];
    $time = date("H:i");
    if($time > "00:00" && $time < "09:00"){
        $pagi = "Selamat Pagi $user";
    }elseif($time > "09:00" && $time < "15:00"){
        $siang = "Selamat Siang $user";
    }elseif($time > "15:00" && $time < "18:00"){
        $sore = "Selamat Sore $user";
    }elseif($time > "18:00" && $time < "24:00"){
        $malam = "Selamat Malam  $user";
    }
}elseif( isset($_COOKIE["id"]) && isset($_COOKIE["key"]) && !isset($_SESSION["login"]) ){
    /*
    elseif ini dimana user close browser dan otomatis session habis , dan si user masuk ke web gw lagi , dan si user 
    ingin mengedit cookies gw , ini khusus value cookie nya ya yg di edit , entah 
    */
    $id = $_COOKIE["id"];
    $key = $_COOKIE["key"];
    $result = mysqli_query($conn, "SELECT * FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
    if( $id !== $row['id'] || $key !== hash('sha256',$row['username'])){
        /*
        jadi if di atas ini jika $id nya yg di tambahin ama user salah / di edit menjadi salah , maka akan lnsgun gw lempar
        ke halaman login
        */
        header("Location: login.php");
        exit;
    }
    /*
    Jika udh masuk ke if ini , dan isi dari key walaupun salah , tetapi isi id nya bener maka akan tetap masuk ke kode 
    di bawh ini , krn jika id nya ajah bener dan ada maka index.php ini akan di jalankan dengan salam yg di kasih 
    */
    date_default_timezone_set('Asia/Jakarta');
    $user = $row["username"];
    $time = date("H:i");
    if($time > "00:00" && $time < "09:00"){
        $pagi = "Selamat Pagi $user";
    }elseif($time > "09:00" && $time < "15:00"){
        $siang = "Selamat Siang $user";
    }elseif($time > "15:00" && $time < "18:00"){
        $sore = "Selamat Sore $user";
    }elseif($time > "18:00" && $time < "24:00"){
        $malam = "Selamat Malam  $user";
    }
}elseif(isset($_COOKIE["id"])){
    $id = $_COOKIE["id"];
    $result = mysqli_query($conn, "SELECT * FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
    if( $id !== $row['id'] ){
        /*
        jadi if di atas ini jika $id nya yg di tambahin ama user salah / di edit menjadi salah , maka akan lnsgun gw lempar
        ke halaman login

        Jadi yg dari login ke halaman index juga harus persis sama , jadi ga bisa id nya ajah yg bener tulisan dan valuenya
        tetapi key nya salah , nah itu kaga bisa , DAn itu pun user kalo bener id ama key nya harus inisiatif ganti url 
        nya ke halaman login
        */
        header("Location: login.php");
        exit;
    }
    date_default_timezone_set('Asia/Jakarta');
    $user = $row["username"];
    $time = date("H:i");
    if($time > "00:00" && $time < "09:00"){
        $pagi = "Selamat Pagi $user";
    }elseif($time > "09:00" && $time < "15:00"){
        $siang = "Selamat Siang $user";
    }elseif($time > "15:00" && $time < "18:00"){
        $sore = "Selamat Sore $user";
    }elseif($time > "18:00" && $time < "24:00"){
        $malam = "Selamat Malam  $user";
    }
}
elseif( !isset($_COOKIE["id"]) || !isset($_COOKIE["key"]) || !isset($_SESSION["login"]) ){
    /*
    gw ga akan ngasih kasus di mana user ngasih cookie key nya bener / salah dan cookie id nya ga di set , dan si user ny
    masuk ke halaman index , maka yg tampil adalkah kondisi if disini , krn kalo gw bikin elseif dari isset cookie key
    nya itu malah susah njir.
    */
    echo"
    <script>
        alert('Anda harus log in untuk mengakses halaman ini!');
        document.location.href='login.php';
    </script>
    ";
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link rel="stylesheet" href="bootstrap.min.css">    
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="popper.min.js"></script>
</head>
<body>

<!-- kode di bawah ini adalah untuk memberi salam kepada user,jadi gw bikin navbar yg posisi nya di pojok kanan atas  -->
<nav class="navbar navbar-expand-lg">
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a style="padding:0px 50px 0px 0px;" class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php if( isset($pagi) ) { ?>
            <?= $pagi; ?>
            <?php } ?>
            <?php if( isset($siang) ) { ?>
            <?= $siang; ?>
            <?php } ?>
            <?php if( isset($sore) ) { ?>
            <?= $sore; ?>
            <?php } ?>
            <?php if( isset($malam) ) { ?>
            <?= $malam; ?>
          <?php } ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
  

<div class="container">
<h1>Daftar Baju Display</h1><br>

<form action="" method="get">
    <a class='btn btn-info' href="tambah.php">Tambah Data Baju Display</a>
    <input style="margin:0px 0px 0px 110px"type="text" name="keyword" size="30" placeholder="Masukan Keyword Pencarian..." 
    autocomplete="off" autofocus id="keyword"  class="btn btn-light">
</form>
<br>

<div id="container">
<?php if(isset($_GET["keyword"])){ ?>
    <?php
      $keyword = $_GET["keyword"] ;
      if( !preg_match("/^[0-9a-zA-Z\.\ ]*$/", $keyword) ){  ?>
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
                    <td colspan="8" style="text-align:center; color:red; font-style:italic;"><b>Data Tidak Di Temukan</b></td>
                </tr>
              </tbody>
          </table>
    <?php exit; } ?>
      

      <?php
      /*
      Nah kondisi if di atas misal udh lolos nih , inputan user nya itu bener dari kondisi if di atas , maka lngsung 
      lanjut pencarian data nya dengan keyword yg inputkan , jika ada akan masuk ke dalam kode if dan meberhentikan kode
      di bawahnya. Kalo keyword yg di masukin user ada di dalam database gw maka akan melewati kode if di bawah 
      dan menampilkan hasil dari keyword pencarian user 
      */
      $bajudisplay = cari($_GET["keyword"]);

      /*
      -Nah pas inputan di kolom pencarian kaga ada di dalam database gw maka yg di tampilkan adalah data tidak di temukan 
       sprti kondisi if dibawah , padahal inputan pencariannya udh bener huruf , tetapi ga ada di dalam database 
       gw maka yg di tampilkan index di bawah ini
      */
      if( !isset($bajudisplay[0]["brand"]) &&
          !isset($bajudisplay[0]["artikel"]) &&
          !isset($bajudisplay[0]["warna"]) &&
          !isset($bajudisplay[0]["size"]) &&
          !isset($bajudisplay[0]["harga"])
        ){  ?>      
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
                <td colspan="8" style="text-align:center; color:red; font-style:italic;"><b>Data Tidak Di Temukan</b></td>
            </tr>
          </tbody>
        </table>  
      <?php exit; } ?>

<?php } ?>


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
    <?php $i=1 ?>
    <?php foreach($bajudisplay as $bdy) : ?>
      <tr>
          <td><?= $i; ?></td>
          <td>
              <a class='btn btn-primary' href="ubah.php?id=<?= $bdy["id"]; ?>">Ubah</a> |
              <a class='btn btn-danger' href="hapus.php?id=<?= $bdy["id"]; ?>" onclick="return confirm('yakin menghapus data ?');">Hapus</a>
          </td>
          <td><img src="img/<?= $bdy["gambar"]; ?>" width="60"></td>
          <td><?= $bdy["brand"]; ?></td>
          <td><?= $bdy["artikel"]; ?></td>
          <td><?= $bdy["warna"]; ?></td>
          <td><?= $bdy["size"]; ?></td>
          <td><?= $bdy["harga"]; ?></td>
      </tr>
    <?php $i++; ?>
    <?php endforeach; ?>
  </tbody>
</table>

</div>
</div>

<script src="js/script.js"></script>

</body>
</html>