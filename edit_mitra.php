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
        <center>Edit Mitra</center>
      </h6>
    </div>
    <div class="card-body">
      <form action="functions/function_mitra.php" method="POST" enctype="multipart/form-data">
        <?php
        $id_mitra   = $_GET['id_mitra'];
        $get  = showData($id_mitra);
        ?>
        <?php foreach ($get as $data) { ?>
          <div class="row">
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">No KTP</label>
              <input name="registration_number" type="text" class="form-control form-control-sm" value="<?= $data['registration_number'] ?>">
              <input type="hidden" name="id_mitra" value="<?= $data['id_mitra'] ?>">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">ID Mitra</label>
              <input disabled="id_mitra" type="text" class="form-control form-control-sm" value="<?= $data['id_mitra'] ?>">
              <input type="hidden" name="id_mitra" value="<?= $data['id_mitra'] ?>">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">No KTP</label>
              <input name="ktp" type="text" class="form-control form-control-sm" value="<?= $data['ktp'] ?>">
              <input type="hidden" name="id_mitra" value="<?= $data['id_mitra'] ?>">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">No SIM</label>
              <input name="sim" type="text" class="form-control form-control-sm" value="<?= $data['ktp'] ?>">
              <input type="hidden" name="id_mitra" value="<?= $data['id_mitra'] ?>">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">Nama Mitra</label>
              <input name="name" type="text" class="form-control form-control-sm" value="<?= $data['name'] ?>">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">Email</label>
              <input name="email" type="email" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">No Telephone</label>
              <input name="phone" type="text" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">Alamat</label>
              <input name="address" type="text" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">ID Leader</label>
              <input name="leader_id" type="text" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">ID Upper</label>
              <input name="upper_i" type="text" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">ID Upper II</label>
              <input name="upper_ii" type="text" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">ID Upper III</label>
              <input name="upper_iii" type="text" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">Bonus</label>
              <input disabled="bonus_i" type="text" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">Bonus II</label>
              <input disabled name="bonus_ii" type="text" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
              <label for="formGroupExampleInput" class="form-label">Bonus III</label>
              <input disabled name="bonus_iii" type="text" class="form-control form-control-sm">
            </div>
          </div>
          <br>
        <?php } ?>
        <input type="hidden" name="edit">
        <button class="btn btn-primary btn-sm">Simpan</button>
        <a class="btn btn-secondary btn-sm" href="data_mitra.php">Batal</a>
      </form>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

<?php
include_once 'layout/footer.php';
?>