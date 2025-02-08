<?php
include_once 'layout/header.php';
require 'functions/function_user.php';
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
        <button type="button" class="btn c-btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal1">Tambah Data</button>
        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
              </div>
              <div class="modal-body">
                <form action="functions/function_user.php" method="POST">
                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Pilih Kode User</label>
                    <div class="col-sm-2">
                      <select name="code_user" class="form-control form-control-sm" aria-label=".form-select-sm example">
                        <option value="1">F1201-1</option>
                        <option value="1">F1202-2</option>
                        <option value="1">F1203-3</option>
                        <option value="1">G1-01</option>
                        <option value="1">G2-02</option>
                        <option value="1">G3-03</option>
                        <option value="1">G4-04</option>
                        <option value="1">G5-05</option>
                        <option value="1">G6-06</option>
                        <option value="1">G7-07</option>
                        <option value="1">G8-08</option>
                        <option value="1">G9-09</option>
                        <option value="1">G10-10</option>
                      </select>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Nama</label>
                    <div class="col-sm-10">
                      <input type="text" name="name" class="form-control form-control-sm" id="inputEmail3" require>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Username</label>
                    <div class="col-sm-10">
                      <input type="text" name="username" class="form-control form-control-sm" id="inputEmail3" require>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Password</label>
                    <div class="col-sm-10">
                      <input type="password" name="password" class="form-control form-control-sm" id="inputEmail3" require>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label col-form-label-sm">Role</label>
                    <div class="col-sm-2">
                      <select name="role" class="form-control form-control-sm" aria-label=".form-select-sm example">
                        <option value="1">Founder</option>
                        <option value="2">Leader</option>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <input type="hidden" name="add">
                    <button class="btn btn-primary btn-sm">Simpan</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
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
            <?php $all = getData();
            $no = 1; ?>
            <?php foreach ($all as $data) { ?>
              <tr>
                <td style="text-align: center;"><?= $no++ ?></td>
                <td style="text-align: center;"><?= $data['code_user'] ?></td>
                <td style="text-align: center;"><?= $data['name'] ?></td>
                <td style="text-align: center;"><?= $data['username'] ?></td>
                <td style="text-align: center;"><a href="<?= 'user_form.php?id_user=' . $data['id_user']; ?>" class="btn btn-info btn-circle btn-sm"><i class="fas fa-pen"></i></a>
                  &nbsp;<a href="<?= 'functions/function_user.php?hapus=' . $data['id_user']; ?>" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></a></td>
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