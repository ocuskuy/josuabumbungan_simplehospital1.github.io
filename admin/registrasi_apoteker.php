<?php
session_start();

// Informasi koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_rumah sakit";

// Membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $dbname);

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

// Memeriksa apakah form sudah di-submit
if (isset($_POST['submit'])) {
  // Mengambil data dari form
  $nama_apoteker = $_POST['nama_apoteker'];
  $riwayat_apoteker = $_POST['riwayat_apoteker'];
  $alamat_apoteker = $_POST['alamat_apoteker'];
  $notelp_apoteker = $_POST['notelp_apoteker'];
  $password_apoteker = $_POST['password_apoteker'];

  // Validasi input
  if ($nama_apoteker !== '' && $password_apoteker !== '' && $riwayat_apoteker !== '' && $notelp_apoteker !== '' && $alamat_apoteker !== '') {
    // Validasi nomor telepon menggunakan regular expression
    if (!preg_match('/^[0-9]+$/', $notelp_apoteker)) {
      echo "<script>alert('nomor telepon apoteker hanya boleh berisi angka!');</script>";
    } elseif (!preg_match('/^[0-9]+$/', $password_apoteker)){
      echo "<script>alert('password apoteker hanya boleh berisi angka!');</script>";
    } else {
      // Query untuk memeriksa apakah data sudah ada di database
      $query = "SELECT * FROM data_apoteker WHERE nama_apoteker='$nama_apoteker'";
      $result = mysqli_query($conn, $query);

      // Jika data sudah ada di database, tampilkan alert
      if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('nama apoteker $nama_apoteker sudah terdaftar!')</script>";
      } else {
        // Jika data belum ada di database, lakukan insert data
        $insert_query = "INSERT INTO data_apoteker (nama_apoteker, riwayat_apoteker, alamat_apoteker, notelp_apoteker, password_apoteker, id_admin) VALUES ('$nama_apoteker', '$riwayat_apoteker', '$alamat_apoteker', '$notelp_apoteker', '$password_apoteker', '$id_admin')";
        mysqli_query($conn, $insert_query);

        echo "<script>alert('Data berhasil dimasukkan ke database')</script>";
        // Reset nilai input setelah berhasil memasukkan data
        $nama_apoteker = '';
        $riwayat_apoteker = '';
        $alamat_apoteker = '';
        $notelp_apoteker = '';
        $password_apoteker = '';
      }
    }
  } else {
    echo "<script>alert('Lengkapi semua registrasi apoteker!')</script>";
  }
}

// Logout
if(isset($_POST['logout'])) {
  // Hapus data sesi
  session_unset();
  session_destroy();

  // Redirect ke halaman login setelah logout
  header('Location: ../index.php');
  exit();
}


// Menutup koneksi database
mysqli_close($conn);
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
              <li><a class="dropdown-item" href="edit//edit_dokter.php">dokter</a></li>
              <li><a class="dropdown-item" href="edit//edit_apoteker.php">apoteker</a></li>
              <li><a class="dropdown-item" href="edit//edit_pasien.php">pasien</a></li>
              <li><a class="dropdown-item" href="edit//edit_obat.php">obat</a></li>
            </ul>
          </div>
          <div class="dropdown mt-3">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
              Input
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="registrasi_dokter.php">dokter</a></li>
                <li><a class="dropdown-item" href="registrasi_apoteker.php">apoteker</a></li>
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
          <h4 class="text-body-emphasis text-center">Registrasi apoteker</h4>
          <!-- form -->
          <form class="g-3 needs-validation" method="POST" novalidate>
            <div class="">
              <!-- <input type="text" class="" id="validationCustom01" name="nama_apoteker" placeholder="nama apoteker" required> <br><br> -->
              <label for="">nama apoteker</label>
              <input type="text" class="" id="validationCustom01" name="nama_apoteker" placeholder="nama apoteker" value="<?php echo isset($nama_apoteker) ? $nama_apoteker : ''; ?>" required><br><br>
            </div>
            <div class="">
                <!-- <input type="text" class="" id="validationCustom01" name="riwayat_apoteker" placeholder="riwayat apoteker" required> <br><br> -->
                <label for="">riwayat apoteker</label>
                <input type="text" class="" id="validationCustom01" name="riwayat_apoteker" placeholder="riwayat apoteker" value="<?php echo isset($riwayat_apoteker) ? $riwayat_apoteker : ''; ?>" required><br><br>
            </div>

            <div class="">
                <!-- <input type="text" class="" id="validationCustom01" name="alamat_apoteker" placeholder="alamat apoteker" required> <br><br> -->
                <label for="">alamat apoteker</label>
                <input type="text" class="" id="validationCustom01" name="alamat_apoteker" placeholder="alamat apoteker" value="<?php echo isset($alamat_apoteker) ? $alamat_apoteker : ''; ?>" required><br><br>
            </div>
            <div class="">
                <!-- <input type="text" class="" id="validationCustom01" name="notelp_apoteker" placeholder="nomor telepon" required> <br><br> -->
                <label for="">nomor telepon</label>
                <input type="text" class="" id="validationCustom01" name="notelp_apoteker" placeholder="nomor telepon" value="<?php echo isset($notelp_apoteker) ? $notelp_apoteker : ''; ?>" required><br><br>
            </div>
            <div class="">
                <!-- <input type="text" class="" id="validationCustom01" name="password_apoteker" placeholder="password apoteker" required> <br><br> -->
                <label for="">password apoteker</label>
                <input type="text" class="" id="validationCustom01" name="password_apoteker" placeholder="password apoteker" value="<?php echo isset($password_apoteker) ? $password_apoteker : ''; ?>" required><br><br>
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