// tangkepin satu satu elemen yg ada di html , yg tadi udh gw bungkus pake div
var keyword = document.getElementById('keyword');
var tombolCari = document.getElementById('tombol-cari');
var container = document.getElementById('container');

keyword.addEventListener('keyup', function(){
    /*
    gw akan lakukan ajax nya skrng , caranya gw bikin sebuah variabel namnya bebas , tetapi pada umunya namanya xhr 
    atau ajax 
    Pertama , buat object ajax / instansiasi object ajax nya
    */
    var xhr = new XMLHttpRequest();

 
    // cek kesiapan ajax :
    // caranya panggil sebuah method xhr.onreadystatechange , jadi ini ngecek ajaxnya siap ga 
    xhr.onreadystatechange = function(){
        //  jadi ini mengecek siap ga ajax nya menerima request kita 
        // jadi jika sama readeState nya 200 itu ok , status nya 4 itu ready , maka ajax nya berhasil di lakukan
        if( xhr.readyState == 4 &&  xhr.status == 200){
           // gw panggil container , lalu isinya innerHTML , dalem div itu kan table ya , nah ga peduli isinya table nya 
           // apa , dan akan gw ganti dengan apapun yg gw dapat dari respon nya ,jadi apapun yg gw dapet dari bajudisplay.php
           container.innerHTML = xhr.responseText;
        }
    }

    // Setelah cek kesiapan ajax nya , lalu kita eksekusi ajax nya 
    // parameter pertama nya itu harus sama , dengan method yg di pakai di input pencarian nya , Kalo di di form input 
    // pencariannya pake get brrti di bawah ini juga pake GET , bgtu juga dengan post , jadi harus sesuai
    xhr.open('GET','ajax/bajudisplay.php?keyword=' + keyword.value,true);

    // ini untuk menjalankan ajax nya 
    xhr.send();

});
