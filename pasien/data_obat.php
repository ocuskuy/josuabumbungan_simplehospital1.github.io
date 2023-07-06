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
if (!isset($_SESSION['nama_pasien'])) {
  // Redirect ke halaman login jika pengguna belum login
  header('Location: ../index.php');
  exit();
}

$username = $_SESSION['nama_pasien'];

// 1.1
// Memeriksa apakah pengguna telah login
if (!isset($_SESSION['nama_pasien'])) {
  // Redirect ke halaman login jika pengguna belum login
  header('Location: ../index.php');
  exit();
}

$pasien_username = $_SESSION['nama_pasien'];

// Memeriksa koneksi
if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

// Menjalankan query untuk mengambil data pasien
$sql_pasien = "SELECT * FROM data_pasien WHERE nama_pasien='$pasien_username'";
$result_pasien = mysqli_query($conn, $sql_pasien);

// Memeriksa apakah data pasien ditemukan
if (mysqli_num_rows($result_pasien) > 0) {
  // Mengambil data pasien
  $row_pasien = mysqli_fetch_assoc($result_pasien);
  $id_pasien = $row_pasien['id_pasien']; // Mengambil ID pasien yang sesuai
} else {
  // Tindakan jika data pasien tidak ditemukan
  echo "<script>alert('Data pasien tidak ditemukan');</script>";
  exit();
}
// end 1.1
// if (!$result) {
//   die("Error dalam eksekusi query: " . mysqli_error($conn));
// }

// Menjalankan query untuk mengambil data obat yang diberikan oleh dokter kepada pasien
$sql_obat = "SELECT data_obat.nama_obat, data_obat.jenis_obat, data_obat.golongan_obat
             FROM data_obat
             JOIN data_obat_pasien ON data_obat.id_obat = data_obat_pasien.id_obat
             JOIN data_pasien ON data_obat_pasien.id_pasien = data_pasien.id_pasien
             WHERE data_pasien.id_pasien = '$id_pasien'";
$result_obat = mysqli_query($conn, $sql_obat);

// Memeriksa apakah data obat ditemukan
if (mysqli_num_rows($result_obat) <= 0) {
  // Tindakan jika data obat tidak ditemukan
  echo "<script>alert('Data obat tidak ditemukan');</script>";
  // exit();
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
?>

  <!doctype html>
  <html lang="en">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>registrasi dokter</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
      <style>
        /* gambar cover bg */
        body {
          background-image: url('background/pasien1.jpg');
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
              <?php echo "Selamat datang,pasien " . $username . " :)"; ?>
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
                <li><a class="dropdown-item" href="registrasi_pasien2.php">obat pasien</a></li>
                <li><a class="dropdown-item" href="registrasi_pasien3.php">obat pasien2</a></li>
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
            <h4 class="text-body-emphasis text-center">Data pasien</h4>
            <!-- form -->
                <!-- fake waves -->
                <div class="container mt-5">
    <!-- <h1>Obat yang Diberikan oleh Dokter</h1> -->
    <hr>

    <!-- Informasi Pasien -->
    <h4>Informasi Pasien:</h4>
    <p><strong>Nama:</strong> <?php echo $row_pasien['nama_pasien']; ?></p>
    <p><strong>Jenis Kelamin:</strong> <?php echo $row_pasien['jk_pasien']; ?></p>
    <p><strong>Usia:</strong> <?php echo $row_pasien['umur_pasien']; ?> tahun</p>
    <hr>

    <!-- Tabel Obat -->
    <h4>Daftar Obat yang Diberikan:</h4>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Nama Obat</th>
          <th scope="col">Jenis Obat</th>
          <th scope="col">Golongan Obat</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($row_obat = mysqli_fetch_assoc($result_obat)) {
          echo "<tr>";
          echo "<td>" . $row_obat['nama_obat'] . "</td>";
          echo "<td>" . $row_obat['jenis_obat'] . "</td>";
          echo "<td>" . $row_obat['golongan_obat'] . "</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
                <!-- end fake waves -->
            <!-- end form -->
          </div>
        </div>
      <!-- end isi -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
  </html>