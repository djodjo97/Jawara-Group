<?php
include_once 'layout/header.php';
require 'functions/function_mitra.php';
$id = $_GET['id'] ?? null;
$data = getData($id);
?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 id="title" class="m-0 font-weight-bold text-primary">Form Data</h6>
    </div>
    <div class="card-body">
      <form action="functions/function_mitra.php" method="POST" enctype="multipart/form-data" id="formAction">
        <div class="form-group row">
          <label for="genid" class="col-sm-2 col-form-label">Generasi</label>
          <div class="col-sm-10">
            <div class="input-group option-list">
              <div class="input-group-prepend btn-option">
                <button class="btn btn-primary" type="button" id="dataCode_gen"><i class="fas fa-caret-down"></i></button>
              </div>
              <input id="genId" name="gen" type="text" class="form-control" value="<?= $data['gen_id'] ?? ''; ?>" readonly hidden>
              <input id="genDesc" type="text" class="form-control small" placeholder="Generasi" value="<?= $data['gen_name'] ?? ''; ?>" aria-describedby="button-addon" readonly required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-sm-4">
            <label for="mitraId" class="form-label">ID</label>
            <input id="mitraId" name="idmitra" type="text" class="form-control" placeholder="ID Mitra" value="<?= $data['id_mitra'] ?? ''; ?>" required>
          </div>
          <div id="rowLeader" class="form-group col-sm-4">
            <label for="leader" class="form-label">Leader</label>
            <div class="input-group option-list">
              <div class="input-group-prepend btn-option">
                <button class="btn btn-primary" type="button" id="dataCode_leader"><i class="fas fa-caret-down"></i></button>
              </div>
              <input id="leaderId" name="leader" type="text" class="form-control" value="<?= $data['leader_id'] ?? ''; ?>" readonly hidden>
              <input id="leaderName" type="text" class="form-control small" placeholder="Leader" value="<?= $data['leader_name'] ?? ''; ?>" aria-describedby="button-addon" readonly required>
            </div>
          </div>
          <div class="form-group col-sm-4">
            <label for="regnum" class="form-label">No. Registrasi</label>
            <input id="regnum" name="regnum" type="text" class="form-control" placeholder="No. Registrasi" value="<?= $data['registration_number'] ?? ''; ?>" required readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="name" class="col-sm-2 col-form-label">Nama</label>
          <div class="col-sm-10">
            <input name="name" type="text" class="form-control" placeholder="Nama" value="<?= $data['name'] ?? ''; ?>" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="email" class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-10">
            <input name="email" type="email" class="form-control" placeholder="Email" value="<?= $data['email'] ?? ''; ?>" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="phone" class="col-sm-2 col-form-label">No. WhatsApp</label>
          <div class="col-sm-10">
            <input name="phone" type="number" class="form-control" placeholder="No. WhatsApp" value="<?= $data['phone'] ?? ''; ?>" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="address" class="col-sm-2 col-form-label">Alamat</label>
          <div class="col-sm-10">
            <textarea name="address" class="form-control"><?= $data['address'] ?? ''; ?></textarea>
          </div>
        </div>

        <div class="form-group row">
          <label for="idType" class="col-sm-2 col-form-label">No. Identitas</label>
          <div id="idCard" class="input-group col-sm-10">
            <select id="idType" name="id_type" class="form-control col-sm-2">
              <option selected value="ktp">KTP</option>
              <option value="sim">SIM</option>
            </select>
            <input id="ktp" name="ktp" type="number" class="form-control" placeholder="No. KTP" value="<?= $data['ktp'] ?? ''; ?>">
            <input name="sim" type="number" class="form-control" placeholder="No. SIM" value="<?= $data['sim'] ?? ''; ?>" hidden>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group option-list">
              <label for="up_i" class="form-label">Upper I</label>
              <div class="input-group">
                <div class="input-group-prepend btn-option">
                  <button class="btn btn-primary dataCode_up" type="button" id="dataCode_up_i"><i class="fas fa-caret-down"></i></button>
                </div>
                <input id="up_i" name="up_i" type="text" class="form-control" value="<?= $data['upper_i'] ?? ''; ?>" readonly hidden>
                <input id="up_i_name" type="text" class="form-control small" placeholder="Upper I" value="<?= $data['upper_i_name'] ?? ''; ?>" aria-describedby="button-addon" readonly required>
              </div>
            </div>
            <div class="form-group option-list">
              <label for="up_ii" class="form-label">Upper II</label>
              <div class="input-group">
                <div class="input-group-prepend btn-option">
                  <button class="btn btn-primary dataCode_up" type="button" id="dataCode_up_ii"><i class="fas fa-caret-down"></i></button>
                </div>
                <input id="up_ii" name="up_ii" type="text" class="form-control" value="<?= $data['upper_ii'] ?? ''; ?>" readonly hidden>
                <input id="up_ii_name" type="text" class="form-control small" placeholder="Upper II" value="<?= $data['upper_ii_name'] ?? ''; ?>" aria-describedby="button-addon" readonly required>
              </div>
            </div>

            <div class="form-group option-list">
              <label for="up_iii" class="form-label">Upper III</label>
              <div class="input-group">
                <div class="input-group-prepend btn-option">
                  <button class="btn btn-primary dataCode_up" type="button" id="dataCode_up_iii"><i class="fas fa-caret-down"></i></button>
                </div>
                <input id="up_iii" name="up_iii" type="text" class="form-control" value="<?= $data['upper_iii'] ?? ''; ?>" readonly hidden>
                <input id="up_iii_name" type="text" class="form-control small" placeholder="Upper III" value="<?= $data['upper_iii_name'] ?? ''; ?>" aria-describedby="button-addon" readonly required>
              </div>
            </div>

          </div>
          <div class="col-sm-6">
            <div class="mb-3">
              <label for="bonus_i" class="form-label">Bonus I</label>
              <input name="bonus_i" type="text" class="form-control" placeholder="Bonus I" value="<?= $data['bonus_i'] ?? ''; ?>">
            </div>
            <div class="mb-3">
              <label for="bonus_ii" class="form-label">Bonus II</label>
              <input name="bonus_ii" type="text" class="form-control" placeholder="Bonus II" value="<?= $data['bonus_ii'] ?? ''; ?>">
            </div>
            <div class="mb-3">
              <label for="bonus_iii" class="form-label">Bonus III</label>
              <input name="bonus_iii" type="text" class="form-control" placeholder="Bonus III" value="<?= $data['bonus_iii'] ?? ''; ?>">
            </div>
          </div>
        </div>
        <div class="mt-3 d-flex justify-content-end gap-1">
          <input type="hidden" id="inputAction" name="add">
          <button id="btnSave" class="btn btn-primary">Simpan</button>
          <a class="btn btn-secondary ml-2" href="mitra.php">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /.container-fluid -->


<!-- Modal Generation Data-->
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
<!-- Modal Generation Data End-->

<script src="js/origin/mitra_form.js"></script>

<?php
include_once 'layout/footer.php';
?>