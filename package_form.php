<?php
include_once 'layout/header.php';
require 'functions/function_package.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 style="font-size : 18px;" class="m-0 font-weight-bold text-dark">
        <center>Edit Produk</center>
      </h6>
    </div>
    <div class="card-body">
      <form action="functions/function_package.php" method="POST" enctype="multipart/form-data">
        <?php
        $package_code   = $_GET['package_code'];
        $get  = showData($package_code);
        ?>
        <?php foreach ($get as $data) { ?>
          <div class="row">
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">Kode Paket</label>
              <input name="package_code" type="text" class="form-control form-control-sm" value="<?= $data['package_code']; ?>">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">Nama Paket</label>
              <input name="package_name" type="text" class="form-control form-control-sm" value="<?= $data['package_name']; ?>">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">Kategori Paket</label>
              <input name="category_code" type="text" class="form-control form-control-sm" value="<?= $data['category_code']; ?>">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">Jenis</label>
              <input name="smell_type" type="text" class="form-control form-control-sm" value="<?= $data['smell_type']; ?>">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">Jenis Kelamin</label>
              <input name="gender" type="text" class="form-control form-control-sm" value="<?= $data['gender']; ?>">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">Harga</label>
              <input name="price" type="text" class="form-control form-control-sm" value="<?= $data['price']; ?>">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">Komisi Seller</label>
              <input name="commission" type="text" class="form-control form-control-sm" value="<?= $data['commission']; ?>">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">Kurir Pengiriman</label>
              <input name="ship_code" type="text" class="form-control form-control-sm" value="<?= $data['ship_code']; ?>">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">Deskripsi</label>
              <input name="description" type="text" class="form-control form-control-sm" value="<?= $data['description']; ?>">
            </div>
          </div>
          <br>
        <?php } ?>
        <input type="hidden" name="edit">
        <button class="btn btn-primary btn-sm">Simpan</button>
        <a class="btn btn-secondary btn-sm" href="package.php">Batal</a>
      </form>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

<?php
include_once 'layout/footer.php';
?>