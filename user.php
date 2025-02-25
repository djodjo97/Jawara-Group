<?php
include_once 'layout/header.php';
require 'functions/function_user.php';
$dataUser = getData();
?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 style="font-size : 18px;" class="m-0 font-weight-bold text-dark">
        <center>Data User</center>
      </h6>
    </div>
    <div class="card-body">
      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a type="button" class="btn c-btn-primary btn-sm" href="user_form.php">Tambah Data</a>
      </div>
      <br>
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th style="text-align: center;">No</th>
              <th style="text-align: center;">Kode User</th>
              <th style="text-align: center;">Nama</th>
              <th style="text-align: center;">Username</th>
              <th style="text-align: center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; ?>
            <?php foreach ($dataUser as $data) { ?>
              <tr>
                <td style="text-align: center;"><?= $no++ ?></td>
                <td style="text-align: center;"><?= $data['code_user'] ?></td>
                <td style="text-align: center;"><?= $data['name'] ?></td>
                <td style="text-align: center;"><?= $data['username'] ?></td>
                <td style="text-align: center;"><a href="<?= 'user_form.php?id=' . $data['code_user']; ?>" class="btn btn-info btn-circle btn-sm"><i class="fas fa-pen"></i></a>
                  &nbsp;<a href="<?= 'functions/function_user.php?hapus=' . $data['code_user']; ?>" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></a></td>
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
?>