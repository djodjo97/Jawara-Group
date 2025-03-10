<?php
include_once 'layout/header.php';
require 'functions/function_package.php';
$package_code = $_GET['id'] ?? '';
$data  = getData($package_code);
?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 id="title" class="m-0 font-weight-bold text-primary">Data Paket</h6>
    </div>
    <form id="formAction" action="functions/function_package.php" method="POST">
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
          <div class="col-sm-4 form-group">
            <label for="category" class="form-label">Kategori</label>
            <div class="input-group option-list">
              <div class="input-group-prepend btn-option">
                <button class="btn btn-primary" type="button" id="dataOption_category"><i class="fas fa-caret-down"></i></button>
              </div>
              <input id="catCode" name="catCode" type="text" class="form-control" value="<?= $data['category_code'] ?? ''; ?>" readonly hidden>
              <input id="category" name="category" type="text" class="form-control" placeholder="Kategori" value="<?= $data['category_name'] ?? ''; ?>" required>
            </div>
          </div>
          <div class="col-sm-4 form-group">
            <label for="type" class="form-label">Jenis</label>
            <div class="input-group option-list">
              <div class="input-group-prepend btn-option">
                <button class="btn btn-primary" type="button" id="dataOption_type"><i class="fas fa-caret-down"></i></button>
              </div>
              <input id="type" name="type" type="text" class="form-control" value="<?= $data['smell_type'] ?? ''; ?>" readonly hidden>
              <input id="smell_name" name="smell_name" type="text" class="form-control" placeholder="Jenis Aroma" value="<?= $data['type_name'] ?? ''; ?>" required>
            </div>
          </div>
          <div class="col-sm-4 form-group">
            <label for="gender" class="form-label">Gender</label>
            <select name="gender" id="gender" class="form-control" required>
              <option disabled selected>--Pilih--</option>
              <option <?= $data['gender'] == "M" ? "selected" : "" ?> value="M">Pria</option>
              <option <?= $data['gender'] == "F" ? "selected" : "" ?> value="F">Wanita</option>
              <option <?= $data['gender'] == "U" ? "selected" : "" ?> value="U">Unisex</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="price" class="col-sm-2 col-form-label">Harga</label>
          <div class="col-sm-10">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Rp.</span>
              </div>
              <input id="price" name="price" type="text" data-type="currency" class="form-control" placeholder="Harga" value="<?= $data['price'] ?? ''; ?>" required>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="comm" class="col-sm-2 col-form-label">Komisi</label>
          <div class="col-sm-10">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Rp.</span>
              </div>
              <input id="comm" name="comm" type="text" data-type="currency" class="form-control" placeholder="Komisi" value="<?= $data['commission'] ?? ''; ?>" required>
            </div>
          </div>
        </div>
        <!-- <div class="form-group row">
          <label for="courier" class="col-sm-2 col-form-label">Kurir</label>
          <div class="col-sm-10">
            <input id="courier" name="courier" type="text" class="form-control" placeholder="Kurir" value="<?= $data['ship_code'] ?? ''; ?>" required>
          </div>
        </div> -->
        <div class="form-group row">
          <label for="description" class="col-sm-2 col-form-label">Deskripsi</label>
          <div class="col-sm-10">
            <textarea id="description" name="description" class="form-control"><?= $data['description'] ?? ''; ?></textarea>
          </div>
        </div>
      </div>
      <div class="mt-3 d-flex justify-content-between card-footer">
        <input type="text" name="add" hidden readonly>
        <a class="btn btn-secondary ml-2" href="package.php">Batal</a>
        <button id="btnSave" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
<!-- /.container-fluid -->

<!-- Modal Data-->
<div class="modal fade" id="fieldModal" tabindex="-1" aria-labelledby="fieldModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="fieldModalLabel">Generations</h5>
        <button type="button" class="close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-sm table-hover" id="fieldData">
          <thead>
            <tr>
              <th></th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          <div id="modalSpinner" class="spinner-border m-3" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>
<!-- Modal Data End-->

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

<script src="js/origin/package_form.js"></script>