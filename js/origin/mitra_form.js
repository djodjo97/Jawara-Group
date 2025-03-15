document.addEventListener("DOMContentLoaded", function () {
  if (window.jQuery) {
    $('.form-control[name="idmitra"]').data('col', 'id_mitra');
    $('.form-control[name="regnum"]').data('col', 'registration_number');
    $('.form-control[name="name"]').data('col', 'name');
    $('.form-control[name="email"]').data('col', 'email');
    $('.form-control[name="phone"]').data('col', 'phone');
    $('.form-control[name="address"]').data('col', 'address');
    $('.form-control[name="gen"]').data('col', 'gen_id');
    $('.form-control[name="id_type"]').data('col', 'identity_type');
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
      $('#btnSave').text('Ubah');
      $('.form-control[name="idmitra"').prop('readonly', true);
    } else {
      $('#title').text('Pendaftaran Mitra');
      $('#formAction').data('action', 'add');
      $('#btnSave').text('Simpan');
      $('.form-control[name="idmitra"').prop('readonly', false);
    }

    $('#idType').on('change', function () {
      const idType = $(this).val();
      if (idType == "ktp") {
        $('#idCard input[name="ktp"]').prop('hidden', false);
        $('#idCard input[name="sim"]').prop('hidden', true);
      } else if (idType == "sim") {
        $('#idCard input[name="ktp"]').prop('hidden', true);
        $('#idCard input[name="sim"]').prop('hidden', false);
      }
    });

    $('#formAction').on('change', '.form-control', function () {
      $(this).addClass('row-change');
    });

    $('#btnSave').on('click', function (e) {
      e.preventDefault(); // Mencegah aksi default tombol
      const ktp = $('#ktp')[0];
      if (ktp.value && ktp.value.length !== 16) {
        ktp.setCustomValidity("Harus terdiri dari 16 angka!");
      } else {
        ktp.setCustomValidity('');
      }

      if (!$('#formAction').get(0).checkValidity()) {
        $('#formAction').get(0).reportValidity();
        return false;
      }

      if ($('#formAction').data('action') == "add") {
        $('#formAction').submit();
      } else {
        const data = new Object();
        let attr;
        $('.row-change').each(function () {
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

    $('#fieldModal button.close').click(function () {
      $('#fieldModal').modal('hide');
    });

    $('#fieldData').on('click', '.datacode-ch-gen', function () {
      $('#leaderId, #leaderName').val('');
      $('#fieldModal').modal('hide');
      let row = $(this).closest('tr');
      $('#genId').val(row.find('.gen-id').text());
      $('#genDesc').val(row.find('.gen-desc').text());
      $('#genId').trigger('change');
    });

    $('#fieldData').on('click', '.datacode-ch-leader', function () {
      $('#fieldModal').modal('hide');
      let row = $(this).closest('tr');
      $('#leaderId').val(row.find('.leader-id').text());
      $('#leaderName').val(row.find('.leader-name').text());
      $('#leaderId').trigger('change');
    });

    //modal display
    $('#dataCode_gen').on('click', function () {
      $('#genDesc').removeClass('border border-danger');
      $('#fieldModal').modal('show');
      $('#fieldData thead tr').empty().append(`<th scope="col" width="20%">No Urut</th>
          <th scope="col" width="10%">ID</th>
          <th scope="col">Deskripsi</th>
          <th scope="col" width="10%"></th>`);

      $('#modalSpinner').show();
      $('#fieldData tbody').empty();
      fetch('endpoint/api_generation.php?order=seq', {
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
                    <th scope="row"><div class="seq">${v['seq']}</div></th>
                    <td><div class="gen-id">${v['id_generation']}</div></td>
                    <td><div class="gen-desc">${v['description']}</div></td>
                    <td><button type="button" class="btn btn-success btn-sm datacode-ch-gen">Pilih</button></td>
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


    $('#dataCode_leader').on('click', function () {
      const genId = $('#genId').val();
      if (!genId) {
        $('#genDesc').addClass('border border-danger');
        return false;
      }

      $('#fieldModal').modal('show');
      $('#fieldData thead tr').empty().append(`<th scope="col" width="20%">ID Mitra</th>
          <th scope="col">Nama</th>
          <th scope="col" width="10%"></th>`);

      $('#modalSpinner').show();
      $('#fieldData tbody').empty();

      fetch('endpoint/api_mitra.php?p=data-code&genid=' + genId, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
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
                    <th scope="row"><div class="leader-id">${v['id_mitra']}</div></th>
                    <td><div class="leader-name">${v['name']}</div></td>
                    <td><button type="button" class="btn btn-success btn-sm datacode-ch-leader">Pilih</button></td>
                  </tr>`;
            });
          } else {
            elem = viewEmptyData('<tr><td colspan="3">', '</td></tr>');
          }

          $('#fieldData tbody').append(elem);
          $('#modalSpinner').hide();
        })
        .catch(error => {
          console.error("Terjadi kesalahan:", error);
        });
    });

    $('.option-list input').on('click', function () {
      $(this).siblings('.btn-option').find('button').trigger('click');
    });

    $('.dataCode_up').on('click', function () {
      const genId = $('#genId').val();
      if (!genId) {
        $('#genDesc').addClass('border border-danger');
        $('#genId')[0].setCustomValidity("Harus terdiri dari 16 angka!");
        $('#genId')[0].reportValidity();
        return false;
      } else {
        $('#genId')[0].setCustomValidity("");
      }
      const upperNum = $(this).attr('id').split('_').pop().length;

      $('#fieldModal').modal('show');
      $('#fieldData thead tr').empty().append(`<th scope="col" width="20%">ID Mitra</th>
          <th scope="col">Nama</th>
          <th scope="col" width="10%"></th>`);
      $('#modalSpinner').show();
      $('#fieldData tbody').empty();

      fetch('endpoint/api_mitra.php?p=data-code&genid=' + genId + '&up_id=' + upperNum, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
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
                  <th scope="row"><div class="up-id">${v['id_mitra']}</div></th>
                  <td><div class="up-name">${v['name']}</div></td>
                  <td><button type="button" class="btn btn-success btn-sm datacode-ch-up${upperNum}">Pilih</button></td>
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

    function generateRegnum() {
      const mitraId = $('#mitraId').val();
      if (!mitraId) return false;
      const leaderId = $('#leaderId').val();
      if (!leaderId) return false;
      $('#regnum').val(mitraId + leaderId);
    }

    $('#mitraId, #leaderId').on('change', function () {
      generateRegnum();
    });

    $('#genId').on('change', function () {
      const genId = $(this).val();
      if (genId == 'FDR') $('#rowLeader').hide();
      else $('#rowLeader').show();
    });

    function viewEmptyData(elemOpen, elemClose) {
      return `${elemOpen}<div class="d-flex flex-column align-items-center no-data py-2">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path opacity="0.4" d="M20.68 6.31982V19.9498C20.68 21.7498 19.39 22.5098 17.82 21.6398L12.94 18.9198C12.42 18.6398 11.58 18.6398 11.06 18.9198L6.18 21.6398C5.76 21.8698 5.36 21.9898 5 21.9998L20.68 6.31982Z" fill="#292D32"></path> <path d="M20.1203 3.88L3.39031 20.61C3.34031 20.41 3.32031 20.19 3.32031 19.95V5.86C3.32031 3.74 5.05031 2 7.18031 2H16.8203C18.2203 2 19.4503 2.75 20.1203 3.88Z" fill="#292D32"></path> <path d="M21.7709 2.22988C21.4709 1.92988 20.9809 1.92988 20.6809 2.22988L2.23086 20.6899C1.93086 20.9899 1.93086 21.4799 2.23086 21.7799C2.38086 21.9199 2.57086 21.9999 2.77086 21.9999C2.97086 21.9999 3.16086 21.9199 3.31086 21.7699L21.7709 3.30988C22.0809 3.00988 22.0809 2.52988 21.7709 2.22988Z" fill="#292D32"></path> </g></svg>
        <div>Data tidak ditemukan!</div>
        </div>${elemClose}`;
    }

  } else {
    console.error("jQuery belum tersedia!");
  }
});
