<?php 

// jalankan dulu session nya 
session_start();


if( !isset($_SESSION["login"]) && !isset($_COOKIE["key"]) && !isset($_COOKIE["id"])){
    echo"
        <script>
            alert('Anda sudah Logout!');
            document.location.href='login.php';
        </script>
    ";
    exit;
}

/*
supaya lebih yakin kalo session nya hilang gw pke fungsi di bwh ini , krn ktnya untuk beberapa kasus ada session 
yg ga hilang, biar memastikan tambahkan saja session_unset(); , atau bahkan ada yg menambahkan $_SESSION = []; di isi
dengan array kosong , ini di timpa oleh array kososng , jadi supaya yakin bnr2 session nya hilang
*/
$_SESSION = [];
session_unset();

// lalu hapus session nya / hancurkan
session_destroy();

if(isset($_SESSION["login"])){
    setcookie('id', '', time()-60*60*24*720 );
    setcookie('key', '', time()-60*60*24*720 );
    setcookie('id', '', time()-60*60*24*720 , '/');
    setcookie('key', '', time()-60*60*24*720 , '/');
}
/*
Skrng gw akan hapus cookie nya di halaman logout ini , jadi ketika logout cookie dan session nya juga di apus
cara menghapus cookie nya ini agak unik ya , unik nya dia sama dengan saat membuat cookie dan juga kalo mau hapus cookienya
expired date nya kita bikin mundur , jadi waktu yg sudah lewat , jadi mundur waktunya , cth : misal gw set cookie nya
1 hari , nah di hapus cookie nya gw set mundur jadi 1 hari 1 jam / 2 hari , krn 1 hari 1 jam / 2 hari itu kebelakang si
cookie nya itu belom di set 

Cth cara hapus cookie : setcookie('NamaCookienyaYgMauDihapus', 'iniksosnginajh', 'SetExpiredDatenyaYgUdhLewat');
*/
if(!isset($_SESSION["login"])){
setcookie('id', '', time()-60*60*24*720 );
setcookie('key', '', time()-60*60*24*720 );
/*
di bawah ini adalah jika user ngga login , tapi dia masukin nya lewat cookie pasti otomatis kan session ga di set tuh, 
jadi jika user masukin key dan cookie nya bener dia akan masuk ke index tanpa di isset session nya , nah gw ga tau
nih pada saat buat cookie nya di kasus nya gmana , bisa ajh kan path nya folder nya beda , nah disini gw akan make 
satu kasus ajh jadi si user ngeset cookie nya , tapi expired , ama path nya dia default in / ga di ubah ama user ,
jadi kan default dari expired ama path nya itu 1 tahun ama path nya itu / . nah maka pada saat hapus cookie nya gw 
bikin sprti di bawah ini . SEBENERNYA INI MASIH BANYAK KASUS NYA , MASIH BANYAK YG BISA DI BOBOL
*/
setcookie('id', '', time()-60*60*24*720 , '/');
setcookie('key', '', time()-60*60*24*720 , '/');
}

// lalu gw tendang / kembalikan ke halaman login
echo"
        <script>
            alert('Anda berhasil Logout!');
            document.location.href='login.php';
        </script>
    ";
    exit;

// dan gw tambahkan link di halaman index.php nya supaya ada tombol logoutnya

?>