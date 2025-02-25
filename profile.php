<?php
include_once 'layout/header.php';
require 'functions/function_profile.php';
$data  = getData();
?>

<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800">Profile</h1>
  <div class="row">
    <div class="col-xl-4">
      <div class="card mb-4 mb-xl-0">
        <div class="card-header font-weight-bold text-primary">Profile Picture</div>
        <div class="card-body text-center">
          <!-- Profile picture image-->
          <img class="img-account-profile rounded-circle mb-2" src="img/undraw_profile.svg" alt="" width="160" height="160">
          <!-- Profile picture help block-->
          <div class="font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
          <!-- Profile picture upload button-->
          <button class="btn btn-primary" type="button">Upload new image</button>
        </div>
      </div>
    </div>
    <div class="col-xl-8">
      <div class="card mb-4">
        <!-- <div class="card-header font-weight-bold text-primary">Account Details</div> -->
        <div class="card-body">
          <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">Profile</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="nav-security-tab" data-toggle="tab" data-target="#nav-security" type="button" role="tab" aria-controls="nav-security" aria-selected="false">Ubah Password</button>
            </li>
          </ul>


          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
              <form method="POST" action="functions/function_profile.php">
                <!-- Form Group (username)-->
                <div class="form-group">
                  <label class="form-label mb-1" for="uname">Username</label>
                  <input name="uname" class="form-control" id="uname" type="text" placeholder="Masukkan Username" value="<?php echo $data['username'] ?? ''; ?>">
                </div>
                <div class="form-group">
                  <label class="form-label mb-1" for="name">Nama</label>
                  <input name="name" class="form-control" type="text" placeholder="Masukkan Nama" value="<?php echo $data['name'] ?? ''; ?>">
                </div>
                <div class="row gx-3 mb-3">
                  <!-- Form Group (first name)-->
                  <div class="col-md-6">
                    <label class="mb-1" for="code">Kode Mitra</label>
                    <input id="code" class="form-control" type="text" value="<?php echo $data['code_user'] ?? ''; ?>" readonly>
                  </div>
                  <!-- Form Group (last name)-->
                  <div class="col-md-6">
                    <label class="mb-1" for="role">Role</label>
                    <input id="role_name" class="form-control" type="text" value="<?php echo $data['rolename'] ?? ''; ?>" readonly>
                  </div>
                </div>

                <!-- Save changes button-->
                <input name="update" readonly hidden>
                <button class="btn btn-primary mt-2" type="submit">Save changes</button>
              </form>
            </div>



            <div class="tab-pane fade" id="nav-security" role="tabpanel" aria-labelledby="nav-security-tab">

              <form id="formChangePwd" action="functions/function_profile.php" method="POST">
                <!-- Form Group (current password)-->
                <div class="mb-3">
                  <label class="mb-1" for="pwd">Password</label>
                  <input name="pwd" id="pwd" class="form-control" type="password" placeholder="Password saat ini" value="<?= $_SESSION['message']['pwd']['val'] ?? ''; ?>" required>
                  <div id="pwdInfo" class="small text-danger"></div>
                </div>
                <!-- Form Group (new password)-->
                <div class="mb-3">
                  <label class="mb-1" for="newPwd">Password Baru</label>
                  <input name="newPwd" id="newPwd" class="form-control" type="password" placeholder="Password baru" value="<?= $_SESSION['message']['newPwd']['val'] ?? ''; ?>" required>
                  <div id="newPwdInfo" class="small text-danger"></div>
                </div>
                <!-- Form Group (confirm password)-->
                <div class="mb-3">
                  <label class="mb-1" for="confPwd">Konfirmasi Password</label>
                  <input name="confPwd" id="confPwd" class="form-control" type="password" placeholder="Ulangi password baru">
                  <div id="confPwdInfo" class="small text-danger"></div>
                </div>
                <input name="chPwd" type="text" hidden readonly>
                <button id="btnChangePwd" class="btn btn-primary" type="button">Save</button>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="js/origin/profile_form.js"></script>

<?php
include_once 'layout/footer.php';
// Menampilkan notifikasi jika ada pesan dari login.php
if (isset($_SESSION['message'])) {
  $msg = $_SESSION['message'];
  if (array_key_exists('pwd', $msg)) {
    $scr = "<script>$('#nav-security-tab').trigger('click');";
    $scr .= ($msg['pwd']['text']) ? "$('#pwdInfo').text('" . $msg['pwd']['text'] . "');" : "";
    $scr .= ($msg['newPwd']['text']) ? "$('#newPwdInfo').text('" . $msg['newPwd']['text'] . "');" : "";
    $scr .= ($msg['confPwd']['text']) ? "$('#confPwdInfo').text('" . $msg['confPwd']['text'] . "');" : "";
    $scr .= "</script>";
    echo $scr;
  } else {
    echo "<script>Swal.fire({
            icon: '" . $msg['icon'] . "',
            title: '" . $msg['title'] . "',
            text: `" . $msg['text'] . "`,
            showConfirmButton: false,
            timer: 2500
        });</script>";
  }
  unset($_SESSION['message']);
}
?>