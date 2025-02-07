<?php
session_start();
// NOT LOGGED IN
if ($_SESSION['login'] != "yes") {
    header("location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard - Jawara Group</title>
    <link rel="icon" type="image/x-icon" href="img/favicon1.png" />

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/font.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/toast.css">
    <link rel="stylesheet" href="css/style-admin.css">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="custom-bg-primary navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="super_index.php">
                <div class= "sidebar-brand-text mx-3" >
                    Jawara Group <span style="font-size: 8px;">v1.1.0</span>
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="super_index.php">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Home</span></a>
            </li>
            <?php

            $role = $_SESSION['role'];

            $menuUser = '<a class="collapse-item" href="data_user.php">Data User</a>';
            $menuMitra = '<a class="collapse-item" href="data_mitra.php">Data Mitra</a>';
            $menuGenMitra = '<a class="collapse-item" href="data_generation.php">Data Generasi Mitra</a>';
            $menuPackage = '<a class="nav-link" href="data_package.php"><i class="fas fa-fw fa-upload"></i><span>Data Produk</span></a>';
            $menuRole = '<a class="collapse-item" href="data_role.php">Data Role</a>';


            if ($role == 1) {
                //Nav Item - Data Master
                echo    '<li class="nav-item">
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#datamaster" aria-expanded="true" aria-controls="datauser">
                                <i class="fas fa-fw fa-database"></i>
                                    <span>Data Master</span>
                            </a>
                            <div id="datamaster" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                                <div class="bg-white py-2 collapse-inner rounded">
                                    ' . $menuUser . '
                                    ' . $menuMitra . '
                                    ' . $menuGenMitra . '
                                    ' . $menuRole . '
                                </div>
                            </div>
                        </li>';
                // Heading
                echo    '<div class="sidebar-heading">INPUT</div>';

                // Nav Item - Output Summary
                echo    '<li class="nav-item">
                            ' . $menuPackage . '
                        </li>';

            }

            if ($role == 2) {
                //Nav Item - Data Master
                echo    '<li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#datamaster" aria-expanded="true" aria-controls="datauser">
                    <i class="fas fa-fw fa-database"></i>
                        <span>Data Mitra</span>
                </a>
                <div id="datamaster" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        ' . $menuMitra . '
                    </div>
                </div>
            </li>';
            }
            ?>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- <div>
                <span style=" font-size : 14px; color : red;"><strong><marquee behavior="alternate" direction="right">FYI : Data Summary Dapat Di Edit Dan Upload Packing ada 2 Opsi ( Solid dan Prepack) Untuk sementara Prepack Masih Belum Dapat di Gunakan. Terimakasih..</marquee></strong></span>
            </div> -->
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><strong style="font-size: 12px; text-transform: uppercase;"><?= $_SESSION['username']; ?></strong></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="functions/logout.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->