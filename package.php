<?php
include_once 'layout/header.php';
require 'functions/function_package.php';
$packages = getData();
$no = 1;
?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div style="font-size : 11px;" class="card-body">
      <div class="table-responsive">
        <h6><i style="color : red; font-weight: bold;">Pastikan Format Deskripsi Produk Sesuai !!!</i></h6>
        <h7><i>Download Disini untuk Melihat Format Data Produk</i></h7>&emsp;<button onclick="JavaScript:window.location.href='download.php?file=Example Summary.xlsx';" style="font-size: 12px;" class="btn btn-primary btn-sm"> Download</button><br />
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 style="font-size : 18px;" class="m-0 font-weight-bold text-dark">
        <center>Data Paket</center>
      </h6>
    </div>
    <div class="card-body">
      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
<<<<<<< HEAD
        <button type="button" class="btn c-btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal1">Tambah Data Produk</button>
        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Produk</h5>
              </div>
              <div class="modal-body">
                <form action="functions/function_package.php" method="POST">
                 <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Kategori Produk</label>
                    <div class="col-sm-10">
                      <input type="text" name="category_product" class="form-control form-control-sm" id="inputEmail3" require>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Kode Produk</label>
                    <div class="col-sm-10">
                      <input type="text" name="category_code" class="form-control form-control-sm" id="inputEmail3" require>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Nama Paket</label>
                    <div class="col-sm-10">
                      <input type="text" name="category_name" class="form-control form-control-sm" id="inputEmail3" require>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Jenis</label>
                    <div class="col-sm-10">
                      <input type="text" name="smell_type" class="form-control form-control-sm" id="inputEmail3" require>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Jenis Kelamin</label>
                    <div class="col-sm-10">
                      <input type="text" name="gender" class="form-control form-control-sm" id="inputEmail3" require>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Harga</label>
                    <div class="col-sm-10">
                      <input type="text" name="price" class="form-control form-control-sm" id="inputEmail3" require>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Komisi Seller</label>
                    <div class="col-sm-10">
                      <input type="text" name="commission" class="form-control form-control-sm" id="inputEmail3" require>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Kurir</label>
                    <div class="col-sm-10">
                      <input type="text" name="ship_code" class="form-control form-control-sm" id="inputEmail3" require>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Deskripsi</label>
                    <div class="col-sm-10">
                      <input type="text" name="description" class="form-control form-control-sm" id="inputEmail3" require>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <input type="hidden" name="add">
                    <button class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-outline-secondary btn-sm" href="package.php">Batal</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
=======
        <!-- <button type="button" id="btnAdd" class="btn c-btn-primary">Tambah Data Produk</button> -->
        <a type="button" class="btn c-btn-primary btn-sm" href="package_form.php">Tambah Data</a>
>>>>>>> mabro
      </div>
      <br>
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th style="text-align: center;">Kategori Produk</th>
              <th style="text-align: center;">Kode Produk</th>
              <th style="text-align: center;">Nama Paket</th>
<<<<<<< HEAD
              <th style="text-align: center;">Jenis</th>
=======
              <th style="text-align: center;">Kategori Paket</th>
>>>>>>> mabro
              <th style="text-align: center;">Jenis Kelamin</th>
              <th style="text-align: center;">Harga</th>
              <th style="text-align: center;">Komisi Seller</th>
              <th style="text-align: center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($packages as $data) { ?>
              <tr>
<<<<<<< HEAD
                <td style="text-align: center;"><?= $no++; ?></td>
                <td style="text-align: center;"><?= $data['category_product'] ?></td>
                <td style="text-align: center;"><?= $data['category_code'] ?></td>
                <td style="text-align: center;"><?= $data['category_name'] ?></td>
                <td style="text-align: center;"><?= $data['smell_type'] ?></td>
                <td style="text-align: center;"><?= $data['gender'] ?></td>
                <td style="text-align: center;"><?= $data['price'] ?></td>
                <td style="text-align: center;"><?= $data['commission'] ?></td>
                <td style="text-align: center;"><?= $data['ship_code'] ?></td>
                <td style="text-align: center;"><a href="<?= 'package_form.php?category_product=' . $data['category_code']; ?>" class="btn btn-info btn-circle btn-sm"><i class="fas fa-pen"></i></a>
                  &nbsp;<a href="<?= 'functions/function_package.php?hapus=' . $data['package_code']; ?>" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></a></td>
=======
                <td style="text-align: center;"><?= $data['package_code'] ?></td>
                <td style="text-align: center;"><?= $data['package_name'] ?></td>
                <td style="text-align: center;"><?= $data['category_name'] ?></td>
                <td style="text-align: center;"><?= $data['gender_name'] ?></td>
                <td style="text-align: center;"><?= number_format($data['price'], 2, ',', '.'); ?></td>
                <td style="text-align: center;"><?= number_format($data['commission'], 2, ',', '.'); ?></td>
                <td style="text-align: center;"><a href="<?= 'package_form.php?id=' . $data['package_code']; ?>" class="btn btn-info btn-circle btn-sm"><i class="fas fa-pen"></i></a>
                  &nbsp;<a href="<?= 'functions/function_package.php?remove=' . $data['package_code']; ?>" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></a></td>
>>>>>>> mabro
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

<?php
include_once 'layout/footer.php';
if (isset($_SESSION['message'])) {
  $msg = $_SESSION['message'];
  echo "<script>Swal.fire({
            icon: '" . $msg['icon'] . "',
            title: '" . $msg['title'] . "',
            text: `" . $msg['text'] . "`,
            showConfirmButton: false,
            timer: 2500
        });</script>";
  unset($_SESSION['message']);
}
?>