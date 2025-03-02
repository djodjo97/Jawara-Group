<?php
include_once 'layout/header.php';
require 'functions/function_package.php';
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
        <center>DATA PRODUK</center>
      </h6>
    </div>
    <div class="card-body">
      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="button" id="btnAdd" class="btn c-btn-primary">Tambah Data Produk</button>
      </div>
      <br>
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th style="text-align: center;">Kode Paket</th>
              <th style="text-align: center;">Nama Paket</th>
              <th style="text-align: center;">Kategori Paket</th>
              <th style="text-align: center;">Jenis</th>
              <th style="text-align: center;">Jenis Kelamin</th>
              <th style="text-align: center;">Harga</th>
              <th style="text-align: center;">Komisi Seler</th>
              <th style="text-align: center;">Kurir Pengiriman</th>
              <th style="text-align: center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $all = getData();
            $no = 1; ?>
            <?php foreach ($all as $data) { ?>
              <tr>
                <td style="text-align: center;"><?= $no++; ?></td>
                <td style="text-align: center;"><?= $data['package_name'] ?></td>
                <td style="text-align: center;"><?= $data['category_code'] ?></td>
                <td style="text-align: center;"><?= $data['smell_type'] ?></td>
                <td style="text-align: center;"><?= $data['gender'] ?></td>
                <td style="text-align: center;"><?= $data['price'] ?></td>
                <td style="text-align: center;"><?= $data['commission'] ?></td>
                <td style="text-align: center;"><?= $data['ship_code'] ?></td>
                <td style="text-align: center;"><a href="<?= 'package_form.php?package_code=' . $data['package_code']; ?>" class="btn btn-info btn-circle btn-sm"><i class="fas fa-pen"></i></a>
                  &nbsp;<a href="<?= 'functions/function_package.php?hapus=' . $data['package_code']; ?>" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->


<!-- Modal Product -->
<div class="modal fade" id="modalProduct" tabindex="-1" aria-labelledby="modalProductLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalProductLabel">Tambah Data Produk</h5>
        <button type="button" class="close modal-close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="functions/function_package.php" method="POST">
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Kode Paket</label>
            <div class="col-sm-10">
              <input type="text" name="package_code" class="form-control form-control-sm" id="inputEmail3" require>
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Nama Paket</label>
            <div class="col-sm-10">
              <input type="text" name="package_name" class="form-control form-control-sm" id="inputEmail3" require>
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Kategori Produk</label>
            <div class="col-sm-10">
              <input type="text" name="category_code" class="form-control form-control-sm" id="inputEmail3" require>
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
<!-- /.Modal Product -->

<script>
  $(document).ready(function() {
    $('#btnAdd').click(function() {
      $('#modalProduct').modal('show');
    });
  });
</script>

<?php
include_once 'layout/footer.php';
?>