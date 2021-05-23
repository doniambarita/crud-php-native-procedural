<?php 

// Setiap fungsi2 gw taro di file ini, agar kita dapat membuat source code nya lebih efektif , modular dan elegan

// koneksi ke database localhost
$conn = mysqli_connect("localhost", "root", "", "puljastore");
// koneksi ke database hosting
// $conn = mysqli_connect("sql102.epizy.com", "epiz_27836296", "aeL5H8a3t27Wt", "epiz_27836296_dasar");

// funtion query akan menerima argumen dari halaman index.php yg argumen nya diberi nama parameter $query
function query($query){ 
   global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];  // untuk menampung data nya , jadi gw siapin wadah yg isinya array kosong , jadi data nya di taro disini
    while ( $row = mysqli_fetch_assoc($result) ){
        $rows[] = $row; 
    }
    return $rows; 
}

function tambah($data){
   global $conn;

   $brand = htmlspecialchars($data["brand"]);
   $artikel = htmlspecialchars($data["artikel"]);
   $warna = htmlspecialchars($data["warna"]);
   $size = htmlspecialchars($data["size"]);
   $harga = htmlspecialchars($data["harga"]);

   // upload gambar , jadi kalo berhasil ada 2 hal , gambar di upload dan di simpan di $gambar
   // nah klo gagal tidak ada nama yg di kirimkan
   $gambar = upload();
   // jadi jika gambar tidak di set / false , nnti hasilnya akan menghasilkan false yg akan di return ke fungsi tambah
   if( !$gambar ){
      return false;
   // jadi klo ketemu return false; , jadi selesai sampe sini , script2 yg di bawahnya tidak di jalankan
   }

   // masukin , input data nya ke dalam database
   $query = "INSERT INTO bajudisplay 
              VALUES 
              (8, '$brand','$artikel', '$warna', '$size', '$harga', '$gambar')";
   
   mysqli_query($conn, $query);
   
   return mysqli_affected_rows($conn); 

}


function upload(){

   /*untuk mengelola function upload ini kita harus mengambil isi dari $_FILES, 
     krn otomatis bgtu gw pencet tombol simpan ada $_FILES yg udh ada isinya , coba gw ambil dulu dan gw masukin 
     ke dalam tiap2 variabel
   */ 

   $namaFile = $_FILES["gambar"]["name"];
   $ukuranFile = $_FILES["gambar"]["size"];
   $error = $_FILES["gambar"]["error"];
   $tmpName = $_FILES["gambar"]["tmp_name"];

   $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
   $ekstensiGambar = explode('.', $namaFile);
   
   // stlh itu gw ngambil ekstensi dari string yg sudah di pecah dan di masukkan ke dalam array , gw make fungsi end
   // dan gw simpan ke dalam $ekstensiGambar , jadi yg $ekstensiGambar di atas gw timpa
   $ekstensiGambar = strtolower(end($ekstensiGambar));

   if( !in_array($ekstensiGambar, $ekstensiGambarValid) ){
      echo "
      <script>
         alert('Yang Anda Upload Bukan Gambar!');
      </script>
      ";
      return false;
   }

   /* -cek jika ukuran gambar nya itu terlalu besar , jika kita ingin membatasi ukuran gambar yg di upload
      -ini sistem bacanya dalam byte ya , jadi jika $ukuranFile lebih besar dari 1000000 byte maka akan menampilkan
       alert('Ukuran Gambar Terlalu Besar!');
      -jadi walaupun ekstensi nya bener , tetapi ukuran gambar nya terlalu besar / di atas 1000000 , maka dia akan 
       menampilkan pesan kesalahan , bgtu juga sebaliknya jika ekstensi salah tetapi ukuran nya bener
      -1mb sama ajh dengan 1000kb
   */
   if( $ukuranFile > 1000000 ){
      echo "
      <script>
         alert('Ukuran Gambar Terlalu Besar!');
      </script>
      ";
      return false;
   }

   $namaFileBaru = uniqid();
   $namaFileBaru .= '.';
   $namaFileBaru .= $ekstensiGambar;
   move_uploaded_file($tmpName,'img/'.$namaFileBaru);
   /*
   Sebenernya nyimpen/naro file itu dimana ajh, soalnya yg namanya di upload itu kan di duplikat ya , jadi file di server 
   si admin ada dan juga di server komputer si user juga tetep ada
   */


   return $namaFileBaru;
   // stlh di upload baru kita return nama file nya 
   /* buat apa di return namaFile nya ? supaya isi dari $gambar di atas di dapat dari function yg nilai nya $namaFile
     ,jadi bentuknya string dan sehingga $gambar bisa di masukin ke variabel $query yg ada di dalam function tambah
   */
}



