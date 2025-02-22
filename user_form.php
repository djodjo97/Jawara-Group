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
        <center>Edit User</center>
      </h6>
    </div>
    <div class="card-body">
      <form action="functions/function_user.php" method="POST" enctype="multipart/form-data">
        <?php
        $id_user   = $_GET['id_user'];
        $get  = showData($id_user);
        ?>
        <?php foreach ($get as $data) { ?>
          <div class="row">
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">Kode User</label>
              <input name="code_user" type="text" class="form-control form-control-sm" value="<?= $data['code_user'] ?>">
              <input type="hidden" name="code_user" value="<?= $data['code_user'] ?>">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">Nama</label>
              <input name="name" type="text" class="form-control form-control-sm" value="<?= $data['name'] ?>">
              <input type="hidden" name="id_user" value="<?= $data['id_user'] ?>">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">Username</label>
              <input name="username" type="text" class="form-control form-control-sm" value="<?= $data['username'] ?>">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">Password</label>
              <input name="password" type="password" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">Role</label>
              <select name="role" class="form-control form-control-sm" aria-label=".form-select-sm example">
                <?php
                $rolesData = getRoles();
                foreach ($rolesData as $role):
                ?>
                  <option value="<?php echo $role['role_id']; ?>"><?php echo $role['rolename']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <br>
        <?php } ?>
        <input type="hidden" name="edit">
        <button class="btn btn-primary btn-sm">Simpan</button>
        <a class="btn btn-secondary btn-sm" href="user.php">Batal</a>
      </form>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

<?php
include_once 'layout/footer.php';
?>