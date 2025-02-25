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
      <h6 id="title" class="m-0 font-weight-bold text-primary">Data User</h6>
    </div>
    <form id="formAction" action="functions/function_user.php" method="POST" enctype="multipart/form-data">
      <div class="card-body">
        <div class="form-group row">
          <label for="code" class="col-sm-2 col-form-label">Kode Mitra</label>
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
            <input name="name" type="text" class="form-control" placeholder="Nama" required value="<?= $data['name'] ?? ''; ?>">
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
        <button type="button" id="chPwd" class="btn btn-primary" data-toggle="modal" data-target="#pwdModal" style="display: none;">Ubah Password</button>
      </div>
      <div class="mt-3 d-flex justify-content-between card-footer">
        <a class="btn btn-secondary ml-2" href="user.php">Kembali</a>
        <input type="hidden" name="add">
        <button type="submit" id="btnSave" class="btn btn-primary">Simpan</button>
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

<!-- Password Modal -->
<div class="modal fade" id="pwdModal" tabindex="-1" aria-labelledby="pwdModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pwdModalLabel">Ubah Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="functions/function_user.php" method="POST">
        <div class="modal-body">
          <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label">Password</label>
            <div class="col-sm-9">
              <input name="pwd" type="password" class="form-control" placeholder="Password Sekarang" value="<?= $_SESSION['message']['pwd']['val'] ?? ''; ?>" required>
              <div id="pwdInfo" class="small text-danger"></div>
            </div>
          </div>
          <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label">Password Baru</label>
            <div class="col-sm-9">
              <input id="newPwd" name="newPwd" type="password" class="form-control" placeholder="Password Baru" value="<?= $_SESSION['message']['newPwd']['val'] ?? ''; ?>" required>
              <div id="newPwdInfo" class="small text-danger"></div>
            </div>
          </div>
          <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label">Konfirmasi Password</label>
            <div class="col-sm-9">
              <input id="confPwd" name="confPwd" type="password" class="form-control" placeholder="Konfirmasi Password Baru" value="<?= $_SESSION['message']['confPwd']['val'] ?? ''; ?>" required>
              <div id="confPwdInfo" class="small text-danger"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input name="chPwd" type="text" hidden readonly>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary" id="btnChPwd">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Password Modal End-->

<script src="js/origin/user_form.js"></script>

<?php
include_once 'layout/footer.php';
// Menampilkan notifikasi jika ada pesan dari login.php
if (isset($_SESSION['message'])) {
  $msg = $_SESSION['message'];
  if (is_array($msg)) {
    $scr = "<script>$('#chPwd').trigger('click');";
    $scr .= ($msg['pwd']['text']) ? "$('#pwdInfo').text('" . $msg['pwd']['text'] . "');" : "";
    $scr .= ($msg['newPwd']['text']) ? "$('#newPwdInfo').text('" . $msg['newPwd']['text'] . "');" : "";
    $scr .= ($msg['confPwd']['text']) ? "$('#confPwdInfo').text('" . $msg['confPwd']['text'] . "');" : "";
    $scr .= "</script>";
    echo $scr;
  } else {
    echo "<script>Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '" . $msg . "',
            showConfirmButton: false,
            timer: 2500
        });</script>";
  }
}
unset($_SESSION['message']);
?>