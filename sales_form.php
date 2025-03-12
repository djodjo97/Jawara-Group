<?php
include_once 'layout/header.php';
require 'functions/function_sales.php';
$docid = $_GET['id'] ?? '';
$data  = getData($docid);
?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 id="title" class="m-0 font-weight-bold text-primary">Data Penjualan</h6>
    </div>
    <form id="formAction" action="functions/function_sales.php" method="POST">
      <div class="card-body">
        <div class="form-group row">
          <label for="code" class="col-sm-2 col-form-label">ID</label>
          <div class="col-sm-10">
            <input id="code" name="code" type="text" class="form-control" placeholder="Document ID" value="<?= $data['docid'] ?? ''; ?>" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="txndate" class="col-sm-2 col-form-label">Tanggal</label>
          <div class="col-sm-10">

            <div class="input-group date" id="datetimepicker" data-target-input="nearest">
              <input id="txndate" name="txndate" type="text" class="form-control datetimepicker-input" placeholder="Tanggal" value="<?= $data['docdate'] ?? ''; ?>" required data-target="#datetimepicker">
              <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
              </div>
            </div>
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
              <input id="category" name="category" type="text" class="form-control opt-value" placeholder="Kategori" value="<?= $data['category_name'] ?? ''; ?>" required>
            </div>
          </div>
          <div class="col-sm-4 form-group">
            <label for="package" class="form-label">Paket</label>
            <div class="input-group option-list">
              <div class="input-group-prepend btn-option">
                <button class="btn btn-primary" type="button" id="dataOption_package"><i class="fas fa-caret-down"></i></button>
              </div>
              <input id="package" name="package" type="text" class="form-control" value="<?= $data['package_code'] ?? ''; ?>" readonly hidden>
              <input id="packageName" name="package_name" type="text" class="form-control opt-value" placeholder="Paket" value="<?= $data['package_name'] ?? ''; ?>" required>
            </div>
          </div>
          <div class="col-sm-4 form-group">
            <label for="qty" class="form-label">Qty</label>
            <input id="qty" name="qty" type="text" class="form-control" placeholder="Quantity" value="<?= $data['qty'] ?? ''; ?>" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="packageDesc" class="col-sm-2 col-form-label">Deskripsi Paket</label>
          <div class="col-sm-10">
            <textarea id="packageDesc" name="package_desc" class="form-control" disabled><?= $data['package_desc'] ?? ''; ?></textarea>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 form-group">
            <label for="shipName" class="form-label">Jasa Ekspedisi</label>
            <div class="input-group option-list">
              <div class="input-group-prepend btn-option">
                <button class="btn btn-primary" type="button" id="dataOption_courier"><i class="fas fa-caret-down"></i></button>
              </div>
              <input id="ship" name="ship" type="text" class="form-control" value="<?= $data['ship_code'] ?? ''; ?>" readonly hidden>
              <input id="shipName" name="ship_name" type="text" class="form-control opt-value" placeholder="Pengiriman" value="<?= $data['ship_name'] ?? ''; ?>" required>
            </div>
          </div>
          <div class="col-sm-6 form-group">
            <label for="shipNum" class="form-label">Kode Pengiriman</label>
            <input id="shipNum" name="ship_num" type="text" class="form-control" placeholder="Kode Pengiriman" value="<?= $data['tracking_number'] ?? ''; ?>" required>
          </div>
        </div>

        <div class="form-group row">
          <label for="ongkir" class="col-sm-2 col-form-label">Ongkos Kirim</label>
          <div class="col-sm-10">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Rp.</span>
              </div>
              <input id="ongkir" name="ongkir" type="text" data-type="currency" class="form-control" placeholder="Ongkos Kirim" value="<?= $data['ship_amount'] ?? ''; ?>" required>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="price" class="col-sm-2 col-form-label">Harga Paket</label>
          <div class="col-sm-10">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Rp.</span>
              </div>
              <input id="price" name="price" type="text" data-type="currency" class="form-control" placeholder="Harga Paket" value="<?= $data['amount'] ?? ''; ?>" required>
            </div>
          </div>
        </div>
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

<script src="js/origin/sales_form.js"></script>