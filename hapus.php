<?php 
session_start();

/*
LINK YG MASIH BISA
Saat di hapus masih bisa tembus nih link nya http://localhost:3000/materi18wpu/hapus.php?id=+8 ,  nah ama kalo link nya
ky gini http://localhost:3000/materi18wpu/hapus.php?id=#8 dia akan menghasilkan ke halaman index.php yg link nya ky gni
http://localhost:3000/materi18wpu/index.php#8 

Nah tpi kalo ky gini http://localhost:3000/materi18wpu/hapus.php?id=8# , nah itu datanya bakal ke apus , dan akan di 
arahkan ke halaman index yg link ny http://localhost:3000/materi18wpu/index.php# , trus data ke 8 nya udh ga  ada
Dan juga ada yg ky gini http://localhost:3000/materi18wpu/hapus.php?id=8& nnti hasilnya adalah akan di arahkan ke index
dan data ke 8 berhasil di hapus / datanya sudah ga ada , link nya menjadi http://localhost:3000/materi18wpu/index.php
Dan juga ada yg ky gini http://localhost:3000/materi18wpu/hapus.php?id=8+ nnti hasilnya adalah akan di arahkan ke index
dan data ke 8 berhasil di hapus / datanya sudah ga ada , link nya menjadi http://localhost:3000/materi18wpu/index.php
Dan juga ada yg ky gini http://localhost:3000/materi18wpu/hapus.php?id=8; nnti hasilnya adalah akan di arahkan ke index
dan data ke 8 berhasil di hapus / datanya sudah ga ada , link nya menjadi http://localhost:3000/materi18wpu/index.php
Dan juga ada yg ky gini http://localhost:3000/materi18wpu/hapus.php?id=8. nnti hasilnya adalah akan di arahkan ke index
dan data ke 8 berhasil di hapus / datanya sudah ga ada , link nya menjadi http://localhost:3000/materi18wpu/index.php


nah ama kalo link nya
ky gini http://localhost:3000/materi18wpu/ubah.php?id=#8 dia akan menghasilkan ke halaman index.php yg link nya ky gni
http://localhost:3000/materi18wpu/index.php#8 
nah ky gini juga tembus http://localhost:3000/materi18wpu/ubah.php?id=+8 dia akan menghasilkan ke halaman ubah.php ,
yg url nya ky gini http://localhost:3000/materi18wpu/ubah.php?id=+8

Nah gini tembus http://localhost:3000/materi18wpu/ubah.php?id=8# dia ke halaman ubah yg data nya 8 , yg hasil url nya ini
http://localhost:3000/materi18wpu/ubah.php?id=8#
Nah gini tembus http://localhost:3000/materi18wpu/ubah.php?id=8& dia ke halaman ubah yg data nya 8 , yg hasil url nya ini
http://localhost:3000/materi18wpu/ubah.php?id=8&
Nah gini tembus http://localhost:3000/materi18wpu/ubah.php?id=8+ dia ke halaman ubah yg data nya 8 , yg hasil url nya ini
http://localhost:3000/materi18wpu/ubah.php?id=8+
Nah gini tembus http://localhost:3000/materi18wpu/ubah.php?id=8; dia ke halaman ubah yg data nya 8 , yg hasil url nya ini
http://localhost:3000/materi18wpu/ubah.php?id=8;
Nah gini tembus http://localhost:3000/materi18wpu/ubah.php?id=8. dia ke halaman ubah yg data nya 8 , yg hasil url nya ini
http://localhost:3000/materi18wpu/ubah.php?id=8.

kalo yg nomor id nya di apit , itu yg paling rawan / yg masih bisa di tembus itu ky gini
untuk hapus.php :
http://localhost:3000/materi18wpu/hapus.php?id=(8) dan ,
http://localhost:3000/materi18wpu/hapus.php?id=+8+

untuk ubah.php
http://localhost:3000/materi18wpu/ubah.php?id=(8) dan , 
http://localhost:3000/materi18wpu/ubah.php?id=+8+
*/


if( !isset($_SESSION["login"]) ){
    echo"
        <script>
            alert('Anda harus log in untuk mengakses halaman ini!');
            document.location.href='login.php';
        </script>
    ";
    exit;
}

require 'functions.php';
$id = mysqli_real_escape_string($conn, $_GET["id"]);
$bajudisplay = query("SELECT * FROM bajudisplay WHERE id=$id");
if( $id == '' || $bajudisplay == FALSE ){
    header("Location: index.php");
}
/*
nah gw perbaikan nya dari pa dika ajh nih ya , ini menurut pengamatan gw ya perbaikaan nya .
Nah pa dika kan g bikin ya kalo dari halaman index.php ke halaman hapus.php itu harus pencet link hapus nya dan itu
otomatis bakal ngirim data id juga , nah disini ada kesalahan ya , ini menurut gw doang tapi ya,
Jadi saat user ke halaman hapus.php tidak mengirim kan data , jadi dia langsung ke halaman hapus.php lewat url nya,
harus nya kan lewat pencet link ya , 
Nah masalah ini gw tanganin pake !isset seperti dia atas , jadi user gw bisa ngetik lewat url , nha kalo lngsung
ke halaman index.php lewat url , dia akan balik lagi ke index.php jadinya di redirect
*/


if( hapus($id) > 0 ){  
    echo "
            <script>
                alert('Data Berhasil Dihapus!');
                document.location.href = 'index.php'; 
            </script>
        ";
    // header("Location: index.php");
}else {
    echo "
            <script>
                alert('Data Gagal Dihapus!');
            </script>
        ";
    echo mysqli_error($conn); // nah ini mencari error pada database puljastore yg nnti pesan erro nya akan di tampilkan
                              // di halaman index.php
    echo "<br>";
    echo "<a href='index.php'>Kembali ke halaman index.php</a>";
}

?>