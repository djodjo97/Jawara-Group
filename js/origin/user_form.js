function init() {
  const params = new URLSearchParams(window.location.search);
  if (params.get('id')) {
    $('#title').text('Data User');
    $('#formAction').data('action', 'edit');
    $('#btnSave').text('Ubah');
  } else {
    $('#title').text('Tambah User');
    $('#formAction').data('action', 'add');
    $('#btnSave').text('Simpan');
  }

  $('.form-control[name="code"]').data('col', 'code_user');
  $('.form-control[name="id"]').data('col', 'id_user');
  $('.form-control[name="name"]').data('col', 'name');
  $('.form-control[name="uname"]').data('col', 'username');
  $('.form-control[name="role"]').data('col', 'role_id');
}

function modalAction() {
  $('#fieldModal button.close').click(function () {
    $('#fieldModal').modal('hide');
  });

  $('.option-list input').on('click', function () {
    $(this).siblings('.btn-option').find('button').trigger('click');
  });

  // option list mitra
  $('#fieldData').on('click', '.dataopt-ch-mitra', function () {
    $('#code, #mitraName').val('');
    $('#fieldModal').modal('hide');
    let row = $(this).closest('tr');
    $('#code').val(row.find('.mitra-id').text());
    $('#mitraName').val(row.find('.mitra-name').text());
    $('#code').trigger('change');
  });

  //modal mitra display
  $('#dataOption_code').on('click', function () {
    $('#fieldModal').modal('show');
    $('#fieldData thead tr').empty().append(`<th scope="col" width="15%">ID</th>
        <th scope="col">Name</th>
        <th scope="col" width="10%"></th>`);

    $('#modalSpinner').show();
    $('#fieldData tbody').empty();
    fetch('endpoint/api_mitra.php', {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json'
      }
    })
      .then(response => {
        if (!response.ok) { throw new Error(`HTTP error! Status: ${response.status}`); }
        return response.text();
      })
      .then(res => {
        const response = JSON.parse(res);
        let elem = '';
        if (response['data'].length > 0) {
          $.each(response['data'], function (i, v) {
            elem += `<tr>
                  <td><div class="mitra-id">${v['id_mitra']}</div></td>
                  <td><div class="mitra-name">${v['name']}</div></td>
                  <td><button type="button" class="btn btn-success btn-sm dataopt-ch-mitra">Pilih</button></td>
                </tr>`;
          });
        } else {
          elem = viewEmptyData('<tr><td colspan="3">', '</td></tr>');
        }
        $('#modalSpinner').hide();
        $('#fieldData tbody').append(elem);
      })
      .catch(error => {
        console.error("Terjadi kesalahan:", error);
      });
  });

  // option list role
  $('#fieldData').on('click', '.dataopt-ch-role', function () {
    $('#role, #roleName').val('');
    $('#fieldModal').modal('hide');
    let row = $(this).closest('tr');
    $('#role').val(row.find('.role-id').text());
    $('#roleName').val(row.find('.role-name').text());
    $('#role').trigger('change');
  });

  //modal role display
  $('#dataOption_role').on('click', function () {
    $('#fieldModal').modal('show');
    $('#fieldData thead tr').empty().append(`<th scope="col" width="15%">ID</th>
        <th scope="col">Role</th>
        <th scope="col" width="10%"></th>`);

    $('#modalSpinner').show();
    $('#fieldData tbody').empty();
    fetch('endpoint/api_roles.php', {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json'
      }
    })
      .then(response => {
        if (!response.ok) { throw new Error(`HTTP error! Status: ${response.status}`); }
        return response.text();
      })
      .then(res => {
        const response = JSON.parse(res);
        let elem = '';
        if (response['data'].length > 0) {
          $.each(response['data'], function (i, v) {
            elem += `<tr>
                  <td><div class="role-id">${v['role_id']}</div></td>
                  <td><div class="role-name">${v['rolename']}</div></td>
                  <td><button type="button" class="btn btn-success btn-sm dataopt-ch-role">Pilih</button></td>
                </tr>`;
          });
        } else {
          elem = viewEmptyData('<tr><td colspan="3">', '</td></tr>');
        }
        $('#modalSpinner').hide();
        $('#fieldData tbody').append(elem);
      })
      .catch(error => {
        console.error("Terjadi kesalahan:", error);
      });
  });
}

document.addEventListener("DOMContentLoaded", function () {
  if (window.jQuery) {
    init();
    modalAction();

    $('#formAction').on('change', '.form-control', function () {
      $(this).addClass('form-change');
    });

    $('#btnSave').on('click', function (e) {
      e.preventDefault();
      if ($('#formAction').data('action') == "add") {
        $('#formAction').submit();
      } else {
        const data = new Object();
        let attr;

        $('.form-change').each(function () {
          attr = $(this).data('col');
          data[attr] = $(this).val();
        });
        const dataId = $('.form-control[name="code"]').val();
        fetch('endpoint/api_user.php?id=' + dataId, {
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
  }
  else {
    console.error("jQuery belum tersedia!");
  }
});