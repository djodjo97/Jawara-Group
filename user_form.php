<?php
include_once 'layout/header.php';
require 'functions/function_user.php';
$data  = getData($_GET['id'] ?? NULL);
$msg  = isset($_SESSION['message']) ? $_SESSION['message'] : NULL;
$newPwd = (isset($msg) && array_key_exists('password', $msg['data'])) ? $msg['data']['password'] : NULL;
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
              <input id="code" name="code" type="text" class="form-control" value="<?php echo $data['code_user'] ?? ''; ?>" readonly hidden>
              <input id="mitraName" type="text" class="form-control" placeholder="Kode" value="<?php echo $data['mitra_name'] ?? ''; ?>" aria-describedby="button-addon" readonly required>
              <input type="hidden" name="idUser" value="<?php echo $data['id_user'] ?? ''; ?>">
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="name" class="col-sm-2 col-form-label">Nama</label>
          <div class="col-sm-10">
            <input name="name" type="text" class="form-control" placeholder="Nama" required value="<?php echo $data['name'] ?? ''; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="uname" class="col-sm-2 col-form-label">Username</label>
          <div class="col-sm-10">
            <input id="uname" name="uname" type="text" class="form-control" placeholder="Username" value="<?php echo $data['username'] ?? ''; ?>">
            <div id="unameInfo" class="small text-danger"></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="role" class="col-sm-2 col-form-label">Role</label>
          <div class="col-sm-10">
            <div class="input-group option-list">
              <div class="input-group-prepend btn-option">
                <button class="btn btn-primary" type="button" id="dataOption_role"><i class="fas fa-caret-down"></i></button>
              </div>
              <input id="role" name="role" type="text" class="form-control" value="<?php echo $data['role_id'] ?? ''; ?>" readonly hidden>
              <input id="roleName" type="text" class="form-control" placeholder="Role Name" value="<?php echo $data['rolename'] ?? ''; ?>" aria-describedby="button-addon" readonly required>
            </div>
          </div>
        </div>

        <div class="form-group <?php echo (!$newPwd) ? 'd-none' : ''; ?>">
          <div class="row">
            <label for="newPwd" class="col-sm-2 col-form-label">New Password</label>
            <div class="col-sm-5">
              <div class="input-group">
                <input id="newPwd" name="newPwd" type="text" class="form-control" value="<?php echo ($newPwd) ? $newPwd : ''; ?>">
                <div class="input-group-append">
                  <button data-toggle="tooltip" data-placement="top" title="Copy Password" class="btn border border-secondary" type="button" id="btnCopyPwd">
                    <i class="fa fa-copy"></i>
                  </button>
                </div>
              </div>

              <div id="newPwdInfo" class="small text-info px-1 d-block">Copy this password!</div>
            </div>

          </div>
        </div>

        <button type="button" id="btnChPwd" class="btn btn-primary" style="display: none;">Reset Password</button>
      </div>
      <div class="mt-3 d-flex justify-content-between card-footer">
        <a class="btn btn-secondary ml-2" href="user.php">Kembali</a>
        <input type="hidden" name="add">
        <button type="button" id="btnSave" class="btn btn-primary">Simpan</button>
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
              <th>ID</th>
              <th>Role</th>
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

<!-- Password Modal -->
<div class="modal fade" id="pwdModal" tabindex="-1" aria-labelledby="pwdModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pwdModalLabel">Reset Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="functions/function_user.php" method="POST">
        <div class="modal-body">
          <div class="form-group px-3">
            <div class="input-group mb-1">
              <input id="resetPwd" name="pwd" type="text" class="form-control" placeholder="Password" value="<?php echo $_SESSION['message']['pwd']['val'] ?? ''; ?>" required>
              <div class="input-group-append">
                <button type="button" class="btn border border-secondary" data-toggle="tooltip" data-placement="top" title="Copy Password" id="btnCopyReset">
                  <i class="fa fa-copy"></i>
                </button>
              </div>
            </div>
            <div id="pwdInfo" class="small text-info px-1">Copy this password!</div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Password Modal End-->

<!-- Loading Modal-->
<!-- <div class="modal fade" id="loadingModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered justify-content-center align-items-center">
    <div class="spinner-grow text-light" role="status">
      <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-light" role="status">
      <span class="sr-only">Loading...</span>
    </div>
    <div class="spinner-grow text-light" role="status">
      <span class="sr-only">Loading...</span>
    </div>

  </div>
</div> -->
<!-- Loading Modal End-->

<?php
include_once 'layout/footer.php';
// Menampilkan notifikasi jika ada pesan dari login.php
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
<script src="js/origin/user_form.js"></script>