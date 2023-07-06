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

$username = $_SESSION['nama_admin'];

// Mengambil data dari form
// $id_admin = $_GET["id_admin"];

// Memeriksa koneksi
if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

// Menjalankan query untuk mengambil data
// $sql = "SELECT * FROM data_admin";
// $result = mysqli_query($conn, $sql);

// Memeriksa apakah form sudah di-submit
if(isset($_POST['submit'])) {
  // Mengambil data dari form
  $id_pasien = $_POST['id_pasien'];
  $nama_pasien = $_POST['nama_pasien'];
  $penyakit_pasien = $_POST['penyakit_pasien'];
  $jk_pasien = $_POST['jk_pasien'];
  $umur_pasien = $_POST['umur_pasien'];
  $password_pasien = $_POST['password_pasien'];

  // 1.2
  // Memeriksa apakah ada input yang kosong
  if(empty($id_pasien) || empty($nama_pasien) || empty($penyakit_pasien) || empty($jk_pasien) || empty($umur_pasien) || empty($password_pasien)) {
    echo '<script>alert("data tidak boleh kosong!")</script>';
  } else {
    // Memeriksa apakah noTelpDokter berupa angka
    if (!is_numeric($umur_pasien)) {
      echo '<script>alert("umur harus berupa angka!")</script>';
    } elseif (!is_numeric($password_pasien)) {
      echo '<script>alert("password harus berupa angka!")</script>';
    } else {
      // Proses penyimpanan atau pembaruan data di sini
      // Query untuk memeriksa apakah nama_dokter yang diubah sama dengan nama_dokter sebelumnya
        $check_query = "SELECT * FROM data_pasien WHERE id_pasien != $id_pasien AND nama_pasien = '$nama_pasien'";
        $check_result = mysqli_query($conn, $check_query);
        $check_row = mysqli_fetch_assoc($check_result);
      // ...

      if ($check_row) {
        // Jika nama_dokter sudah ada, tampilkan alert
        echo "<script>alert('Nama pasien sudah ada.')</script>";
      } else {
        // Query untuk update data
        $update_query = "UPDATE data_pasien SET nama_pasien='$nama_pasien', penyakit_pasien='$penyakit_pasien', jk_pasien='$jk_pasien', umur_pasien='$umur_pasien', password_pasien='$password_pasien' WHERE id_pasien=$id_pasien";
        mysqli_query($conn, $update_query);
        echo "<script>alert('Data berhasil di-update')</script>";
        header("Location: edit_pasien.php");
      }
    }
  }
  // end 1.2
}

// Memeriksa apakah parameter id di-set
if(isset($_GET["id_pasien"])) {
  $id_pasien = $_GET["id_pasien"];
  // Query untuk mengambil data dengan id yang dipilih
  $query = "SELECT * FROM data_pasien WHERE id_pasien=$id_pasien";
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
    <title>edit apoteker</title>
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
          <h4 class="text-body-emphasis text-center">Edit pasien</h4>
          <!-- form -->
          <form class="g-3 needs-validation" method="POST" novalidate>
            <input type="hidden" name="id_pasien" value="<?php echo $row['id_pasien']; ?>">
            <div class="">
              <label for="validationCustom01" class="form-label">nama pasien :</label>
              <input type="text" class="" id="validationCustom01" name="nama_pasien" value="<?php echo $row["nama_pasien"]; ?>"> <br><br>
            </div>
            <div class="">
                <label for="validationCustom01" class="form-label">penyakit pasien :</label>
                <input type="text" class="" id="validationCustom02" name="penyakit_pasien" value="<?php echo $row['penyakit_pasien']; ?>"> <br><br>
            </div>

            <!-- jk -->
            <label class="form-check-label" >jenis kelamin :</label>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jk_pasien" id="inlineRadio1" name="jk_pasien" value="laki-laki" <?php if ($row['jk_pasien'] == "laki-laki") echo 'checked'; ?> >
                <label class="form-check-label" for="inlineRadio1">laki-laki</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jk_pasien" id="inlineRadio2" name="jk_pasien" value="perempuan" <?php if ($row['jk_pasien'] == "perempuan") echo 'checked'; ?> >
                <label class="form-check-label" for="inlineRadio2">perempuan</label>
              </div> <br><br>
            <!-- end jk -->

            <div class="">
              <label for="">umur pasien</label>
              <input type="text" class="" id="validationCustom01" name="umur_pasien" value="<?php echo $row['umur_pasien']; ?>"> <br><br>
            </div>
            <div class="">
              <label for="">password pasien</label>
              <input type="text" class="" id="validationCustom01" name="password_pasien" value="<?php echo $row['password_pasien']; ?>"> <br><br>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" value="submit" name="submit" type="submit">Edit</button>
            </div>
          </form>
          <!-- end form -->
        </div>
      </div>
    <!-- end isi -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>