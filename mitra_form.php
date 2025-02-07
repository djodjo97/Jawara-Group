<?php
include_once 'layout/header.php';
require 'functions/function_mitra.php';
$id = $_GET['id'] ?? null;
$data = getData($id);
?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Mitra</h1>
  </div>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Mitra Detail</h6>
    </div>
    <div class="card-body">
      <form action="functions/function_mitra.php" method="POST" enctype="multipart/form-data" id="formAction">
        <div class="form-group row">
          <label for="id" class="col-sm-2 col-form-label">ID</label>
          <div class="col-sm-10">
            <input id="id" name="id" type="text" class="form-control" value="<?= $data['id_mitra'] ?? ''; ?>" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="regnum" class="col-sm-2 col-form-label">No. Registrasi</label>
          <div class="col-sm-10">
            <input id="regnum" name="regnum" type="text" class="form-control" value="<?= $data['registration_number'] ?? ''; ?>" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="name" class="col-sm-2 col-form-label">Nama</label>
          <div class="col-sm-10">
            <input id="name" name="name" type="text" class="form-control" value="<?= $data['name'] ?? ''; ?>" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="email" class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-10">
            <input id="email" name="email" type="email" class="form-control" value="<?= $data['email'] ?? ''; ?>" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="phone" class="col-sm-2 col-form-label">No. Telp</label>
          <div class="col-sm-10">
            <input id="phone" name="phone" type="number" class="form-control" value="<?= $data['phone'] ?? ''; ?>" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="address" class="col-sm-2 col-form-label">Address</label>
          <div class="col-sm-10">
            <textarea id="address" name="address" class="form-control"><?= $data['address'] ?? ''; ?></textarea>
          </div>
        </div>

        <div class="form-group row">
          <label for="genid" class="col-sm-2 col-form-label">Generasi</label>
          <div class="col-sm-10">
            <input id="generation" name="gen" type="text" class="form-control" value="<?= $data['gen_id'] ?? ''; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="ktp" class="col-sm-2 col-form-label">No. KTP</label>
          <div class="col-sm-10">
            <input id="ktp" name="ktp" type="text" class="form-control" value="<?= $data['ktp'] ?? ''; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="sim" class="col-sm-2 col-form-label">No. SIM</label>
          <div class="col-sm-10">
            <input id="sim" name="sim" type="text" class="form-control" value="<?= $data['sim'] ?? ''; ?>">
          </div>
        </div>

        <div class="mb-3 row">
          <label for="leader" class="col-sm-2 col-form-label">Leader</label>
          <div class="col-sm-10">
            <input id="leader" name="leader" type="text" class="form-control" value="<?= $data['leader_id'] ?? ''; ?>">
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="mb-3">
              <label for="up_i" class="form-label">Upper I</label>
              <input id="up_i" name="up_i" type="text" class="form-control" value="<?= $data['upper_i'] ?? ''; ?>">
            </div>
            <div class="mb-3">
              <label for="up_ii" class="form-label">Upper II</label>
              <input id="up_ii" name="up_ii" type="text" class="form-control" value="<?= $data['upper_ii'] ?? ''; ?>">
            </div>
            <div class="mb-3">
              <label for="up_iii" class="form-label">Upper III</label>
              <input id="up_iii" name="up_iii" type="text" class="form-control" value="<?= $data['upper_iii'] ?? ''; ?>">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="mb-3">
              <label for="bonus_i" class="form-label">Bonus I</label>
              <input id="bonus_i" name="bonus_i" type="text" class="form-control" value="<?= $data['bonus_i'] ?? ''; ?>">
            </div>
            <div class="mb-3">
              <label for="bonus_ii" class="form-label">Bonus II</label>
              <input id="bonus_ii" name="bonus_ii" type="text" class="form-control" value="<?= $data['bonus_ii'] ?? ''; ?>">
            </div>
            <div class="mb-3">
              <label for="bonus_iii" class="form-label">Bonus III</label>
              <input id="bonus_iii" name="bonus_iii" type="text" class="form-control" value="<?= $data['bonus_iii'] ?? ''; ?>">
            </div>
          </div>
        </div>
        <div>
          <input type="hidden" id="inputAction" name="add">
          <button id="btnSave" class="btn btn-primary">Simpan</button>
          <a class="btn btn-secondary" href="data_mitra.php">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

<script>
  document.addEventListener("DOMContentLoaded", function() {
    if (window.jQuery) {
      const params = new URLSearchParams(window.location.search);
      if (params.get('id')) {
        $('#formAction').data('action', 'edit');
        $('#inputAction').prop('name', 'edit');
        $('#btnSave').text('Ubah');
        $('#id').prop('readonly', true);
      } else {
        $('#formAction').data('action', 'add');
        $('#inputAction').prop('name', 'add');
        $('#btnSave').text('Simpan');
        $('#id').prop('readonly', false);
      }

      $('#formAction').on('change', '.form-control', function() {
        $(this).addClass('row-change');
      });

      $('#btnSave').on('click', function(e) {
        e.preventDefault(); // Mencegah aksi default tombol
        if (!$('#formAction').get(0).checkValidity()) {
          $('#formAction').get(0).reportValidity()
          return false;
        }

        if ($('#formAction').data('action') == "add") {
          $('#formAction').submit();
        } else {
          const data = new Object();
          let attr;
          $('.row-change').each(function() {
            attr = $(this).attr('name');
            data[attr] = $(this).val();
          });
          const dataId = $('.form-control[name="id"]').val();
          fetch('endpoint/api_mitra.php?id=' + dataId, {
              method: 'PATCH',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify(data)
            })
            .then(response => {
              if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
              }
              return response.text();
            })
            .then(res => {
              console.log(res);
              // $.toast({
              //   heading: "Proses Berhasil!",
              //   text: "Data Berhasil Diupdate",
              //   position: "top-right",
              //   hideAfter: 3500,
              //   textAlign: "center",
              //   icon: "success"
              // });
              Swal.fire({
                icon: "success",
                title: "The data has been saved successfully!",
                showConfirmButton: false,
                timer: 1500
              }).then(() => {
                window.location.reload();
              });
            })
            .catch(error => {
              console.error("Terjadi kesalahan:", error);
            });
        }
      });
    } else {
      console.error("jQuery belum tersedia!");
    }
  });
</script>

<?php
include_once 'layout/footer.php';
?>