<?php
session_start();

// Informasi koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_rumah_sakit";

// Membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Memeriksa apakah pengguna telah login
if (!isset($_SESSION['nama_admin'])) {
  // Redirect ke halaman login jika pengguna belum login
  header('Location: ../index.php');
  exit();
}

$username = $_SESSION['nama_admin'];
// Cek koneksi
if (mysqli_connect_errno()) {
  echo "Koneksi database gagal: " . mysqli_connect_error();
}

// Memeriksa apakah form sudah di-submit
if (isset($_POST['submit'])) {
  // Mengambil data dari form
  $nama_pasien = $_POST['nama_pasien'];
  $penyakit_pasien = $_POST['penyakit_pasien'];
  $jk_pasien = $_POST['jk_pasien'];
  $umur_pasien = $_POST['umur_pasien'];

  // Validasi input
  if ($nama_pasien !== '' && $penyakit_pasien !== '' && $jk_pasien !== '' && $umur_pasien !== '') {
    // Query untuk memeriksa apakah data sudah ada di database
    $query = "SELECT * FROM data_pasien WHERE nama_pasien='$nama_pasien'";
    $result = mysqli_query($conn, $query);

    // Jika data sudah ada di database, tampilkan alert
    if (mysqli_num_rows($result) > 0) {
      echo "<script>alert('Data dengan nama pasien $nama_pasien sudah ada di database')</script>";
    } else {
      // Jika data belum ada di database, lakukan insert data
      $insert_query = "INSERT INTO data_pasien (nama_pasien, penyakit_pasien, jk_pasien, umur_pasien) VALUES ('$nama_pasien', '$penyakit_pasien', '$jk_pasien', '$umur_pasien')";
      mysqli_query($conn, $insert_query);
      echo "<script>alert('Data berhasil dimasukkan ke database')</script>";

      // Mengambil ID pasien yang baru saja diinsert
      $id_pasien = mysqli_insert_id($conn);

      // Mengambil data obat dari form
      $nama_obat = $_POST['nama_obat'];
      $jumlah_obat = $_POST['jumlah_obat'];

      // Validasi input obat
      if ($nama_obat !== '' && $jumlah_obat !== '') {
        // Looping untuk menginsert setiap obat yang diinput
        for ($i = 0; $i < count($nama_obat); $i++) {
          $current_nama_obat = $nama_obat[$i];
          $current_jumlah_obat = $jumlah_obat[$i];

          // Insert data obat ke tabel data_obat
          $insert_obat_query = "INSERT INTO data_obat (id_pasien, nama_obat, jumlah_obat) VALUES ('$id_pasien', '$current_nama_obat', '$current_jumlah_obat')";
          mysqli_query($conn, $insert_obat_query);
        }

        echo "<script>alert('Data obat berhasil dimasukkan ke database')</script>";
        header('Location: index.php');
        exit();
      } else {
        // Jika ada input obat yang kosong, munculkan alert
        echo "<script>alert('Lengkapi data obat!')</script>";
      }
    }
  } else {
    // Jika ada input yang kosong, munculkan alert
    echo "<script>alert('Lengkapi semua data!')</script>";
  }
}

// Logout
if (isset($_POST['logout'])) {
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
  <title>Registrasi pasien</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>

  <!-- navbar -->
  <!-- As a heading -->
  <nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
      <span class="navbar-brand mb-0 h1">
        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
          aria-controls="offcanvasExample">
          sidebar
        </button>
        <?php echo "Selamat datang, admin " . $username . " :)"; ?>
      </span>
      <ul class="nav justify-content-end">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Active</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled">Disabled</a>
        </li>
      </ul>
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
          <li><a class="dropdown-item" href="edit/edit_dokter.php">dokter</a></li>
          <li><a class="dropdown-item" href="edit/edit_apoteker.php">apoteker</a></li>
          <li><a class="dropdown-item" href="edit/edit_pasien.php">pasien</a></li>
        </ul>
      </div>
      <div class="dropdown mt-3">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
          Input
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="registrasi_dokter.php">dokter</a></li>
          <li><a class="dropdown-item" href="registrasi_apoteker.php">apoteker</a></li>
          <li><a class="dropdown-item" href="registrasi_pasien.php">pasien</a></li>
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
      <h4 class="text-body-emphasis text-center">Registrasi pasien</h4>
      <!-- form -->
      <form class="g-3 needs-validation" method="POST" novalidate>
        <div class="">
          <input type="text" class="" id="validationCustom01" name="nama_pasien" placeholder="nama pasien" required>
          <br><br>
        </div>
        <div class="">
          <input type="text" class="" id="validationCustom01" name="penyakit_pasien" placeholder="penyakit pasien"
            required>
          <br><br>
        </div>

        <!-- jk -->
        <label class="form-check-label">jenis kelamin :</label>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="jk_pasien" id="inlineRadio1" value="laki-laki">
          <label class="form-check-label" for="inlineRadio1">laki-laki</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="jk_pasien" id="inlineRadio2" value="perempuan">
          <label class="form-check-label" for="inlineRadio2">perempuan</label>
        </div>
        <br><br>
        <!-- end jk -->

        <div class="">
          <input type="text" class="" id="validationCustom01" name="umur_pasien" placeholder="nomor telepon"
            required>
          <br><br>
        </div>

        <!-- input obat -->
        <h5 class="text-body-emphasis text-center">Input Obat</h5>

        <div class="mb-3">
          <label for="obat" class="form-label">Obat</label>
          <input type="text" class="form-control" id="obat" name="obat" placeholder="nama obat" required>
        </div>

        <div class="mb-3">
          <label for="dosis" class="form-label">Dosis</label>
          <input type="text" class="form-control" id="dosis" name="dosis" placeholder="dosis obat" required>
        </div>

        <div class="col-12">
          <button class="btn btn-primary" name="submit" type="submit">Submit</button>
        </div>
      </form>
      <!-- end form -->
    </div>
  </div>
  <!-- end isi -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Jjg/rh2lKPZoH1mDeiJp/JsQqPz0EH7qs2v9BlgStvD+MExj/C4mIyjDrCPE4ICi" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
  <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
      'use strict'

      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.querySelectorAll('.needs-validation')

      // Loop over them and prevent submission
      Array.prototype.slice.call(forms)
        .forEach(function (form) {
          form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }

            form.classList.add('was-validated')
          }, false)
        })
    })()
  </script>
</body>

</html>
