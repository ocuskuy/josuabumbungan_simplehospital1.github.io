<?php
session_start();

// Konfigurasi database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_rumah sakit';

// Membuat koneksi ke database
$koneksi = mysqli_connect($host, $username, $password, $database);

// Fungsi untuk memeriksa login dokter
function loginDokter($username, $password) {
    global $koneksi;
    
    // Melakukan query ke tabel dokter
    $query = "SELECT * FROM data_dokter WHERE nama_dokter = '$username' AND password_dokter = '$password'";
    $result = mysqli_query($koneksi, $query);
    
    // Memeriksa hasil query
    if (mysqli_num_rows($result) == 1) {
        // Simpan nama pengguna ke dalam session
        // Set ID dokter ke dalam sesi
        $_SESSION['id_dokter'] = $id_dokter; 
        $_SESSION['nama_dokter'] = $username;
        $_SESSION['role'] = "data_dokter";
        header("Location: dokter/registrasi_pasien.php");
        exit();
    } else {
        // Login gagal
        echo "<script>alert('Login sebagai dokter gagal!')</script>"; 
    }
}

// Fungsi untuk memeriksa login ADMIN
function loginAdmin($username, $password) {
    global $koneksi;
    
    // Melakukan query ke tabel admin
    $query = "SELECT * FROM data_admin WHERE nama_admin = '$username' AND password_admin = '$password'";
    $result = mysqli_query($koneksi, $query);
    
    // Memeriksa hasil query
    if (mysqli_num_rows($result) == 1) {
        // Simpan nama pengguna ke dalam session
        $_SESSION['nama_admin'] = $username;
        $_SESSION['role'] = "data_admin";
        header("Location: admin/registrasi_apoteker.php");
        exit();
    } else {
        // Login gagal
        echo "<script>alert('Login sebagai admin gagal!')</script>";
    }
}

// Fungsi untuk memeriksa login pasien
function loginPasien($username, $password) {
    global $koneksi;
    
    // Melakukan query ke tabel pasien
    $query = "SELECT * FROM data_pasien WHERE nama_pasien = '$username' AND password_pasien = '$password'";
    $result = mysqli_query($koneksi, $query);
    
    // Memeriksa hasil query
    if (mysqli_num_rows($result) == 1) {
        // Simpan nama pengguna ke dalam session
        $_SESSION['nama_pasien'] = $username;
        $_SESSION['role'] = "data_pasien";
        header("Location: pasien/data_obat.php");
        exit();
    } else {
        // Login gagal
        echo "<script>alert('Login sebagai pasien gagal!')</script>";
    }
}

// Fungsi untuk memeriksa login apoteker
function loginApoteker($username, $password) {
    global $koneksi;
    
    // Melakukan query ke tabel apoteker
    $query = "SELECT * FROM data_apoteker WHERE nama_apoteker = '$username' AND password_apoteker = '$password'";
    $result = mysqli_query($koneksi, $query);
    
    // Memeriksa hasil query
    if (mysqli_num_rows($result) == 1) {
        // Simpan nama pengguna ke dalam session
        $_SESSION['nama_apoteker'] = $username;
        $_SESSION['role'] = "data_apoteker";
        header("Location: apoteker/registrasi_obat.php");
        exit();
    } else {
        // Login gagal
        echo "<script>alert('Login sebagai apoteker gagal!')</script>";
    }
}

// Memeriksa apakah form login telah disubmit
if (isset($_POST['submit'])) {
    // Mendapatkan data dari form
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Memeriksa apakah ada field yang kosong
    if (empty($role) || empty($username) || empty($password)) {
        echo "<script>alert('Silakan lengkapi semua data!')</script>";
    } else {
        // Memilih fungsi login berdasarkan peran
        switch ($role) {
            case 'dokter':
                loginDokter($username, $password);
                break;
            case 'admin':
                loginAdmin($username, $password);
                break;
            case 'pasien':
                loginPasien($username, $password);
                break;
            case 'apoteker':
                loginApoteker($username, $password);
                break;
            default:
                // echo "<script>alert('Peran tidak valid!')</script>";
                echo "<script>alert('harap pilih akun!')</script>";
                break;
        }
    }
}
?>


<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head><script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.111.3">
    <title>Signin Template · Bootstrap v5.3</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">

    

    

<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
      }
      .bd-mode-toggle {
        z-index: 1500;
      }
      /* body {
        background: linear-gradient(to right, blue, white);
        height: 200px;
        width: 100%;
      } */

      /* gambar cover bg */
      body {
        background-image: url('background/bg1.jpg');
        background-size: cover;
        /* Anda juga dapat menggunakan properti lain seperti background-repeat, background-position, dll. */
        height: 200px;
        width: 100%;
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="sign-in.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  
  </head>
  <body class="text-center">
    
<main class="form-signin w-100 m-auto">
  <form method="POST">
    <h1 class="h3 mb-3 fw-normal text-light"> Login</h1>

    <div class="form-floating">
      <input type="text" class="form-control" name="username" id="username" placeholder="name@example.com">
      <label for="floatingInput">Username</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" name="password" id="password" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>
    <div class="form-floating">
            <!-- akun -->
              <select name="role" id="role" class="form-select" aria-label="Default select example">
                <option selected>Akun</option>
                <option name="role" id="role" value="dokter">dokter</option>
                <option name="role" id="role" value="apoteker">apoteker</option>
                <option name="role" id="role" value="pasien">pasien</option>
                <option name="role" id="role" value="admin">admin</option>
              </select>
            <!-- end akun -->
    </div>

    

    <div class="checkbox mb-3">
    </div>
    <button class="w-100 btn btn-lg btn-primary" name="submit" type="submit">Login </button>
  </form>
  <!-- <p>Registrasi acc <a href="registrasi_admin.php">admin</a></p> -->
</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>
