$(document).ready(function () {
  $('.form-control[name="idgen"]').data('col', 'id_generation');
  $('.form-control[name="seq"]').data('col', 'seq');
  $('.form-control[name="description"]').data('col', 'description');

  $('#btnAdd').click(function () {
    $('.form-control').removeClass('row-change');
    $('#btnSave').text('Tambah');
    $('#inputAction').prop('name', 'add');

    $('#inputIdgen input[name="idgen"]').prop('disabled', false);
    $('#modalGeneration .form-control').each(function () {
      $(this).val('');
    });
  });

  //get mitra detail
  $(document).on('click', '.edit-gen', function (e) {
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
      });
  });

  $('#modalGeneration').on('change', '.form-control', function () {
    $(this).addClass('row-change');
  });

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
});