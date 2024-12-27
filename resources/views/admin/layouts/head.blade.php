
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TOKO ADIT SEMBAKO</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/vendor/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/vendor/AdminLTE-3.2.0/dist/css/adminlte.min.css">


  <style>
    /* Fixed Sidebar */
    .main-sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh; /* Sidebar penuh layar */
      width: 250px;
      z-index: 1030;
      overflow-y: auto;
    }


    /* Fixed Navbar */
    .main-header {
      position: relative;
      top: 0;
      left: 0;
      width: auto; /* Sesuaikan lebar sesuai kebutuhan */
      z-index: 1040; /* Contoh: Atur lebih tinggi dari sidebar */
    }
    .sidebar {
      height: calc(100vh - 4rem); /* Sesuaikan dengan navbar */
    }


    /* Konten utama */
    .content-wrapper {
/* Memberikan ruang untuk navbar */
      margin-left: 250px; /* Memberikan ruang untuk sidebar */
      padding-bottom: 100px; /* Memberikan ruang untuk footer */
    }

    /* Fixed Footer */


      /* Footer */
    .main-footer {
      position: fixed;
      bottom: 0;
      left: 0px; /* Sesuaikan dengan lebar sidebar */
      width: 100%; /* Sisa ruang di samping sidebar */
      background-color: #f8f9fa; /* Warna footer */
      text-align: left;
      padding: 10px 20px; /* Padding footer */
      border-top: 1px solid #ddd; /* Garis atas untuk footer */
      z-index: 1030; /* Agar footer tetap di atas konten */
    }

    /* Reset margin dan padding */
    body, html {
      margin: 0;
      padding: 0;
    }

  </style>

</head>
<body class="hold-transition sidebar-mini">