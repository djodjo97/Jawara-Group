<?php
include_once 'layout/header.php';
require 'functions/function_mitra.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 style="font-size : 18px;" class="m-0 font-weight-bold text-dark">
        <center>Data Mitra</center>
      </h6>
    </div>
    <div class="card-body">
      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a type="button" class="btn c-btn-primary btn-sm" href="mitra_form.php">Tambah Data</a>
      </div>
      <br>
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTableMitra" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th style="text-align: center;">No Registrasi</th>
              <th style="text-align: center;">ID Mitra</th>
              <th style="text-align: center;">ID Generasi</th>
              <th style="text-align: center;">Nama Mitra</th>
              <th style="text-align: center;">Email</th>
              <th style="text-align: center;">No Telephone</th>
              <th style="text-align: center;">Alamat</th>
              <th style="text-align: center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $all = getData();
            $no = 1; ?>
            <?php foreach ($all as $data) { ?>
              <tr>
                <!-- <td style="text-align: center;"><?= $no++; ?></td> -->
                <td style="text-align: center;"><?= $data['registration_number'] ?></td>
                <td style="text-align: center;"><?= $data['id_mitra'] ?></td>
                <td style="text-align: center;"><?= $data['gen_id'] ?></td>
                <td style="text-align: center;"><?= $data['name'] ?></td>
                <td style="text-align: center;"><?= $data['email'] ?></td>
                <td style="text-align: center;"><?= $data['phone'] ?></td>
                <td style="text-align: center;"><?= $data['address'] ?></td>
                <td style="text-align: center;"><a href="<?= 'mitra_form.php?id=' . $data['id_mitra']; ?>" class="btn btn-info btn-circle btn-sm"><i class="fas fa-pen"></i></a>
                  &nbsp;<a href="<?= 'functions/function_mitra.php?hapus=' . $data['id_mitra']; ?>" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

<script>
  document.addEventListener("DOMContentLoaded", function() {
    if (window.jQuery) {
      $(document).ready(function() {
        $('#dataTableMitra').DataTable({
          "order": [
            [1, "asc"]
          ]
        });
      });
    } else {
      console.error("jQuery belum tersedia!");
    }

  });
</script>

<?php
include_once 'layout/footer.php';
?>