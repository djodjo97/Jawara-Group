<?php
include_once 'layout/header.php';
require 'functions/function_category.php';
<<<<<<< HEAD
=======
$categories = getData();
$no = 1;
>>>>>>> mabro
?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- DataTales Example -->
  <div class="row">
    <div class="col-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
<<<<<<< HEAD
          <h6 style="font-size: 18px;" class="m-0 font-weight-bold text-dark">Kategori Produk</h6>
        </div>
        <div class="card-body">
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button" id="btnAdd" class="btn c-btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCategory">Tambah Kategori Produk</button>
=======
          <h6 style="font-size : 18px;" class="m-0 font-weight-bold text-dark">
            <div>Data Kategori</div>
          </h6>
        </div>
        <div class="card-body">
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button" id="btnAdd" class="btn c-btn-primary btn-sm">Tambah Data</button>
>>>>>>> mabro
          </div>
          <br />
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
<<<<<<< HEAD
                  <th style="text-align: center; width:20%">Kategori Produk</th>
                  <th style="text-align: center; width:15%">Kode Produk</th>
                  <th style="text-align: center;">Nama Paket</th>
=======
                  <th style="text-align: center;">Role</th>
                  <th style="text-align: center;">Deskripsi</th>
>>>>>>> mabro
                  <th style="text-align: center;">Aksi</th>
                </tr>
              </thead>
              <tbody>
<<<<<<< HEAD
                <?php $all = getAllData(); ?>
                <?php foreach ($all as $data) { ?>
                  <tr>
                    <td style="text-align: center;"><?= htmlspecialchars($data['category_product']) ?></td>
                    <td style="text-align: center;"><?= htmlspecialchars($data['category_code']) ?></td>
                    <td style="text-align: center;"><?= htmlspecialchars($data['category_name']) ?></td>
                    <td style="text-align: center;">
                      <button data-id="<?= $data['category_product']; ?>" class="btn btn-info btn-circle btn-sm edit-gen">
                        <i class="fas fa-pen"></i>
                      </button>
                      &nbsp;
                      <a href="functions/function_category.php?remove=<?= $data['category_product']; ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-circle btn-sm">
=======
                <?php
                foreach ($categories as $data) { ?>
                  <tr>
                    <td style="text-align: center;"><?= $data['category_code'] ?></td>
                    <td style="text-align: center;"><?= $data['category_name'] ?></td>
                    <td style="text-align: center;">
                      <button data-id="<?= $data['category_code']; ?>" class="btn btn-info btn-circle btn-sm edit-data">
                        <i class="fas fa-pen"></i>
                      </button>
                      &nbsp;
                      <a href="<?= 'functions/function_category.php?remove=' . $data['category_code']; ?>" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-circle btn-sm">
>>>>>>> mabro
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

<<<<<<< HEAD
  <div class="modal fade" id="modalCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
        </div>
        <div class="modal-body">
          <form action="functions/function_category.php" method="POST" id="formAction">
            <div class="mb-3">
              <label class="form-label">Kategori Produk</label>
              <input type="text" name="category_product" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Kode Produk</label>
              <input type="text" name="category_code" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Nama Paket</label>
              <textarea class="form-control" name="category_name" required></textarea>
            </div>
            <div class="modal-footer">
              <input type="hidden" id="inputAction" name="add">
              <button type="submit" class="btn btn-primary btn-sm" id="btnSave">Simpan</button>
              <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
=======


  <div class="modal fade" id="modalField" tabindex="-1" aria-labelledby="modalFieldLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalFieldLabel">Tambah Kategori</h5>
          <button type="button" class="close modal-close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="functions/function_category.php" method="POST" id="formAction">
            <div class="row mb-3">
              <label for="code" class="col-sm-3 col-form-label col-form-label-sm">Kode</label>
              <div class="col-sm-9">
                <input type="text" id="code" name="code" class="form-control form-control-sm" required>
              </div>
            </div>
            <div class="row mb-3">
              <label for="name" class="col-sm-3 col-form-label col-form-label-sm">Kategori</label>
              <div class="col-sm-9">
                <input type="text" id="name" name="name" class="form-control form-control-sm" required>
              </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" id="inputAction" name="add">
              <button type="button" class="btn btn-primary" id="btnSave">Simpan</button>
              <button type="button" class="btn btn-secondary modal-close">Close</button>
>>>>>>> mabro
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>
<<<<<<< HEAD

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
      fetch('endpoint/api_category.php?id=' + dataId)
        .then(response => response.json())
        .then(data => {
          document.querySelector("input[name='category_product']").value = data.category_product;
          document.querySelector("input[name='category_code']").value = data.category_code;
          document.querySelector("textarea[name='category_name']").value = data.category_name;
          
          let modal = new bootstrap.Modal(document.getElementById("modalCategory"));
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
=======
<!-- /.container-fluid -->

<script src="js/origin/category.js"></script>

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
>>>>>>> mabro
