<?php
session_start();
// Informasi koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_rumah sakit";

// Membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!isset($_SESSION['username'])){
    // header("Location: index.php");
  }
  
  $username = $_SESSION['nama_admin'];

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Query untuk mengambil data dari database
$query = "SELECT * FROM data_obat ORDER BY id_obat ASC";
$result = mysqli_query($conn, $query);

// Memeriksa apakah tombol hapus di klik
if(isset($_POST["hapus"])) {
  // Mengambil data id yang akan dihapus
  $id = $_POST["id_obat"];

  // Query untuk menghapus data dari database
  $delete_query = "DELETE FROM data_obat WHERE id_obat='$id'";
  mysqli_query($conn, $delete_query);

  // Direct ke halaman index setelah berhasil menghapus data
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
    <title>Halaman daftar obat</title>
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
                <!-- <li><a class="dropdown-item" href="../../registrasi_obat.php">obat</a></li> -->
                <!-- <li><a class="dropdown-item" href="../../registrasi_pasien.php">pasien</a></li> -->
            </ul>
          </div>
          <br>
          <form action="" method="post">
          <button type="submit" name="logout" class="btn btn-danger">Log out</button>
          </form>
        </div>
      </div>
    <!-- end sidebar -->

    <!-- isi -->
    <div class="container my-5">
    <div class="p-5 bg-body-tertiary rounded-3">
        <h4 class="text-body-emphasis text-center">Daftar obat</h4>
        <!-- content -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">no</th>
                    <th scope="col">nama obat</th>
                    <th scope="col">jenis obat</th>
                    <th scope="col">golongan obat</th>
                    <th scope="col" colspan="2">aksi</th>
                </tr>
            </thead>
            <tbody>
                      <?php $no = 1; ?>
                      <?php while($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                          <td scope="row"><?= $no++; ?></td>
                          <td><?= $row["nama_obat"];?></td>
                          <td><?= $row["jenis_obat"];?></td>
                          <td><?= $row["golongan_obat"];?></td>
                          <td>
                              <form method="post">
                                  <input type="hidden" name="id_obat" value="<?= $row["id_obat"]; ?>">
                                  <button type="submit" name="hapus">Hapus</button>
                                  <?php echo "<td><a href='edit2_obat.php?id_obat=".$row['id_obat']."'>Edit</a></td>"; ?>
                              </form>
                          </td>
                        </tr>
            </tbody>
                    <?php endwhile; ?>
        </table>
        <!-- end content -->
    </div>
</div>
    <!-- end isi -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>