function hapus($id){
   global $conn;
   $result = mysqli_query($conn, "SELECT gambar FROM bajudisplay WHERE id = $id");
   $file = mysqli_fetch_assoc($result);
   $fileName = implode('.', $file);
	$location = "img/$fileName";
	if (file_exists($location)) {
		unlink('img/' . $fileName);
   }

   /*
   jadi dia bakal ngehapus juga data gambar nya yg ada di server kita , jadi g cuman data yg di tampilannya ajh yg ke apus
   tetapi juga data yg ada di dalam server/database kita ikut terhapus juga
   */
   $query = "delete from bajudisplay where id={$id}";
   mysqli_query($conn, $query);
   return mysqli_affected_rows($conn);

}


function queryUbah($data,$id){
   global $conn;

   /* 
   jadi sebelum user inputin ubah harus gw kasih fungsi htmlspecialchars biar user gabisa nginputin script
   berbahaya atau elemen elemn html
   */
   $brand = htmlspecialchars($data["brand"]);
   $artikel = htmlspecialchars($data["artikel"]);
   $warna = htmlspecialchars($data["warna"]);
   $size = htmlspecialchars($data["size"]);
   $harga = htmlspecialchars($data["harga"]);
   $gambarLama = $data["gambarLama"];
    

    // cek user pakah pilih gambar baru / tidak , jadi gw cari key yg error nya soalnya , jika terdapat key error sama
    // dengan 4 , brrti sama saja user tidak mengisikan gambar baru / tidak mengganti gambar lama
   if( $_FILES["gambar"]["error"] === 4 ){
       $gambar = $gambarLama;
   }else{

      // upload gambar , jadi kalo berhasil ada 2 hal , gambar di upload dan di simpan di $gambar
      // nah klo gagal tidak ada nama yg di kirimkan
      $gambar = upload();

      // jadi jika gambar tidak di set / false , nnti hasilnya akan menghasilkan false yg akan di return ke fungsi tambah
      if( !$gambar ){
      // jadi klo ketemu return false; , jadi selesai sampe sini , script2 yg di bawahnya tidak di jalankan
         return false;
      }

      // jadi gw hapus gambar yg lama dulu sebelum ganti gambar yg baru , jadi gambar yg baru kan berhasil di upload ke 
      // sistem, nah stlh itu baru , gambar yg lama gw unlink sprti fungsi di bawh , jadi yg di unlink/hapus gambarnya itu
      //  yg kebaca gambar yg lama bukan yg baru di upload 
      $result = mysqli_query($conn, "SELECT gambar FROM bajudisplay WHERE id = $id");
		$file = mysqli_fetch_assoc($result);

		$fileName = implode('.', $file);
      unlink('img/' . $fileName);

   }

    $Ubah_Data =  "UPDATE bajudisplay 
                      SET brand = '$brand', 
                          artikel = '$artikel',
                          warna = '$warna',
                          size = '$size',
                          harga = '$harga',
                          gambar = '$gambar'
                    WHERE id = $id";

   mysqli_query($conn,$Ubah_Data);
   return mysqli_affected_rows($conn);

/*
belom bener nih yg fungsi ubah . masih banyak miss nya , 
1.nah yg kedua adalah saat user masukin ky gini !B@e#r$a%f^h&j*f(k)-+sz'?.,:''~|\sdfsa nah itu malah error cuy
  blom ngerti gw perbaikin nya gmana
2.pokoknya masih banyak yg harus di perbaiki
*/

}


function cari($keyword){ 
   $query = " SELECT * FROM bajudisplay 
              WHERE
              brand LIKE '%$keyword%' OR
              artikel LIKE '%$keyword%' OR
              warna LIKE '%$keyword%' OR
              size LIKE '%$keyword%' OR
              harga LIKE '%$keyword%'
              ";
   return query($query);
}


