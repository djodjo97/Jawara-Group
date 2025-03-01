<?php
include_once 'layout/header.php';
require 'functions/function_generation.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- DataTales Example -->
  <div class="row">
    <div class="col-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 style="font-size : 18px;" class="m-0 font-weight-bold text-dark">
            <div>Data Generasi</div>
          </h6>
        </div>
        <div class="card-body">
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button" id="btnAdd" class="btn c-btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalGeneration">Tambah Data</button>
          </div>
          <br />
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th style="text-align: center; width:20%" col>ID Group</th>
                  <th style="text-align: center; width:15%">No. Urut</th>
                  <th style="text-align: center;">Deskripsi</th>
                  <th style="text-align: center;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $all = getAllData();
                $no = 1; ?>
                <?php
                foreach ($all as $data) { ?>
                  <tr>
                    <!-- <td style="text-align: center;"><?= $no++; ?></td> -->
                    <td style="text-align: center;"><?= $data['id_generation'] ?></td>
                    <td style="text-align: center;"><?= $data['seq'] ?></td>
                    <td style="text-align: center;"><?= $data['description'] ?></td>
                    <td style="text-align: center;">
                      <button data-id="<?= $data['id_generation']; ?>" class="btn btn-info btn-circle btn-sm edit-gen">
                        <i class="fas fa-pen"></i>
                      </button>
                      &nbsp;
                      <a href="<?= 'functions/function_generation.php?remove=' . $data['id_generation']; ?>" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-circle btn-sm">
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



  <div class="modal fade" id="modalGeneration" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Group</h5>
        </div>
        <div class="modal-body">
          <form action="functions/function_generation.php" method="POST" id="formAction">
            <div class="row mb-3" id="inputIdgen">
              <label class="col-sm-3 col-form-label col-form-label-sm">ID Generasi</label>
              <div class="col-sm-9">
                <input type="text" name="idgen" class="form-control form-control-sm" required>
              </div>
            </div>
            <div class="row mb-3" id="inputSeq">
              <label class="col-sm-3 col-form-label col-form-label-sm">No. Urut</label>
              <div class="col-sm-9">
                <input type="text" name="seq" class="form-control form-control-sm" required>
              </div>
            </div>
            <div class="row mb-3" id="inputDesc">
              <label class="col-sm-3 col-form-label col-form-label-sm">Description</label>
              <div class="col-sm-9">
                <textarea class="form-control" aria-label="With textarea" name="description" required></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" id="inputAction" name="add">
              <button type="submit" class="btn btn-primary btn-sm" id="btnSave">Simpan</button>
              <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<script src="js/origin/generation.js"></script>

<?php
include_once 'layout/footer.php';
?>