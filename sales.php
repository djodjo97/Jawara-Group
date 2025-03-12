<?php
include_once 'layout/header.php';
require 'functions/function_sales.php';
$sales = getData();
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
        <center>Data Penjualan</center>
      </h6>
    </div>
    <div class="card-body">
      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <!-- <button type="button" id="btnAdd" class="btn c-btn-primary">Tambah Data Produk</button> -->
        <a type="button" class="btn c-btn-primary btn-sm" href="sales_form.php">Tambah Data</a>
      </div>
      <br>
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th style="text-align: center;">ID</th>
              <th style="text-align: center;">Tanggal</th>
              <th style="text-align: center;">Paket</th>
              <th style="text-align: center;">Qty</th>
              <th style="text-align: center;">Ekspedisi</th>
              <th style="text-align: center;">Ongkir</th>
              <th style="text-align: center;">Harga</th>
              <th style="text-align: center;">Total</th>
              <th style="text-align: center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($sales as $data) { ?>
              <tr>
                <td style="text-align: center;"><?= $data['docid'] ?></td>
                <td style="text-align: center;"><?= $data['docdate'] ?></td>
                <td style="text-align: center;"><?= $data['package_name'] ?></td>
                <td style="text-align: center;"><?= $data['qty'] ?></td>
                <td style="text-align: center;"><?= $data['ship_code'] ?></td>
                <td style="text-align: center;"><?= number_format($data['ship_amount'], 2, ',', '.'); ?></td>
                <td style="text-align: center;"><?= number_format($data['amount'], 2, ',', '.'); ?></td>
                <td style="text-align: center;"><?= number_format($data['total'], 2, ',', '.'); ?></td>
                <td style="text-align: center;"><a href="<?= 'sales_form.php?id=' . $data['docid']; ?>" class="btn btn-info btn-circle btn-sm"><i class="fas fa-pen"></i></a>
                  &nbsp;<a href="<?= 'functions/function_sales.php?remove=' . $data['docid']; ?>" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></a></td>
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