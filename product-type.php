<?php
include_once 'layout/header.php';
require 'functions/function_types.php';
$types = getData();
$no = 1;
?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- DataTales Example -->
  <div class="row">
    <div class="col-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 style="font-size : 18px;" class="m-0 font-weight-bold text-dark">
            <div>Data Jenis Produk</div>
          </h6>
        </div>
        <div class="card-body">
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button" id="btnAdd" class="btn c-btn-primary btn-sm">Tambah Data</button>
          </div>
          <br />
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th style="text-align: center;">ID</th>
                  <th style="text-align: center;">Jenis</th>
                  <th style="text-align: center;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($types as $data) { ?>
                  <tr>
                    <td style="text-align: center;"><?= $data['type_id'] ?></td>
                    <td style="text-align: center;"><?= $data['type_name'] ?></td>
                    <td style="text-align: center;">
                      <button data-id="<?= $data['type_id']; ?>" class="btn btn-info btn-circle btn-sm edit-data"><i class="fas fa-pen"></i></button>
                      &nbsp;
                      <a href="<?= 'functions/function_types.php?remove=' . $data['type_id']; ?>" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-circle btn-sm">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->


<div class="modal fade" id="modalField" tabindex="-1" aria-labelledby="modalFieldLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFieldLabel">Tambah Jenis Produk</h5>
        <button type="button" class="close modal-close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="functions/function_types.php" method="POST" id="formAction">
          <div id="inputIdData">
            <input type="text" id="idtypes" name="idtypes" class="form-control form-control-sm" hidden>
          </div>
          <div class="row mb-3" id="inputName">
            <label for="name" class="col-sm-3 col-form-label col-form-label-sm">Jenis</label>
            <div class="col-sm-9">
              <input type="text" id="name" name="name" class="form-control form-control-sm" required>
            </div>
          </div>
          <!-- <div class="row mb-3">
              <label for="name" class="col-sm-3 col-form-label col-form-label-sm">Kategori</label>
              <div class="col-sm-9">
                <input type="text" id="name" name="name" class="form-control form-control-sm" required>
              </div>
            </div> -->
          <div class="modal-footer">
            <input type="hidden" id="inputAction" name="add">
            <button type="button" class="btn btn-primary" id="btnSave">Simpan</button>
            <button type="button" class="btn btn-secondary modal-close">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="js/origin/types.js"></script>

<?php
include_once 'layout/footer.php';
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