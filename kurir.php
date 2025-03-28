<?php
include_once 'layout/header.php';
require 'functions/function_kurir.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- DataTales Example -->
  <div class="row">
    <div class="col-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 style="font-size: 18px;" class="m-0 font-weight-bold text-dark">Kategori Ekspedisi</h6>
        </div>
        <div class="card-body">
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button" id="btnAdd" class="btn c-btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalShip">Tambah Data Ekspedisi</button>
          </div>
          <br />
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th style="text-align: center; width:20%">Kode Ekspedisi</th>
                  <th style="text-align: center;">Nama Ekspedisi</th>
                  <th style="text-align: center;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $all = getAllData(); ?>
                <?php foreach ($all as $data) { ?>
                  <tr>
                    <td style="text-align: center;"><?= htmlspecialchars($data['ship_code']) ?></td>
                    <td style="text-align: center;"><?= htmlspecialchars($data['ship_name']) ?></td>
                    <td style="text-align: center;">
                      <button data-id="<?= $data['ship_code']; ?>" class="btn btn-info btn-circle btn-sm edit-gen">
                        <i class="fas fa-pen"></i>
                      </button>
                      &nbsp;
                      <a href="functions/function_kurir.php?remove=<?= $data['ship_code']; ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-circle btn-sm">
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

  <div class="modal fade" id="modalShip" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
        </div>
        <div class="modal-body">
          <form action="functions/function_kurir.php" method="POST" id="formAction">
            <div class="mb-3">
              <label class="form-label">Kode Ekspedisi</label>
              <input type="text" name="ship_code" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Nama Ekspedisi</label>
              <textarea class="form-control" name="ship_name" required></textarea>
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

<script>
document.addEventListener("DOMContentLoaded", function() {
  document.getElementById("btnAdd").addEventListener("click", function() {
    document.querySelector("#formAction").reset();
    document.getElementById("btnSave").textContent = "Tambah";
    document.getElementById("inputAction").name = "add";
  });

  document.querySelectorAll(".edit-gen").forEach(button => {
    button.addEventListener("click", function() {
      let dataId = this.getAttribute("data-id");
      fetch('endpoint/api_kurir.php?id=' + dataId)
        .then(response => response.json())
        .then(data => {
          document.querySelector("input[name='ship_code']").value = data.ship_code;
          document.querySelector("textarea[name='ship_name']").value = data.ship_name;
          
          let modal = new bootstrap.Modal(document.getElementById("modalShip"));
          modal.show();
          document.getElementById("btnSave").textContent = "Edit";
          document.getElementById("inputAction").name = "edit";
        })
        .catch(error => console.error("Terjadi kesalahan:", error));
    });
  });
});
</script>

<?php
include_once 'layout/footer.php';
?>
