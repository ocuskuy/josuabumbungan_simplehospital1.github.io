<?php 
session_start();

// Informasi koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_rumah sakit";

// Membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $dbname);
// if(!isset($_SESSION['username'])){
//   // header("Location: index.php");
// }

// 1.1
// Memeriksa apakah pengguna telah login
if (!isset($_SESSION['nama_apoteker'])) {
  // Redirect ke halaman login jika pengguna belum login
  header('Location: ../index.php');
  exit();
}

$username = $_SESSION['nama_apoteker'];

// Memeriksa koneksi
if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

// Menjalankan query untuk mengambil data admin
$sql_apoteker = "SELECT * FROM data_apoteker WHERE nama_apoteker='$username'";
$result_apoteker = mysqli_query($conn, $sql_apoteker);

// Memeriksa apakah data admin ditemukan
if (mysqli_num_rows($result_apoteker) > 0) {
  // Mengambil data admin
  $row_apoteker = mysqli_fetch_assoc($result_apoteker);
  $id_apoteker = $row_apoteker['id_apoteker']; // Mengambil ID admin yang sesuai
} else {
  // Tindakan jika data admin tidak ditemukan
  echo "<script>alert('Data admin tidak ditemukan');</script>";
  exit();
}
// end 1.1

// // Memeriksa apakah pengguna telah login
// if (!isset($_SESSION['nama_apoteker'])) {
//   // Redirect ke halaman login jika pengguna belum login
//   header('Location: ../index.php');
//   exit();
// }

// $username = $_SESSION['nama_apoteker'];

// // Memeriksa koneksi
// if (!$conn) {
//   die("Koneksi gagal: " . mysqli_connect_error());
// }

// // Menjalankan query untuk mengambil data
// $sql = "SELECT * FROM data_admin";
// $result = mysqli_query($conn, $sql);

// 1.1
// Memeriksa apakah form sudah di-submit
if(isset($_POST['submit'])) {
  // Mengambil data dari form
  $id_obat = $_POST['id_obat'];
  $nama_obat = $_POST['nama_obat'];
  $jenis_obat = $_POST['jenis_obat'];
  $golongan_obat = $_POST['golongan_obat'];

  // Validasi input
  if ($nama_obat !== ''  && $jenis_obat !== '' && $golongan_obat !== '') {
    // Query untuk memeriksa apakah data sudah ada di database
    $query = "SELECT * FROM data_obat WHERE nama_obat='$nama_obat'";
    $result = mysqli_query($conn, $query);

    // Jika data sudah ada di database, tampilkan alert
    if(mysqli_num_rows($result) > 0) {
        echo "<script>alert('Data dengan nama obat $nama_obat sudah ada!')</script>";
    } else {
        // $_SESSION['nama_admin'] = $nama_admin;
        // $_SESSION['role'] = "data_admin";
        
        // Jika data belum ada di database, lakukan insert data
        $insert_query = "INSERT INTO data_obat (nama_obat, jenis_obat, golongan_obat, id_apoteker) VALUES ('$nama_obat', '$jenis_obat', '$golongan_obat',  '$id_apoteker')";
        mysqli_query($conn, $insert_query);
        
        echo "<script>alert('Data berhasil dimasukkan ke database')</script>";
        // Reset nilai input setelah berhasil memasukkan data
        $nama_obat = '';
        $jenis_obat = '';
        $golongan_obat = '';
        // header('Location: ../edit_dokter.php');
        // exit();
    }
  } else {
    // Jika ada input yang kosong, munculkan alert
    echo "<script>alert('Lengkapi semua data!');</script>";
  }
}
// end 1.1

// Logout
if(isset($_POST['logout'])) {
  // Hapus data sesi
  session_unset();
  session_destroy();

  // Redirect ke halaman login setelah logout
  header('Location: ../index.php');
  exit();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>registrasi apoteker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
      /* gambar cover bg */
      body {
        background-image: url('background/apo1.jpg');
        background-size: cover;
        /* Anda juga dapat menggunakan properti lain seperti background-repeat, background-position, dll. */
        height: 200px;
        width: 100%;
      }
    </style>
  </head>
  <body>

    <!-- navbar -->
    <!-- As a heading -->
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                sidebar
            </button>
            <?php echo "Selamat datang,apoteker " . $username . " :)"; ?>
        </span>
        </div>
    </nav>
    <!-- end navbar -->

    <!-- sidebar -->  
      <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasExampleLabel">sidebar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <form action="" method="post">
          <button type="submit" name="logout" class="btn btn-danger">Log out</button>
          </form>
        </div>
      </div>
    <!-- end sidebar -->

    <!-- isi -->
    <div class="container my-5">
        <div class="p-5  bg-body-tertiary rounded-3">
          <h4 class="text-body-emphasis text-center">Registrasi obat</h4>
          <!-- form -->
          <form class="g-3 needs-validation" method="POST" novalidate>
            <input type="hidden" name="id_obat" value="<?php echo $row['id_obat']; ?>">
            <div class="">
              <label for="">nama obat</label>
              <input type="text" class="" id="validationCustom01" name="nama_obat" placeholder="nama obat" value="<?php echo isset($nama_obat) ? $nama_obat : ''; ?>" required><br><br>
            </div>
            <div class="">
                <!-- <input type="text" class="" id="validationCustom01" name="jenis_obat" placeholder="riwayat apoteker" required> <br><br> -->
                <label for="">jenis obat</label>
                <input type="text" class="" id="validationCustom01" name="jenis_obat" placeholder="jenis obat" value="<?php echo isset($jenis_obat) ? $jenis_obat : ''; ?>" required><br><br>
            </div>
            <div class="">
                <!-- <input type="text" class="" id="validationCustom01" name="golongan_obat" placeholder="alamat apoteker" required> <br><br> -->
                <label for="">golongan obat</label>
                <input type="text" class="" id="validationCustom01" name="golongan_obat" placeholder="golongan obat" value="<?php echo isset($golongan_obat) ? $golongan_obat : ''; ?>" required><br><br>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" name="submit" type="submit">Submit</button>
            </div>
          </form>
          <!-- end form -->
        </div>
      </div>
    <!-- end isi -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>