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

<script>
  document.addEventListener("DOMContentLoaded", function() {
    if (window.jQuery) {
      $('.form-control[name="idgen"]').data('col', 'id_generation');
      $('.form-control[name="seq"]').data('col', 'seq');
      $('.form-control[name="description"]').data('col', 'description');

      $('#btnSave').on('click', function(e) {
        e.preventDefault(); // Mencegah aksi default tombol

        if ($('#inputAction[name="add"]').length) {
          $('#formAction').submit();
        } else {
          const data = new Object();
          let attr;
          $('.row-change').each(function() {
            attr = $(this).data('col');
            data[attr] = $(this).val();
          });
          const dataId = $('.form-control[name="idgen"]').val();
          fetch('endpoint/api_generation.php?id=' + dataId, {
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

      $('#modalGeneration').on('change', '.form-control', function() {
        $(this).addClass('row-change');
      });

      $('#btnAdd').click(function() {
        $('.form-control').removeClass('row-change');
        $('#btnSave').text('Tambah');
        $('#inputAction').prop('name', 'add');

        $('#inputIdgen input[name="idgen"]').prop('disabled', false);
        $('#modalGeneration .form-control').each(function() {
          $(this).val('');
        });
      });

      //get mitra detail
      $(document).on('click', '.edit-gen', function(e) {
        $('.form-control').removeClass('row-change');
        const dataId = $(this).data('id');
        window.genId = dataId;

        fetch('endpoint/api_generation.php?id=' + dataId, {
            method: 'GET',
            headers: {
              'Content-Type': 'application/json'
            }
          })
          .then(response => {
            if (!response.ok) {
              throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.text();
          })
          .then(res => {
            var myModal = new bootstrap.Modal($('#modalGeneration'), true);
            myModal.show();
            $('#btnSave').text('Edit');
            $('#inputAction').prop('name', 'edit');

            res = JSON.parse(res);
            let data = res.data;
            const idgen = $('#inputIdgen input[name="idgen"]');
            idgen.prop('disabled', true);

            idgen.val(data['id_generation']);
            $('#inputSeq input[name="seq"]').val(data['seq']);
            $('#inputDesc textarea[name="description"]').val(data['description']);
          })
          .catch(error => {
            console.error("Terjadi kesalahan:", error);
            //console.error("Terjadi kesalahan! Silakan coba lagi.");
          });
      });

      $('.edit-gen').each(function() {
        $(this).click(function(e) {});
      });

    } else {
      console.error("jQuery belum tersedia!");
    }
  });
</script>

<?php
include_once 'layout/footer.php';
?>