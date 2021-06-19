<?php 

    session_start();
    require 'functions.php'; 

    $bajudisplay = query("SELECT * FROM bajudisplay");
    
    if( !isset($_SESSION["login"]) && !isset($_COOKIE["key"]) && !isset($_COOKIE["id"]) ){
        echo"
          <script>
              alert('Anda harus log in untuk mengakses halaman ini!');
              document.location.href='login.php';
          </script>
        ";
        exit;
    }


    
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
        
        $id = $_COOKIE["id"];
        $key = $_COOKIE["key"];
        $result = mysqli_query($conn, "SELECT * FROM user WHERE id = $id");
        $row = mysqli_fetch_assoc($result);
        if( $id !== $row['id'] || $key !== hash('sha256',$row['username'])){

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
    }elseif(isset($_COOKIE["id"])){
        $id = $_COOKIE["id"];
        $result = mysqli_query($conn, "SELECT * FROM user WHERE id = $id");
        $row = mysqli_fetch_assoc($result);
        if( $id !== $row['id'] ){
        
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
        echo"
        <script>
            alert('Anda harus log in untuk mengakses halaman ini!');
            document.location.href='login.php';
        </script>
        ";
        exit;
    }
?>







<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Halaman Admin</title>
  </head>
<body>



<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">
    <a class="navbar-brand" href="index.php">
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
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
                
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a style="color:#9e9c9b;"class="dropdown-item font-weight-bold" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>




<div class="container mt-3">
    <h1 class="mb-5">Daftar Baju Display</h1>

    <form action="" method="get" class="mb-3">
        <a class='btn btn-info mr-2' href="tambah.php">Tambah Data Baju Display</a>
        <input type="text" name="keyword" size="30" placeholder="Masukan Keyword Pencarian..." 
        autocomplete="off" autofocus id="keyword"  class="btn btn-light">
    </form>


    <div id="container">
            <?php if(isset($_GET["keyword"])){ ?>
              <?php
              $keyword = $_GET["keyword"] ;
              if( !preg_match("/^[0-9a-zA-Z\.\ ]*$/", $keyword) ){  ?>
                <div class="table-responsive">
                  <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">No.</th>
                          <th scope="col">Aksi</th>
                          <th scope="col">Gambar</th>
                          <th scope="col">Brand</th>
                          <th scope="col">Artikel</th>
                          <th scope="col">Warna</th>
                          <th scope="col">Size</th>
                          <th scope="col">Harga</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                            <td colspan="8" style="text-align:center; color:red; font-style:italic;"><b>Data Tidak Di Temukan</b></td>
                        </tr>
                      </tbody>
                  </table>
                </div>
              <?php exit; } ?>
            

              <?php
              $bajudisplay = cari($_GET["keyword"]);

              if( !isset($bajudisplay[0]["brand"]) &&
                  !isset($bajudisplay[0]["artikel"]) &&
                  !isset($bajudisplay[0]["warna"]) &&
                  !isset($bajudisplay[0]["size"]) &&
                  !isset($bajudisplay[0]["harga"])
                ){  ?>      
                    <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Aksi</th>
                                <th scope="col">Gambar</th>
                                <th scope="col">Brand</th>
                                <th scope="col">Artikel</th>
                                <th scope="col">Warna</th>
                                <th scope="col">Size</th>
                                <th scope="col">Harga</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                                <td colspan="8" style="text-align:center; color:red; font-style:italic;"><b>Data Tidak Di Temukan</b></td>
                            </tr>
                          </tbody>
                        </table>  
                    </div>
                <?php exit; } ?>

            <?php } ?>

            <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Aksi</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Artikel</th>
                        <th scope="col">Warna</th>
                        <th scope="col">Size</th>
                        <th scope="col">Harga</th>
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
</div>

    <script src="js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>