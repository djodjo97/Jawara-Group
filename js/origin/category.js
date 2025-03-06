$(document).ready(function () {
  $('.form-control[name="code"]').data('col', 'category_code');
  $('.form-control[name="name"]').data('col', 'category_name');

  $('#modalField button.modal-close').click(function () {
    $('#modalField').modal('hide');
  });

  $('#modalField').on('change', '.form-control', function () {
    $(this).addClass('row-change');
  });

  $('#btnAdd').click(function () {
    $('#modalField').modal('show');
    $('.form-control').removeClass('row-change');
    $('#btnSave').text('Tambah');
    $('#inputAction').prop('name', 'add');

    $('#code').prop('disabled', false);
    $('#modalField .form-control').each(function () {
      $(this).val('');
    });
  });

  $(document).on('click', '.edit-data', function (e) {
    $('.form-control').removeClass('row-change');
    const dataId = $(this).data('id');
    window.genId = dataId;

    fetch('endpoint/api_category.php?id=' + dataId, {
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
        const idgen = $('#code');
        idgen.prop('disabled', true);

        idgen.val(data['category_code']);
        $('#name').val(data['category_name']);
      })
      .catch(error => {
        console.error("Terjadi kesalahan:", error);
      });
  });
});