function registrasi($data){
   global $conn;

   /*
   nah untuk variabel $username ini akan gw lakukan pengamanan dulu ya 
   1.pertama gw akan melakukan pembersihan dulu di variabel $username nya , siapa tau kan si user memasukan karakter
     tertentu, contohnya misalkan usernya menginputkan ada karakter (backslash)/(\) , nah itu nnti karakter backslash nya
     akan gw hilangkan, supaya backslash nya ga masuk ke dalam database , stlh gw bersihin slashnya, lalu gw akan
     memaksa supaya yg dimasukan user itu huruf kecil, krn bisa aneh jika user membuat username huruf besar dan huruf kecil 
     digabugkan jadi nya aneh di dalam database ,
     jadi misal gw masukin username doni , huruf d nya huruf kecil ataupun besar , username doni/Doni bakal tetap
     masuk ke dalam database , krn biasanya username itu ga bersifat case sensitif
    
   2.Nah kedua ini untuk password, untuk password ini kynya ga ush pake stripcslashes dan strtolower , krn mungkin ajh
     itu password yg user inginkan , jadi supaya aman si user makenya backslash,hruf besar/huruf kecil

     tetapi untuk password gw ingin memasukkan ke dalam sebuah fungsi yg namanya mysqli_real_escape_string, 
     nah mysqli_real_escape_string ini adalah untuk memungkinkan si user masukin password ada tanda kutipnya , dan tanda 
     kutipnya akan di massukkan ke dalam database secara aman 
   */
  
   $username = $data["username"];
   $email = strtolower($data["email"]);
   $password = mysqli_real_escape_string($conn,$data["password"]);
   $password2 = mysqli_real_escape_string($conn,$data["password2"]);

   /*
   Jadi $kpUsername di gunakan untuk mengambil string pertama yg di inputkna user , jadi jika string/kata pertama yg
   di inputkan user itu simbol atau hanya spasi trus user memeasukkan namanaya cth:( doniambarita) jadi ada spasi sebelum
   kata , nha itu bakal menghasilkan kode di dalam if , jadi syaratnya adalah biar if tidak di eksekusi user harus 
   menginputkan username nya itu yg di perbolehkan adalah huruf besar /kecil , angka dan juga spasi , nah spasi ini ada
   syaratnya , yaitu tidak boleh sprti cth yg gw taro di atas td , dan juga bila kata pertama nya selain huruf besar /
   kecil dan angka maka akan di eksekusi tuh kode di dalam if / artinya username user tidak memenuhi syarat, nha 
   user juga bisa bikin username yg tanpa spasi jadi cuman 1 kata ajh misal doniambarita09 / DoniAmbarita , nah ini 
   gpp soalnya di memenuhi syarat penamaan username , beda lagi kalo doniambarita_09 / Doni*Ambarita , nah itu salah
   krn sudah ada simbol yg tidak di perbolehkan oelh sistem
   Kalo mau make spasi harus ada 1 huruf / 1 angka dulu minimal baru boleh di spasi
   */
   $kpUsername = implode(" ", array_slice(explode(" ", $username), 0, '1'));
   if($kpUsername === "" ||
      !preg_match("/^[0-9a-zA-Z\ ]*$/", $username)
      ){
      echo"
         <script>
            alert('Username hanya boleh mengandung huruf besar / huruf kecil!');
         </script>
         ";
      return false;
   }
   
/* // CEK INPUT EMAIL , APAKAH BENAR SESUAI DENGAN ATURANNYA 
   -gw make fungsi filter_var untuk memfilter @ dan titik nya simbol titik nya,  padahala kan udh bisa hanya dengan 
    fungsi substr yg gw buat, jadi 10 kata dari belakang harus kata @gmail.com , tapi gw pertimbangin ternyata 
    jika user naro @ nya dua kali itu masih bisa di tembus soalnya otomatis 10 kata dari belakang masih @gmail.com
    , nah mknya gw tanganin pake filter_var ajh , krn dia akan mendetek kalo ada simbol yg salah misal nya @ nya ada 2
    atau simbol . nya ada 2 

   -Jadi fungsi preg_match() , dignkn untuk mengecek ,apakah email yg di registrasi kan oleh user sudah memenuhi kriteria 
    yg di dalam parameter fungsi preg_match() , jadi syarat nya yg di perbolehkan adalah hanya yg mengandung angka,huruf 
    besar / huruf kecil , simbol titik , simbol @ , nah jadi jika user daftar registrasi nya memenuhi syarat maka akan 
    menghasilkan true , yg artinya kode scipt nya di dalam if tidak di jalankan krn hasilnya 1 brrti true , kalo tidak
    memenuhi syarat hasilnya akan 0 yg artinya false brrti juga kode di dalam if akan di jalankan

   -kalo fungsi substr nya di gunakan untuk mendetek apakah 10 kata dari gmail yg di daftarkan oleh user adalah @gmail.com
    ,nah kalo berbeda dengan @gmail.com , maka akan lngsung ke kode di dalam if , nah kalo beda dgn @gmail.com maka akn 
    kode if tidak di jalankan 
   */
   if(!preg_match("/^[0-9a-zA-Z\.\@]*$/", $email) ||
      filter_var($email, FILTER_VALIDATE_EMAIL) === false ||  
      substr($email,-10) !== "@gmail.com"
      ){
      echo "
         <script>
            alert('Email Anda Salah');
         </script>
         ";
      return false;
	}


   // pengecekan apa username tertentu udh ada di dalam database apa blom ,jadi username di dalam database itu harus beda
   // semua , jadi kalo gw tambahin username yg sama dengan username yg ada di database itu bisa masuk , dan ini g boleh
   // cek dulu username udh ada atau belom , jdi harus query dlu ke dalam tabel user 
   $result = mysqli_query($conn, "SELECT email FROM user WHERE email='$email'");
   // jadi query di atas adalah gw akan menangkap dati dari table user di field username yg username nya sama dengan 
   // $username , jdi $username yg nnti di inputkan oleh user , jd ada ga username yg di input user di dlm database

   // jika $result memiliki hasil , maka akan menjalankan kode yg ada di dalam blok if , jika tidak maka akan di abaikan
   if( mysqli_fetch_assoc($result) ){
      echo "
         <script>
            alert('Email Sudah Terdaftar');
         </script>
      ";
      return false;
   }


   /*
   nah skrng sudah di tangkap data2 semuanya dan di masukkan ke dalam variabel2 masing masing, skrng gw cek dulu password
   yg di masukkan user sama ga dengan password konfirmasi nya , 
   */
   // cek konfirmasi password , kalo salah/tidak sesuai maka kasih alert dari JS , dan gw berhentikan functionnya supaya
   // masuk ke else di halaman register.php yg menampilkan mysqli_error
   if( $password !== $password2 ){
      echo "
         <script>
            alert('Konfirmasi Password Tidak Sesuai!');
         </script>
      ";
      return false;
   }

  // tapi sebelum gw tambahkn/insert ke database , kita enkripsi terlebih dahulu password nya 
  /* -Jadi $password yg di atas akan gw timpa , lalu di dalam fungsi password_hash mempunyai 2 parameter , yg pertama 
      password apa yg mau di acak yg gw mau acak brrti $password di atas kan ya , 
     -Dan parameter kedua itu mengacak nya pake algoritma apa , jadi gw pake algoritma DEFAULT nya ajh , 
      Jadi PASSWORD_DEFAULT ini adalah algoritma yg dipilih secara default oleh si php nya, dan algoritma ini akan terus 
      berubah ketika ada cara pengamanan yg baru
   */
   $password = password_hash($password, PASSWORD_DEFAULT);
   // string(60) "$2y$10$kh8psEyyvcxZ3GMYL87AeeF6Vk9YGeA8FRxm.rNuDap1zHp0BVFDK" jadi ini contoh hasil dari password hash 
   // dan password yg nnti akan gw simpan ke dalam database nya ,angka acak dan banyak sekali , ini adalah hasil enkripsi 
   // dari $password menggunakan fungsi PASSWORD_DEFAULT dan nnti juga admin ga bakal tau kata string panjang itu apaan

   
   // nah password sudah di enkripsi lalu gw insert/tambahkan user baru ke dalam database
   $query = "INSERT INTO user VALUES(2, '$username', '$email', '$password')";
   mysqli_query($conn,$query);

   return mysqli_affected_rows($conn);
}


