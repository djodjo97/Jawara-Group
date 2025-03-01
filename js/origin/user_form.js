function init() {
  const params = new URLSearchParams(window.location.search);
  if (params.get('id')) {
    $('#title').text('Data User');
    $('#formAction').data('action', 'edit');
    $('#btnSave').text('Ubah');
    $('#btnChPwd').show();
  } else {
    $('#title').text('Tambah User');
    $('#formAction').data('action', 'add');
    $('#btnSave').text('Simpan');
    //$('#btnChPwd').hide();
  }

  $('.form-control[name="code"]').data('col', 'code_user');
  $('.form-control[name="id"]').data('col', 'id_user');
  $('.form-control[name="name"]').data('col', 'name');
  $('.form-control[name="uname"]').data('col', 'username');
  $('.form-control[name="role"]').data('col', 'role_id');
}

function modalAction() {
  $('#fieldData').DataTable();

  $('#fieldModal button.close, #pwdModal button.close').click(function () {
    $(this).closest('.modal').modal('hide');
  });

  $('.option-list input').on('click', function () {
    $(this).siblings('.btn-option').find('button').trigger('click');
  });

  //modal mitra display
  $('#dataOption_code').on('click', function () {
    $('#fieldModal').modal('show');
    $('#fieldData thead tr th').eq(0).text('ID');
    $('#fieldData thead tr th').eq(1).text('Name');

    $('#modalSpinner').show();
    $('#fieldData').DataTable().destroy();
    var table = $('#fieldData').DataTable({
      autoWidth: false,
      columnDefs: [
        { targets: 0, width: "20%" },  // Kolom pertama (index 0) dengan lebar 50px
        { targets: 2, width: "10%" }   // Kolom ketiga dengan lebar otomatis
      ]
    });
    table.clear().draw();
    $('#example th:nth-child(2), #example td:nth-child(2)').css('width', '300px');
    fetch('endpoint/api_mitra.php?p=update-user', {
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
        if (response['data'].length > 0) {
          $.each(response['data'], (i, v) => {
            let rowNode = table.row.add([
              v['id_mitra'],
              v['name'],
              `<button type="button" class="btn btn-success btn-sm dataopt-ch-mitra">Pilih</button>`
            ]).draw().node();
            $(rowNode).find('td').eq(0).addClass('mitra-id').data("val", v['id_mitra']);
            $(rowNode).find('td').eq(1).addClass('mitra-name').data("val", v['name']);
          });
        } else {
          $('.dataTables_empty').append(viewEmptyData());
        }
        $('#modalSpinner').hide();
      })
      .catch(error => {
        console.error("Terjadi kesalahan:", error);
      });
  });

  //modal role display
  $('#dataOption_role').on('click', function () {
    $('#fieldModal').modal('show');
    $('#fieldData thead tr th').eq(0).text('ID');
    $('#fieldData thead tr th').eq(1).text('Role');

    $('#modalSpinner').show();
    $('#fieldData').DataTable().destroy();
    var table = $('#fieldData').DataTable({
      autoWidth: false,
      columnDefs: [
        { targets: 0, width: "10%" },  // Kolom pertama (index 0) dengan lebar 50px
        { targets: 2, width: "10%" }   // Kolom ketiga dengan lebar otomatis
      ]
    });
    table.clear().draw();
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
        if (response['data'].length > 0) {
          $.each(response['data'], (i, v) => {
            let rowNode = table.row.add([
              v['role_id'],
              v['rolename'],
              `<button type="button" class="btn btn-success btn-sm dataopt-ch-role">Pilih</button>`
            ]).draw().node();
            $(rowNode).find('td').eq(0).addClass('role-id').data("val", v['role_id']);
            $(rowNode).find('td').eq(1).addClass('role-name').data("val", v['rolename']);
          });
        } else {
          $('.dataTables_empty').append(viewEmptyData());
        }
        $('#modalSpinner').hide();
      })
      .catch(error => {
        console.error("Terjadi kesalahan:", error);
      });
  });

  // option list mitra
  $('#fieldData').on('click', '.dataopt-ch-mitra', function () {
    $('#code, #mitraName').val('');
    let row = $(this).closest('tr');
    $('#code').val(row.find('.mitra-id').data('val'));
    $('#mitraName').val(row.find('.mitra-name').data('val'));
    $('#fieldModal').modal('hide');
    $('#code').trigger('change');
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
}

function formAction() {
  $('#formAction').on('change', '.form-control', function () {
    $(this).addClass('form-change');
  });

  $('#uname').on('change', function () {
    let uname = $(this).val();
    fetch('endpoint/api_user.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ uname: uname })
    }).then(response => {
      if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
      return response.text();
    }).then(res => {
      if (res['icon'] == "error") {
        Swal.fire({
          icon: res['icon'],
          title: res['title'],
          text: res['text'],
          showConfirmButton: false,
          timer: 1500
        }).then(() => {
          $('#unameInfo').val(res['message']);
        });
      }
    }).catch(error => {
      console.error("Terjadi kesalahan:", error);
    })
  });

  $('#btnSave').on('click', function (e) {
    e.preventDefault();

    if (!$('#formAction').get(0).checkValidity()) {
      $('#formAction').get(0).reportValidity();
      return false;
    }

    if ($('#formAction').data('action') == "add") {
      $('#formAction').submit();
    } else {
      const data = new Object();
      let col;

      $('.form-change').each(function () {
        col = $(this).data('col');
        data[col] = $(this).val();
      });
      const dataId = $('.form-control[name="code"]').val();
      fetch('endpoint/api_user.php?id=' + dataId + '&action=update', {
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

function viewEmptyData(elemOpen = '', elemClose = '') {
  return `${elemOpen}<div class="d-flex flex-column align-items-center no-data py-2">
    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path opacity="0.4" d="M20.68 6.31982V19.9498C20.68 21.7498 19.39 22.5098 17.82 21.6398L12.94 18.9198C12.42 18.6398 11.58 18.6398 11.06 18.9198L6.18 21.6398C5.76 21.8698 5.36 21.9898 5 21.9998L20.68 6.31982Z" fill="#292D32"></path> <path d="M20.1203 3.88L3.39031 20.61C3.34031 20.41 3.32031 20.19 3.32031 19.95V5.86C3.32031 3.74 5.05031 2 7.18031 2H16.8203C18.2203 2 19.4503 2.75 20.1203 3.88Z" fill="#292D32"></path> <path d="M21.7709 2.22988C21.4709 1.92988 20.9809 1.92988 20.6809 2.22988L2.23086 20.6899C1.93086 20.9899 1.93086 21.4799 2.23086 21.7799C2.38086 21.9199 2.57086 21.9999 2.77086 21.9999C2.97086 21.9999 3.16086 21.9199 3.31086 21.7699L21.7709 3.30988C22.0809 3.00988 22.0809 2.52988 21.7709 2.22988Z" fill="#292D32"></path> </g></svg>
    <div>Data tidak ditemukan!</div>
    </div>${elemClose}`;
}

function resetPassword() {
  $('#btnCopyReset, #btnCopyPwd').tooltip('enable');

  $('#btnChPwd').on('click', function () {
    $(this).attr('disabled', true).html(`<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Loading...`);
    const params = new URLSearchParams(window.location.search);
    const dataId = params.get('id');
    fetch('endpoint/api_user.php?id=' + dataId + '&action=reset-sandi', {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json'
      }
    })
      .then(response => {
        $(this).removeAttr('disabled').empty().text('Reset Password');
        if (!response.ok) { throw new Error(`HTTP error! Status: ${response.status}`); }
        return response.text();
      })
      .then(res => {
        $('#pwdModal').modal('show');
        res = JSON.parse(res);
        let data = res.data;
        $('#resetPwd').val(data['password']);
      })
      .catch(error => {
        console.error("Terjadi kesalahan:", error);
      });
  });

  $('#btnCopyReset, #btnCopyPwd').on('click', function () {
    let textCopy = $($(this).parent().siblings('.form-control').get(0)).val();

    navigator.clipboard.writeText(textCopy).then(() => {
      $(this).attr("data-original-title", 'Copied!').tooltip('show');
      setTimeout(() => {
        $(this).attr("data-original-title", 'Copy Password').tooltip('hide');
      }, 1500);
    }).catch(err => {
      console.error("Gagal menyalin teks: ", err);
    });
  });
}

$(document).ready(function () {
  init();
  modalAction();
  formAction();
  resetPassword();
});