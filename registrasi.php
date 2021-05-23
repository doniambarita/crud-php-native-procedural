<?php 
session_start();

/*
Dan jika halaman dari lain selain login yg ingin ke halaman registrasi , akan di tendang / tidak boleh ke halaman 
registrasi
*/
if( isset($_SESSION["login"]) || isset($_COOKIE["login"]) ){
    echo"
        <script>
            alert('Anda harus log out untuk mengakses halaman ini!');
            document.location.href='index.php';
        </script>
    ";
    exit;
}
/*
Nnti untk kedepannya gw bikin supaya halaman pertama yg dibuka adalah halaman login, jadi bukan halaman index , 
Jadi gw akan cari cara ketika user masuk ke dalam apliaksi/sistem kita , yg pertama di suguhkan adalah halaman login ,
kalo si user blom login baru gw akan kasih tombol untuk link ke halaman registrasi

Krn gw mau proses data di halaman yg sama , maka gw bikin action nya ksong , jadi gw ambil data di halaman ini dan gw 
proses datanya di halaman ini juga

Di dalam halaman regisrasi nya ada username , password , dan ada konfirmasi password, di form registrasi gw ga bikin 
kolom email krn nnti terlalu ribet deh buat gw pemula nih kan ya dan panjang juga , mknya gw bikin simple pake username ajh
*/

require 'functions.php';

// di bawah ini gw akan mengelola isi dari form registrasi
if( isset($_POST["register"]) ){
    // -Jadi jika tombol register udh di tekan maka jalankan function registrasi
    // -Function registrasi akan mengirimkan argumen berupa data dari form pengisian registrasi , 
    // -Klo fungsi registrasi mengembalikan nilai lebih dari 0 brrti ada user baru yg masuk ke dalam database ,
    //  stlh user berhasil mendaftar lalu akan di arahkan ke halaman login
    if( registrasi($_POST) > 0){
        echo "
        <script>
            alert('Berhasil Terdaftar, Silahkan Login!');
            document.location.href='login.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <style>
        label{
            display: block;
            font-weight: bold;
            margin : 10px 0px 0px;
        }
        body {
			background-color: #1995ad;
            font-family: "Segoe UI";
        }
        #registrasi{
			background-color: #fff;
			width: 430px;
			height: 475px;
			margin-top: 44px;
			margin-left: auto;
			margin-right: auto;
            padding : 10px 0px;
            border-radius: 4px;
    }
        button{
            border-radius: 4px;
            margin : 13px 0px 30px 125px;
			padding: 10px 10px 10px 10px;
			width: 100px;
			background-color: #1995ad;
			border: none;
			color: #fff;
			font-weight: bold;
        }
        h1 {
            margin : 10px 10px 32px 10px;
            font-weight: bold;
			text-align: center;
			font-size: 40px;
			color: #1995ad;
		}
    </style>

</head>
<body>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>

<br>
    
<div id="registrasi">
    <h1>Registrasi</h1>
    <form action="" method="post">
        <ul> 
            <label for="username">Username</label>
            <input type="text" name="username" id="username" size="40" required>
            <br>
            <label for="email">Email</label>
            <input type="text" name="email" id="email" size="40" required>
            <br>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" size="40" required>
            <br>
            <label for="password2">Ketik Ulang Password</label>
            <input type="password" name="password2" id="password2" size="40" required>
            <br>
                <button type="submit" name="register">Register</button>
            <br>
            Sudah punya akun? <a href="login.php">Login disini</a>
        </ul>
    </form>
</div>

</body>
</html>