function login($data){
   /* 
   Kekurangan :
   Pas login masih bisa nembus tinggal masukin cookie id nya ajh trus value nya di coba coba pake angka , nah itu bisa
   masuk , 

   Dan juga misal udh naro key dan id yg bener dan baik ,ini akan tembus ke halaman index.php , nah ini masih bahaya     

   Masih banyak yg kurang nih di cookies , mash gampang banget di tembus lewat cookies ama sijahat , nnti pas udh pake frame
   work mungkin akan lebih mudah
   */

   global $conn;
   $email =  mysqli_real_escape_string($conn, $data["email"] );
   $password =  mysqli_real_escape_string($conn, $data["password"] );
   

   $query = mysqli_query($conn, "SELECT * FROM user WHERE email ='$email'");

   if( $row = mysqli_fetch_assoc($query) ){

      $passwordAsli = $row["password"];
      if( password_verify($password, $passwordAsli) ){

        $_SESSION["user"] =  $row["username"];
        $_SESSION["login"] = true;
        if( isset($data["remember"]) ){
          setcookie('id',$row["id"],time()+ 60*60*24*7);
          setcookie('key',hash('sha256',$row["username"]),time()+ 60*60*24*7);
        }
        return true;
      }
  
}else{
   return false;      
}

}
?>