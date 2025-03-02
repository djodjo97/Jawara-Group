$(document).ready(function () {
  // menangani Blocked aria-hidden
  // document.addEventListener('hide.bs.modal', function(event) {
  //   if (document.activeElement) {
  //     document.activeElement.blur();
  //   }
  // });
  $('.form-control[name="idrole"]').data('col', 'role_id');
  $('.form-control[name="name"]').data('col', 'rolename');
  $('.form-control[name="description"]').data('col', 'description');

  $('#btnSave').on('click', function (e) {
    e.preventDefault(); // Mencegah aksi default tombol

    if ($('#inputAction[name="add"]').length) {
      $('#formAction').submit();
    } else {
      const data = new Object();
      let attr;
      $('.row-change').each(function () {
        attr = $(this).data('col');
        data[attr] = $(this).val();
      });
      const dataId = $('.form-control[name="idrole"]').val();
      fetch('endpoint/api_roles.php?id=' + dataId, {
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

  $('#modalRoles button.modal-close').click(function () {
    $('#modalRoles').modal('hide');
  });

  $('#modalRoles').on('change', '.form-control', function () {
    $(this).addClass('row-change');
  });

  $('#btnAdd').click(function () {
    $('#modalRoles').modal('show');
    $('.form-control').removeClass('row-change');
    $('#btnSave').text('Tambah');
    $('#inputAction').prop('name', 'add');

    $('#inputIdData input[name="idrole"]').prop('disabled', false);
    $('#modalRoles .form-control').each(function () {
      $(this).val('');
    });
  });

  //get mitra detail
  $(document).on('click', '.edit-data', function (e) {
    $('.form-control').removeClass('row-change');
    const dataId = $(this).data('id');
    window.genId = dataId;

    fetch('endpoint/api_roles.php?id=' + dataId, {
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
        $('#modalRoles').modal('show');
        $('#btnSave').text('Edit');
        $('#inputAction').prop('name', 'edit');

        res = JSON.parse(res);
        let data = res.data;
        const idgen = $('#inputIdData input[name="idrole"]');
        idgen.prop('disabled', true);

        idgen.val(data['role_id']);
        $('#inputName input[name="name"]').val(data['rolename']);
        $('#inputDesc textarea[name="description"]').val(data['description']);
      })
      .catch(error => {
        console.error("Terjadi kesalahan:", error);
        //console.error("Terjadi kesalahan! Silakan coba lagi.");
      });
  });

  $('.edit-data').each(function () {
    $(this).click(function (e) { });
  });
});