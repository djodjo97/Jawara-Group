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
        <div class="row">
          <div class="form-group col-sm-4">
            <label for="id" class="form-label">ID</label>
            <input name="idmitra" type="text" class="form-control" value="<?= $data['id_mitra'] ?? ''; ?>" required>
          </div>
          <div class="form-group col-sm-4">
            <label for="leader" class="form-label">Leader</label>
            <input name="leader" type="text" class="form-control" value="<?= $data['leader_id'] ?? ''; ?>" required>
          </div>
          <div class="form-group col-sm-4">
            <label for="regnum" class="form-label">No. Registrasi</label>
            <input name="regnum" type="text" class="form-control" value="<?= $data['registration_number'] ?? ''; ?>" required readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="name" class="col-sm-2 col-form-label">Nama</label>
          <div class="col-sm-10">
            <input name="name" type="text" class="form-control" value="<?= $data['name'] ?? ''; ?>" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="email" class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-10">
            <input name="email" type="email" class="form-control" value="<?= $data['email'] ?? ''; ?>" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="phone" class="col-sm-2 col-form-label">No. WhatsApp</label>
          <div class="col-sm-10">
            <input name="phone" type="number" class="form-control" value="<?= $data['phone'] ?? ''; ?>" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="address" class="col-sm-2 col-form-label">Address</label>
          <div class="col-sm-10">
            <textarea name="address" class="form-control"><?= $data['address'] ?? ''; ?></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label for="genid" class="col-sm-2 col-form-label">Generasi</label>
          <div class="col-sm-10">
            <div class="input-group">
              <div class="input-group-prepend">
                <button class="btn btn-primary" type="button"><i class="fas fa-caret-down"></i></button>
              </div>
              <input name="gen" type="text" class="form-control small" value="<?= $data['gen_id'] ?? ''; ?>" aria-describedby="button-addon" readonly>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="idType" class="col-sm-2 col-form-label">Jenis ID</label>
          <div id="idCard" class="input-group col-sm-10">
            <select id="idType" class="form-control col-sm-1">
              <option selected value="ktp">KTP</option>
              <option value="sim">SIM</option>
            </select>
            <input name="ktp" type="text" class="form-control" placeholder="No. KTP" value="<?= $data['ktp'] ?? ''; ?>">
            <input name="sim" type="text" class="form-control" placeholder="No. SIM" value="<?= $data['sim'] ?? ''; ?>" hidden>
          </div>
        </div>

        <!-- <div class="form-group row">
          <label for="idType" class="col-sm-2 col-form-label">Jenis ID</label>
          <div class="col-md-10 row">
            <div class="form-group col-4">
              <select id="idType" class="form-control">
                <option selected value="ktp">KTP</option>
                <option value="sim">SIM</option>
              </select>
            </div>
            <div id="idCard" class="form-group col-8">
              <input name="ktp" type="text" class="form-control" placeholder="No. KTP" value="<?= $data['ktp'] ?? ''; ?>">
              <input name="sim" type="text" class="form-control" placeholder="No. SIM" value="<?= $data['sim'] ?? ''; ?>" hidden>
            </div>
          </div>
        </div> -->

        <div class="row">
          <div class="col-sm-6">
            <div class="mb-3">
              <label for="up_i" class="form-label">Upper I</label>
              <input name="up_i" type="text" class="form-control" value="<?= $data['upper_i'] ?? ''; ?>">
            </div>
            <div class="mb-3">
              <label for="up_ii" class="form-label">Upper II</label>
              <input name="up_ii" type="text" class="form-control" value="<?= $data['upper_ii'] ?? ''; ?>">
            </div>
            <div class="mb-3">
              <label for="up_iii" class="form-label">Upper III</label>
              <input name="up_iii" type="text" class="form-control" value="<?= $data['upper_iii'] ?? ''; ?>">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="mb-3">
              <label for="bonus_i" class="form-label">Bonus I</label>
              <input name="bonus_i" type="text" class="form-control" value="<?= $data['bonus_i'] ?? ''; ?>">
            </div>
            <div class="mb-3">
              <label for="bonus_ii" class="form-label">Bonus II</label>
              <input name="bonus_ii" type="text" class="form-control" value="<?= $data['bonus_ii'] ?? ''; ?>">
            </div>
            <div class="mb-3">
              <label for="bonus_iii" class="form-label">Bonus III</label>
              <input name="bonus_iii" type="text" class="form-control" value="<?= $data['bonus_iii'] ?? ''; ?>">
            </div>
          </div>
        </div>
        <div>
          <input type="hidden" id="inputAction" name="add">
          <button id="btnSave" class="btn btn-primary">Simpan</button>
          <a class="btn btn-secondary" href="mitra.php">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

<script>
  document.addEventListener("DOMContentLoaded", function() {
    if (window.jQuery) {
      $('.form-control[name="idmitra"]').data('col', 'id_mitra');
      $('.form-control[name="regnum"]').data('col', 'registration_number');
      $('.form-control[name="name"]').data('col', 'name');
      $('.form-control[name="email"]').data('col', 'email');
      $('.form-control[name="phone"]').data('col', 'phone');
      $('.form-control[name="address"]').data('col', 'address');
      $('.form-control[name="gen"]').data('col', 'gen_id');
      $('.form-control[name="ktp"]').data('col', 'ktp');
      $('.form-control[name="sim"]').data('col', 'sim');
      $('.form-control[name="leader"]').data('col', 'leader_id');
      $('.form-control[name="up_i"]').data('col', 'upper_i');
      $('.form-control[name="up_ii"]').data('col', 'upper_ii');
      $('.form-control[name="up_iii"]').data('col', 'upper_iii');
      $('.form-control[name="bonus_i"]').data('col', 'bonus_i');
      $('.form-control[name="bonus_ii"]').data('col', 'bonus_ii');
      $('.form-control[name="bonus_iii"]').data('col', 'bonus_iii');

      const params = new URLSearchParams(window.location.search);
      if (params.get('id')) {
        $('#title').text('Data Mitra');
        $('#formAction').data('action', 'edit');
        $('#inputAction').prop('name', 'edit');
        $('#btnSave').text('Ubah');
        $('.form-control[name="idmitra"').prop('readonly', true);
      } else {
        $('#title').text('Pendaftaran Mitra');
        $('#formAction').data('action', 'add');
        $('#inputAction').prop('name', 'add');
        $('#btnSave').text('Simpan');
        $('.form-control[name="idmitra"').prop('readonly', false);
      }

      $('#idType').on('change', function() {
        const idType = $(this).val();
        if (idType == "ktp") {
          $('#idCard input[name="ktp"]').prop('hidden', false);
          $('#idCard input[name="sim"]').prop('hidden', true);
        } else if (idType == "sim") {
          $('#idCard input[name="ktp"]').prop('hidden', true);
          $('#idCard input[name="sim"]').prop('hidden', false);
        }
      });

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
            attr = $(this).data('col');
            data[attr] = $(this).val();
          });
          const dataId = $('.form-control[name="idmitra"]').val();
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