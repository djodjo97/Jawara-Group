<?php
include_once 'layout/header.php';
require 'functions/function_user.php';
$data  = getData($_GET['id'] ?? NULL);
?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 id="title" class="m-0 font-weight-bold text-primary">Data USer</h6>
    </div>
    <form id="formAction" action="functions/function_user.php" method="POST" enctype="multipart/form-data">
      <div class="card-body">
        <div class="form-group row">
          <label for="code" class="col-sm-2 col-form-label">Kode User</label>
          <div class="col-sm-10">
            <div class="input-group option-list">
              <div class="input-group-prepend btn-option">
                <button class="btn btn-primary" type="button" id="dataOption_code"><i class="fas fa-caret-down"></i></button>
              </div>
              <input id="code" name="code" type="text" class="form-control" value="<?= $data['code_user'] ?? ''; ?>" readonly hidden>
              <input id="mitraName" type="text" class="form-control" placeholder="Kode" value="<?= $data['mitra_name'] ?? ''; ?>" aria-describedby="button-addon" readonly required>
              <input type="hidden" name="idUser" value="<?= $data['id_user'] ?? ''; ?>">
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="name" class="col-sm-2 col-form-label">Nama</label>
          <div class="col-sm-10">
            <input name="name" type="text" class="form-control" placeholder="Nama" value="<?= $data['name'] ?? ''; ?>" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="uname" class="col-sm-2 col-form-label">Username</label>
          <div class="col-sm-10">
            <input id="uname" name="uname" type="text" class="form-control" placeholder="Username" value="<?= $data['username'] ?? ''; ?>">
          </div>
        </div>
        <div class="form-group row">
          <!-- <div class="col-md-6 form-group">
            <label for="formGroupExampleInput" class="form-label">Password</label>
            <input name="password" type="password" class="form-control">
          </div> -->
          <label for="role" class="col-sm-2 col-form-label">Role</label>
          <div class="col-sm-10">
            <div class="input-group option-list">
              <div class="input-group-prepend btn-option">
                <button class="btn btn-primary" type="button" id="dataOption_role"><i class="fas fa-caret-down"></i></button>
              </div>
              <input id="role" name="role" type="text" class="form-control" value="<?= $data['role'] ?? ''; ?>" readonly hidden>
              <input id="roleName" type="text" class="form-control" placeholder="Role Name" value="<?= $data['role_name'] ?? ''; ?>" aria-describedby="button-addon" readonly required>
            </div>
          </div>
        </div>
      </div>
      <div class="mt-3 d-flex justify-content-between card-footer">
        <!-- <input type="hidden" name="add"> -->
        <a class="btn btn-secondary ml-2" href="user.php">Kembali</a>
        <button id="btnSave" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
<!-- /.container-fluid -->

<!-- Modal Data-->
<div class="modal fade" id="fieldModal" tabindex="-1" aria-labelledby="fieldModalLabel" aria-hidden="true">
  <div class="modal-dialog">
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

<script src="js/origin/user_form.js"></script>

<?php
include_once 'layout/footer.php';
?>