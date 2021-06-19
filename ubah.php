<?php 
session_start();
require 'functions.php';

if( !isset($_SESSION["login"]) ){
    echo"
        <script>
            alert('Anda harus log in untuk mengakses halaman ini!');
            document.location.href='login.php';
        </script>
    ";
    exit;
}

$id = mysqli_real_escape_string($conn,$_GET["id"]);
$bajudisplay = query("SELECT * FROM bajudisplay WHERE id=$id");
if( $id == '' || $bajudisplay == FALSE ){
    header("Location: index.php");
}

$bajudisplay = query("SELECT * FROM bajudisplay WHERE id=$id");

if ( isset($_POST["ubah"]) ){  
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

    $hasil = queryUbah($_POST,$id);

    if ( $hasil > 0 ){
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
        echo mysqli_error($conn);
    }
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

    <title>Ubah Data Baju Display</title>
  </head>
<body>


<div class="container mt-3 mb-5">
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
    <img style="margin:5px 0px 0px 0px" id="output_image" src="img/<?= $bjy["gambar"]; ?>" width="250">
    <div style="margin:10px 0px 0px 0px" class="custom-file">
        <input type="file" accept="image/*" class="custom-file-input" id="customFile" name="gambar" onchange="preview_image(event)">
        <label class="custom-file-label" for="customFile">Masukan gambar</label>
    </div>
    <button type="submit" class="btn btn-primary mt-3 mb-5 mr-2" name="ubah">Ubah</button>
    <a href="index.php" class="btn btn-info mt-3 mb-5">Batal</a>
    <?php endforeach; ?>
  </form>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
  function preview_image(event) 
  {
   var reader = new FileReader();
   reader.onload = function()
   {
    var output = document.getElementById('output_image');
    output.src = reader.result;
   }
   reader.readAsDataURL(event.target.files[0]);
  }
  $(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });
</script>

    
</body>
</html>