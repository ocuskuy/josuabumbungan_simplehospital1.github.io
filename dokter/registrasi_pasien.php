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


  // 1.1
  // Memeriksa apakah pengguna telah login
  if (!isset($_SESSION['nama_dokter'])) {
    // Redirect ke halaman login jika pengguna belum login
    header('Location: ../index.php');
    exit();
  }

  $username = $_SESSION['nama_dokter'];

  // Memeriksa koneksi
  if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
  }

  // Menjalankan query untuk mengambil data admin
  $sql_dokter = "SELECT * FROM data_dokter WHERE nama_dokter='$username'";
  $result_dokter = mysqli_query($conn, $sql_dokter);

  // Memeriksa apakah data admin ditemukan
  if (mysqli_num_rows($result_dokter) > 0) {
    // Mengambil data admin
    $row_dokter = mysqli_fetch_assoc($result_dokter);
    $id_dokter = $row_dokter['id_dokter']; // Mengambil ID admin yang sesuai
  } else {
    // Tindakan jika data admin tidak ditemukan
    echo "<script>alert('Data dokter tidak ditemukan');</script>";
    // exit();
  }
  // end 1.1
  // Query untuk mendapatkan data pasien berdasarkan ID dokter
  $query_get_pasien = "SELECT * FROM data_pasien WHERE id_dokter='$id_dokter'"; 

  // cek2
  // Menjalankan query untuk mengambil data obat
  $sql_obat = "SELECT * FROM data_obat";
  $result_obat = mysqli_query($conn, $sql_obat);

  // Memeriksa apakah data obat ditemukan
  if (mysqli_num_rows($result_obat) <= 0) {
    // Tindakan jika data obat tidak ditemukan
    echo "<script>alert('Data obat tidak ditemukan');</script>";
    exit();
  }
  // end cek2
  
  // 1.2
  // Memeriksa apakah form sudah di-submit
  if(isset($_POST['submit'])) {
    // Mengambil data dari form
    // $id_obat = $_POST['id_obat'];
    $id_obat = $_POST['id_obat'];
    $nama_pasien = $_POST['nama_pasien'];
    $penyakit_pasien = $_POST['penyakit_pasien'];
    $umur_pasien = $_POST['umur_pasien'];
    $password_pasien = $_POST['password_pasien'];
    // $jk_pasien = '';

    if (isset($_POST['jk_pasien'])) {
      $jk_pasien = $_POST['jk_pasien'];
      // Lakukan sesuatu dengan nilai $jk_pasien
      // havi
    // Validasi input
    if ($nama_pasien !== '' && $password_pasien !== '' && $jk_pasien !== '' && $umur_pasien !== '') {
      // Validasi umur pasien menggunakan regular expression
      if (!preg_match('/^[0-9]+$/', $umur_pasien)) {
        echo "<script>alert('umur pasien hanya boleh berisi angka!');</script>";
      } elseif (!preg_match('/^[0-9]+$/', $password_pasien)) {
        echo "<script>alert('password pasien hanya boleh berisi angka!');</script>";
      } else {

        // if  (isset($_POST['id_pasien'])) {
        //   $id_pasien = '';
        // } else {
        //   echo "<script>alert('data entry!');</script>";
        // }

        // $query = "SELECT * FROM data_pasien INNER JOIN data_dokter ON data_pasien.id_dokter = data_dokter.id_dokter WHERE data_dokter.id_dokter = '$id_dokter'";
        $query = "SELECT * FROM data_pasien WHERE nama_pasien = '$nama_pasien'";
        // $query = "SELECT * FROM data_pasien WHERE id_pasien = '$id_pasien'";
        $result = mysqli_query($conn, $query);

        // Jika data sudah ada di database, tampilkan alert
        if(mysqli_num_rows($result) > 0) {
            echo "<script>alert('Data dengan nama pasien $nama_pasien sudah ada!')</script>";
        } else {
            // $_SESSION['nama_dokter'] = $nama_dokter;
            // $_SESSION['role'] = "data_admin";
            
            // Jika data belum ada di database, lakukan insert data
            $insert_query = "INSERT INTO data_pasien (nama_pasien, penyakit_pasien, password_pasien, jk_pasien, umur_pasien, id_dokter, id_obat) VALUES ('$nama_pasien', '$penyakit_pasien', '$password_pasien', '$jk_pasien', '$umur_pasien', '$id_dokter', '$id_obat')";
            mysqli_query($conn, $insert_query);

            $conn = mysqli_query($conn, $query);
            if ($conn) {
                echo "Data berhasil disimpan.";
            } else {
                echo "Terjadi kesalahan: " . mysqli_error($conn);
            }

            
            echo "<script>alert('Data berhasil dimasukkan ke database')</script>";
            // Reset nilai input setelah berhasil memasukkan data
            $nama_pasien = '';
            $penyakit_pasien = '';
            $umur_pasien = '';
            $password_pasien = '';
            $jk_pasien = '';
        }
      }
    } else {
      // Jika ada input yang kosong, munculkan alert
      echo "<script>alert('Lengkapi semua data!');</script>";
    }
    // end havi
    } else {
      echo "<script>alert('Pilih jenis kelamin!');</script>";
    }

    
  }
  // end 1.2

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
                <li><a class="dropdown-item" href="PASIEN1.php">obat pasien</a></li>
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
                <label for="">nama pasien</label>
                <input type="text" class="" id="validationCustom01" name="nama_pasien" placeholder="nama pasien" value="<?php echo isset($nama_pasien) ? $nama_pasien : ''; ?>" required><br><br>
              </div>
              <div class="">
                <label for="">penyakit pasien</label>
                <input type="text" class="" id="validationCustom01" name="penyakit_pasien" placeholder="penyakit pasien" value="<?php echo isset($penyakit_pasien) ? $penyakit_pasien : ''; ?>" required><br><br>
              </div>

              <!-- jk -->
              <label class="form-check-label" >jenis kelamin :</label>
              <div class="form-check form-check-inline">
                  <!-- <input class="form-check-input" type="radio" name="jk_pasien" id="inlineRadio1" value="laki-laki"> -->
                  <input class="form-check-input" type="radio" name="jk_pasien" id="inlineRadio1" value="laki-laki" <?php echo (isset($jk_pasien) && $jk_pasien == 'laki-laki') ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="inlineRadio1">laki-laki</label>
                </div>
                <div class="form-check form-check-inline">
                  <!-- <input class="form-check-input" type="radio" name="jk_pasien" id="inlineRadio2" value="perempuan"> -->
                  <input class="form-check-input" type="radio" name="jk_pasien" id="inlineRadio2" value="perempuan" <?php echo (isset($jk_pasien) && $jk_pasien == 'perempuan') ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="inlineRadio2">perempuan</label>
                </div> <br><br>
              <!-- end jk -->

              <!-- pilih obat -->
              <label class="form-check-label" for="">Pilih Obat:</label><br>
              <select name="id_obat" id="id_obat">
                <?php
                  // Menampilkan opsi obat dari database
                  while ($row_obat = mysqli_fetch_assoc($result_obat)) {
                    echo "<option value='".$row_obat['id_obat']."'>".$row_obat['nama_obat']."</option>";
                  }
                ?>
              </select><br>
              <!-- end pilih obat -->

              <div class="">
                <label for="">umur pasien</label>
                <input type="text" class="" id="validationCustom01" name="umur_pasien" placeholder="umur pasien" value="<?php echo isset($umur_pasien) ? $umur_pasien : ''; ?>" required><br><br>
              </div>
              <div class="">
                <label for="">password pasien</label>
                <input type="text" class="" id="validationCustom01" name="password_pasien" placeholder="password pasien" value="<?php echo isset($password_pasien) ? $password_pasien : ''; ?>" required><br><br>
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