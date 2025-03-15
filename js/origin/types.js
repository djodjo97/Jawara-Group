$(document).ready(function () {
  $('.form-control[name="idtypes"]').data('col', 'type_id');
  $('.form-control[name="name"]').data('col', 'type_name');

  $('#modalField button.modal-close').click(function () {
    $('#modalField').modal('hide');
  });

  $('#formAction').on('change', '.form-control', function () {
    $(this).addClass('row-change');
  });

  $('#btnAdd').click(function () {
    $('#modalField').modal('show');
    $('.form-control').removeClass('row-change');
    $('#btnSave').text('Tambah');
    $('#inputAction').prop('name', 'add');
    $('#formAction .form-control').each(function () {
      $(this).val('');
    });
  });

  $(document).on('click', '.edit-data', function (e) {
    $('.form-control').removeClass('row-change');
    const dataId = $(this).data('id');
    window.genId = dataId;

    fetch('endpoint/api_types.php?id=' + dataId, {
      method: 'GET',
      headers: { 'Content-Type': 'application/json' }
    })
      .then(response => {
        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
        return response.text();
      })
      .then(res => {
        res = JSON.parse(res);
        let data = res.data;

        $('#modalField').modal('show');
        $('#btnSave').text('Edit');
        $('#inputAction').prop('name', 'edit');
        const idData = $('#idtypes');
        //idData.prop('disabled', true);

        idData.val(data['type_id']);
        $('#name').val(data['type_name']);
      })
      .catch(error => {
        console.error("Terjadi kesalahan:", error);
      });
  });

  $('#btnSave').on('click', function (e) {
    if ($('#inputAction[name="add"]').length) {
      $('#formAction').submit();
    } else {
      const data = new Object();
      let attr;
      $('.row-change').each(function () {
        attr = $(this).data('col');
        data[attr] = $(this).val();
      });
      const dataId = $('.form-control[name="idtypes"]').val();
      fetch('endpoint/api_types.php?id=' + dataId, {
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
          res = JSON.parse(res);

          Swal.fire({
            icon: res['icon'],
            title: res['message'],
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
});