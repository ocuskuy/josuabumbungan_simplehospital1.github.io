<?php
session_start();

// Informasi koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_rumah sakit";

// Membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Mendapatkan ID dokter dari session
$id_dokter = $_SESSION['id_dokter'];

// Melakukan query untuk mendapatkan daftar pasien yang terkait dengan dokter tersebut
$query = "SELECT * FROM data_pasien WHERE id_dokter = '$id_dokter'";
$result = mysqli_query($conn, $query);
// ...


// Memeriksa apakah pengguna telah login
if (!isset($_SESSION['nama_dokter'])) {
  // Redirect ke halaman login jika pengguna belum login
  header('Location: ../index.php');
  exit();
}

$username = $_SESSION['nama_dokter'];

// Mengecek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Proses form obat pasien
if (isset($_POST['submit_obat'])) {
    // Mengambil data dari form
    $id_pasien = $_POST['id_pasien'];
    $id_obat = $_POST['id_obat'];

    // Validasi input
    if ($id_pasien !== '' && $id_obat !== '') {
        // Query untuk mendapatkan data pasien berdasarkan ID dokter
        $query_get_pasien = "SELECT * FROM data_pasien WHERE id_dokter='$id_dokter'"; 
        // Query untuk memeriksa apakah data pasien ada di database
        $query_pasien = "SELECT * FROM data_pasien WHERE id_pasien='$id_pasien'";
        $result_pasien = mysqli_query($conn, $query_pasien);

        // Jika data pasien ada di database, lakukan insert data
        if (mysqli_num_rows($result_pasien) > 0) {

            // Query untuk memeriksa apakah data obat ada di database
            $query_obat = "SELECT * FROM data_obat WHERE id_obat='$id_obat'";
            $result_obat = mysqli_query($conn, $query_obat);

            // Jika data obat ada di database, lakukan insert data
            if (mysqli_num_rows($result_obat) > 0) {

                // Query untuk memeriksa apakah data obat sudah ada untuk pasien yang sama
                $query_check_obat = "SELECT * FROM data_obat_pasien WHERE id_pasien='$id_pasien' AND id_obat='$id_obat'";
                $result_check_obat = mysqli_query($conn, $query_check_obat);

                // Jika data obat belum ada untuk pasien yang sama, lakukan insert data
                if (mysqli_num_rows($result_check_obat) === 0) {
                    $query_insert_obat = "INSERT INTO data_obat_pasien (id_pasien, id_obat) VALUES ('$id_pasien', '$id_obat')";
                    mysqli_query($conn, $query_insert_obat);
                    echo "<script>alert('Data obat berhasil ditambahkan untuk pasien.')</script>";
                } else {
                    echo "<script>alert('Data obat sudah ada untuk pasien yang sama.')</script>";
                }
            } else {
              echo "<script>alert('Data pasien tidak ditemukan.')</script>";
            }
        } else {
            echo "<script>alert('Data pasien tidak ditemukan.')</script>";
        }
    } else {
        echo "<script>alert('Harap isi semua field.')</script>";
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
            background-image: url('background/dokter1.jpg');
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
              <?php echo "Selamat datang,Dokter " . $username . " :)"; ?>
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
                <li><a class="dropdown-item" href="registrasi_pasien.php">Registrasi pasien</a></li>
                <!-- <li><a class="dropdown-item" href="registrasi_pasien3.php">obat pasien2</a></li> -->
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
            <!-- <h4 class="text-body-emphasis text-center">Registrasi pasien</h4> -->
            <!-- form -->
                <!-- cilinder -->
                <h4 class="text-body-emphasis text-center">Pilih nama pasien & obatnya</h4>
                <form method="POST" action="">
                    <label>Nama Pasien:</label>
                    <select name="id_pasien" required>
                        <option value="">Pilih Pasien</option>
                        <?php
                            // Query untuk mendapatkan data pasien
                            $query_get_pasien = "SELECT * FROM data_pasien";
                            $result_get_pasien = mysqli_query($conn, $query_get_pasien);
                            while ($row_pasien = mysqli_fetch_assoc($result_get_pasien)) {
                                echo "<option value='".$row_pasien['id_pasien']."'>".$row_pasien['nama_pasien']."</option>";
                            }
                        ?>
                    </select><br><br>
                    <label>Nama Obat:</label>
                    <select name="id_obat" required>
                        <option value="">Pilih Obat</option>
                        <?php
                            // Query untuk mendapatkan data obat
                            $query_get_obat = "SELECT * FROM data_obat";
                            $result_get_obat = mysqli_query($conn, $query_get_obat);
                            while ($row_obat = mysqli_fetch_assoc($result_get_obat)) {
                                echo "<option value='".$row_obat['id_obat']."'>".$row_obat['nama_obat']."</option>";
                            }
                        ?>
                    </select><br><br>
                    <input type="submit" name="submit_obat" class="btn btn-primary" value="Tambahkan">
                </form>
                <!-- end cilinder -->
            <!-- end form -->
          </div>
        </div>
      <!-- end isi -->

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
  </html>