<?php 

session_start();
require 'functions.php';

/*NOTE !!!
pada saat user ke halaman login dari halaman index.php tpi dia masih menset cookie nya dengan bener maka halaman
login php nya masih bisa di tembus tanpa melalui logout , knp ? krn di login ini ga gw kasih kondis elseif sprti itu
, sbnrnya kasusu ky gtu udh gw tanganin dengan else if di bawh ini , tetapi mnrut gw ini malah fatal nnti jadinya
, ini fatal krn gw masih pemula ajh ya jadi blom tau cara samarin value id , mungkin kalo udh bisa samarin name dan
 value dari id dan key , maka masalah ini bisa lah gw tanganin , MASALAH NYA DIMANA ? jadi jika user ngasih cookie id nya
 ajh dengan benar , name cookie nya benar dan value nya juga benar , mksud value nya benar disini adlh value id yg masukan
 user ada di dalam database gw , maka si user akan otomatis masuk ke halaman index , nah disini celah nya 
 otomatis si user akan mencoba coba value lain agar bisa masuk ke index dengan nama user yg berbeda , jdi dia bisa
 masuk ke halaman index dengan user yg berbeda. 
 

 Dan juga jika gw ga make kondisi elseif di bawh ini adalah saat user menset id nya dengan benar otomatis kan di lnsgug
 ke halaman index , tetapi ini tidak , krn disini gw matiin tuh elseif yg dibawah , krn kalo mau ke halaman index
 itu user harus bnr2 ngeset key dan id nya dengan benar dan cocok dengan database admin(gw) , SEBENRNYA SI BISA TEMBUS
 KE HALAMAN INDEX WALAUPUN MAMSUKIN ID NYA SAJAH DAN VALUE ID NYA BENER , tetapi itu si user harus inisiatif , dia
 harus ke halaman index dulu baru bisa masuk , biasanya kan di login udh bisa masuk , tetapi klo ky gitu malah bahaya
 menurut gw , walaupun mecegah sedikit saja agar user berfikir cara untuk masuk
*/
/*
Minus aplikasi nya :
1.Saat gw coba di halaman login , dan gw ke inspext trus ke cookies , dan gw buat cookies id dan key yg bener bener sama 
persis nama id dan key nya gw isi dengan baik dan benar , serta juga value id dan key nya gw isi dengan baik dan benar
, tanpa basa basi gw refresh halaman login dan otomatis masuk ke index.php ,
Nah ini gw harus tanganin nih
*/
/*
Nah masih ada celah keamanannya nih saat :
Kalo gw masukin cookie yg key nya login dan value nya true maka hasilnya akan masuk ke index . krn cookie nya sudah di
set yg dimana jika ada cookie nya dia bisa masuk ke index , Nah lebih parah lagi dia udh set cookie yg key nya login
tpi dia ga set user nya maka pada saat di halaman index bakal ada error , soalnya gw ga detek $_COOKIE["user"] nya 
Jadi intinya user bisa masuk tanpa login , ini celah keamanan yg berbahaya bagi si user yg ingin merusak sistem

Kita harus cari cara meskipun user/orang melihat cookie kita , dia ga tau artinya apa / maskdunya nya apah ,
jadi yg tau katanya cuman admin ajh , tapi pas tampil di cookie nya itu tulisan nya ga jelas / gw acak
jadi gw ngasih semacam lapisan kemanan

Cara yg gw lakukan ini adalah buka cara yg paling aman dan paling bener juga , karena yg paling itu nyimpen cookie
nya di dalm database supaya nnti ngecek nya ke dalam database
*/


if( isset($_SESSION["login"]) ){
    header("Location: index.php");
    exit;
}elseif(isset($_COOKIE["key"]) && isset($_COOKIE["id"])){
    $id = $_COOKIE["id"];
    $key = $_COOKIE["key"]; 

    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
    if( $key === hash('sha256',$row["username"]) ){
    header("Location: index.php");
    exit;
    }
}


// apakah tombol login sudah di tekan atau belom 
if( isset($_POST["login"]) ){

    // jadi kalo yg di return true akan masuk ke dalam kode if , dan jika false akan masuk ke kode di dalam else
    if( login($_POST) === true ){
            echo "
                <script>
                    alert('Anda Berhasil Login');
                    document.location.href='index.php';
                </script>
            ";
            exit;
    }else{
        $error = true;    
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <style type="text/css">
    body {
			background-color: #7a58ff;
			font-family: "Segoe UI";
		}
	#wrapper {
			background-color: #fff;
			width: 400px;
			height: 330px;
			margin-top: 85px;
			margin-left: auto;
			margin-right: auto;
            padding : 10px 0px;
			border-radius: 4px;
    }
    label{
            margin : 8px 2px ;
			/* text-transform: uppercase; */
			font-weight: bold;
		}
    h1 {
            margin : 25px 10px 40px 10px;
            font-weight: bold;
			text-align: center;
			font-size: 40px;
			color: #7a58ff;
		}
    button {
            border-radius: 5px;
            margin: 5px 0px 5px 0px; 
			padding: 9px;
			width: 80px;
			background-color: #7a58ff;
			border: none;
			color: #fff;
			font-weight: bold;
        }
    .error {
			background-color: #f72a68;
			width: 400px;
			height: 41px;
			margin-top: 229px;
			margin-left: auto;
			margin-right: auto;
			border-radius: 4px;
			color: #fff;
        }
        input{
            margin: 0px 0px 0px 5px;
        }
        .ingatsaya {
            width: 400px;
            padding: 0px 0px 0px 228px;
            margin: -122px;
            margin-left: auto;
            margin-right: auto;
            font-size:11px
        }
    </style>
</head>
<body>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>

<br>
<form action="" method="post">
    <div id="wrapper">
        <h1>Login</h1>
            <ul>
                <table>
                    <tr>
                        <td><label for="email">Email</label></td>
                        <td>:</td>
                        <td><input type="text" name="email" id="email" size="21" required></td>
                    </tr>
                    <tr>
                        <td><label for="password">Password</label></td>
                        <td>:</td>
                        <td><input type="password" name="password" id="password" size="21" required></td>
                    </tr>
                    <tr>
                        <td><button type="submit" name="login">Login</button></td>
                    </tr>
                </table>
                <br>
                Belum punya akun? <a href="registrasi.php">Silahkan registrasi</a>
            </ul>  
    </div>
    <div class="ingatsaya">
        <input type="checkbox" id="remember" name="remember">
        <label for="remember">Remember Me</label>
    </div>    
</form>   


<?php if(isset($error)) : ?>
    <div class="error">
        <ul>
            <label>Email / Password yg Anda Masukan Salah</label>
        </ul>
    </div>
<?php endif; ?>

</body>
</html>