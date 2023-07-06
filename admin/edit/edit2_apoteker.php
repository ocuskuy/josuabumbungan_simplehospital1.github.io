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
if (!isset($_SESSION['nama_admin'])) {
  // Redirect ke halaman login jika pengguna belum login
  header('Location: ../index.php');
  exit();
}

$username = $_SESSION['nama_admin'];

// Memeriksa koneksi
if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

// Menjalankan query untuk mengambil data admin
$sql_admin = "SELECT * FROM data_admin WHERE nama_admin='$username'";
$result_admin = mysqli_query($conn, $sql_admin);

// Memeriksa apakah data admin ditemukan
if (mysqli_num_rows($result_admin) > 0) {
  // Mengambil data admin
  $row_admin = mysqli_fetch_assoc($result_admin);
  $id_admin = $row_admin['id_admin']; // Mengambil ID admin yang sesuai
} else {
  // Tindakan jika data admin tidak ditemukan
  echo "<script>alert('Data admin tidak ditemukan');</script>";
  exit();
}
// end 1.1

// $username = $_SESSION['nama_admin'];

// // Mengambil data dari form
// // $id_admin = $_GET["id_admin"];

// // Memeriksa koneksi
// if (!$conn) {
//   die("Koneksi gagal: " . mysqli_connect_error());
// }

// Menjalankan query untuk mengambil data
// $sql = "SELECT * FROM data_admin";
// $result = mysqli_query($conn, $sql);

// Memeriksa apakah form sudah di-submit
if(isset($_POST['submit'])) {
  // Mengambil data dari form
  $id_apoteker = $_POST['id_apoteker'];
  $nama_apoteker = $_POST['nama_apoteker'];
  $riwayat_apoteker = $_POST['riwayat_apoteker'];
  $alamat_apoteker = $_POST['alamat_apoteker'];
  $notelp_apoteker = $_POST['notelp_apoteker'];
  $password_apoteker = $_POST['password_apoteker'];

  // Memeriksa apakah ada input yang kosong
  if(empty($id_apoteker) || empty($nama_apoteker) || empty($riwayat_apoteker) || empty($alamat_apoteker) || empty($notelp_apoteker) || empty($password_apoteker)) {
    echo '<script>alert("data tidak boleh kosong!")</script>';
  } else {
    // Memeriksa apakah noTelpDokter berupa angka
    if (!is_numeric($notelp_apoteker)) {
      echo '<script>alert("Nomor telepon harus berupa angka!")</script>';
    } elseif (!is_numeric($password_apoteker)) {
      echo '<script>alert("password harus berupa angka!")</script>';
    } else {
      // Proses penyimpanan atau pembaruan data di sini
      // Query untuk memeriksa apakah nama_dokter yang diubah sama dengan nama_dokter sebelumnya
        $check_query = "SELECT * FROM data_apoteker WHERE id_apoteker != $id_apoteker AND nama_apoteker = '$nama_apoteker'";
        $check_result = mysqli_query($conn, $check_query);
        $check_row = mysqli_fetch_assoc($check_result);
      // ...

      if ($check_row) {
        // Jika nama_dokter sudah ada, tampilkan alert
        echo "<script>alert('Nama apoteker sudah ada.')</script>";
      } else {
        // Query untuk update data
        $update_query = "UPDATE data_apoteker SET nama_apoteker='$nama_apoteker', riwayat_apoteker='$riwayat_apoteker', alamat_apoteker='$alamat_apoteker', notelp_apoteker='$notelp_apoteker', password_apoteker='$password_apoteker', id_admin='$id_admin' WHERE id_apoteker=$id_apoteker";
        mysqli_query($conn, $update_query);
        echo "<script>alert('Data berhasil di-update')</script>";
        header("Location: edit_apoteker.php");
      }
    }
  }

}

// Memeriksa apakah parameter id di-set
if(isset($_GET["id_apoteker"])) {
  $id_apoteker = $_GET["id_apoteker"];
  // Query untuk mengambil data dengan id yang dipilih
  $query = "SELECT * FROM data_apoteker WHERE id_apoteker=$id_apoteker";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
} else {
  // Jika parameter id tidak di-set, kembali ke halaman utama
  // header("Location: indexx.php");
  // exit();
}

// Logout
if(isset($_POST['logout'])) {
  // Hapus data sesi
  session_unset();
  session_destroy();

  // Redirect ke halaman login setelah logout
  header('Location: ../../../index.php');
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
        background-image: url('background/admin1.jpg');
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
            <?php echo "Selamat datang,admin " . $username . " :)"; ?>
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
          <div>
            
          </div>
          <div class="dropdown mt-3">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
              Edit
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="edit_dokter.php">dokter</a></li>
              <li><a class="dropdown-item" href="edit_apoteker.php">apoteker</a></li>
              <li><a class="dropdown-item" href="edit_pasien.php">pasien</a></li>
              <li><a class="dropdown-item" href="edit_obat.php">obat</a></li>
            </ul>
          </div>
          <div class="dropdown mt-3">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
              Input
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="../../registrasi_dokter.php">dokter</a></li>
                <li><a class="dropdown-item" href="../../registrasi_apoteker.php">apoteker</a></li>
                <!-- <li><a class="dropdown-item" href="registrasi_pasien.php">pasien</a></li> -->
              </ul>
          </div>
          <form action="" method="post">
          <button type="submit" name="logout" class="btn btn-danger">Log out</button>
          </form>
        </div>
      </div>
    <!-- end sidebar -->

    <!-- isi -->
    <div class="container my-5">
        <div class="p-5  bg-body-tertiary rounded-3">
          <h4 class="text-body-emphasis text-center">Edit apoteker</h4>
          <!-- form -->
          <form class="g-3 needs-validation" method="POST" novalidate>
            <input type="hidden" name="id_apoteker" value="<?php echo $row['id_apoteker']; ?>">
            <div class="">
              <label for="">nama apoteker</label>
              <input type="text" class="" id="validationCustom01" name="nama_apoteker" value="<?php echo $row['nama_apoteker']; ?>"> <br><br>
            </div>
            <div class="">
              <label for="">riwayat apoteker</label>
              <input type="text" class="" id="validationCustom01" name="riwayat_apoteker" value="<?php echo $row['riwayat_apoteker']; ?>"> <br><br>
            </div>

            <div class="">
              <label for="">alamat apoteker</label>
              <input type="text" class="" id="validationCustom01" name="alamat_apoteker" value="<?php echo $row['alamat_apoteker']; ?>"> <br><br>
            </div>
            <div class="">
              <label for="">nomor telepon</label>
              <input type="text" class="" id="validationCustom01" name="notelp_apoteker" value="<?php echo $row['notelp_apoteker']; ?>"> <br><br>
            </div>
            <div class="">
              <label for="">password apoteker</label>
              <input type="text" class="" id="validationCustom01" name="password_apoteker" value="<?php echo $row['password_apoteker']; ?>"> <br><br>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" name="submit" type="submit">Edit</button>
            </div>
          </form>
          <!-- end form -->
        </div>
      </div>
    <!-- end isi -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>