<?php
include_once 'layout/header.php';
require 'functions/function_package.php';
$package_code   = $_GET['package_code'] ?? '';
$data  = getData($package_code);
?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 id="title" class="m-0 font-weight-bold text-primary">Data Produk</h6>
    </div>
    <form action="functions/function_package.php" method="POST">
      <div class="card-body">
        <div class="form-group row">
          <label for="code" class="col-sm-2 col-form-label">Kode Paket</label>
          <div class="col-sm-10">
            <input id="code" name="code" type="text" class="form-control" placeholder="Kode" value="<?= $data['package_code'] ?? ''; ?>" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="name" class="col-sm-2 col-form-label">Nama</label>
          <div class="col-sm-10">
            <input id="name" name="name" type="text" class="form-control" placeholder="Nama Paket" value="<?= $data['package_name'] ?? ''; ?>" required>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <label for="formGroupExampleInput" class="form-label">Kategori Paket</label>
            <input name="category_code" type="text" class="form-control form-control-sm" value="<?= $data['category_code'] ?? ''; ?>">
          </div>
          <div class="col-md-3">
            <label for="formGroupExampleInput" class="form-label">Jenis</label>
            <input name="smell_type" type="text" class="form-control form-control-sm" value="<?= $data['smell_type'] ?? ''; ?>">
          </div>
          <div class="col-md-3">
            <label for="formGroupExampleInput" class="form-label">Jenis Kelamin</label>
            <input name="gender" type="text" class="form-control form-control-sm" value="<?= $data['gender'] ?? ''; ?>">
          </div>
          <div class="col-md-3">
            <label for="formGroupExampleInput" class="form-label">Harga</label>
            <input name="price" type="text" class="form-control form-control-sm" value="<?= $data['price'] ?? ''; ?>">
          </div>
          <div class="col-md-3">
            <label for="formGroupExampleInput" class="form-label">Komisi Seller</label>
            <input name="commission" type="text" class="form-control form-control-sm" value="<?= $data['commission'] ?? ''; ?>">
          </div>
          <div class="col-md-3">
            <label for="formGroupExampleInput" class="form-label">Kurir Pengiriman</label>
            <input name="ship_code" type="text" class="form-control form-control-sm" value="<?= $data['ship_code'] ?? ''; ?>">
          </div>
          <div class="col-md-3">
            <label for="formGroupExampleInput" class="form-label">Deskripsi</label>
            <input name="description" type="text" class="form-control form-control-sm" value="<?= $data['description'] ?? ''; ?>">
          </div>
        </div>
      </div>
      <div class="mt-3 d-flex justify-content-between card-footer">
        <input type="hidden" name="edit">
        <a class="btn btn-secondary ml-2" href="package.php">Batal</a>
        <button id="btnSave" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
<!-- /.container-fluid -->

<script src="js/origin/package_form.js"></script>

<?php
include_once 'layout/footer.php';
?>