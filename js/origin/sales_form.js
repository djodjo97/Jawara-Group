function init() {
  const params = new URLSearchParams(window.location.search);
  if (params.get('id')) {
    $('#title').text('Data Paket');
    $('#formAction').data('action', 'edit');
    $('#btnSave').text('Ubah');
    let number = parseFloat($('#price').val());
    let formatted = number.toLocaleString("id-ID", { minimumFractionDigits: 2 });
    $('#price').val(formatted);
    number = parseFloat($('#ongkir').val());
    formatted = number.toLocaleString("id-ID", { minimumFractionDigits: 2 });
    $('#ongkir').val(formatted);
  } else {
    $('#title').text('Tambah Paket');
    $('#formAction').data('action', 'add');
    $('#btnSave').text('Simpan');
  }

  $('#datetimepicker').datetimepicker({
    format: 'DD-MM-YYYY'
  });

  $('.form-control[name="code"]').data('col', 'docid');
  $('.form-control[name="txndate"]').data('col', 'docdate');
  $('.form-control[name="mitra"]').data('col', 'mitra_id');
  $('.form-control[name="package"]').data('col', 'package_code');
  $('.form-control[name="type"]').data('col', 'package_type');
  $('.form-control[name="qty"]').data('col', 'qyt');
  $('.form-control[name="package_desc"]').data('col', 'package_desc');
  $('.form-control[name="ship"]').data('col', 'ship_code');
  $('.form-control[name="ship_num"]').data('col', 'tracking_number');
  $('.form-control[name="ongkir"]').data('col', 'ship_amount');
  $('.form-control[name="price"]').data('col', 'amount');
  $('.form-control[name="description"]').data('col', 'description');
}

function formAction() {
  $('#formAction').on('change', '.form-control', function () {
    $(this).addClass('form-change');
  });

  $('#catCode').on('change', function () {
    if ($(this).val() == 'HB') $('#field-type').hide();
    else $('#field-type').show();
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
        if ($(this).data('type') == 'currency') {
          // console.log($(this).val(), parseFloat(($(this).val()).replaceAll('.', '').replace(',', '.')));
          data[col] = parseFloat(($(this).val()).replaceAll('.', '').replace(',', '.'));
        } else {
          data[col] = $(this).val();
        }
      });
      const dataId = $('#code').val();
      fetch('endpoint/api_sales.php?id=' + dataId, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json' },
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

function currencyOnBlur(e) {
  var value = e.target.value
  var options = {
    maximumFractionDigits: 2,
    currency: 'IDR',
    style: "currency",
    currencyDisplay: "symbol"
  }
  e.target.value = (value || value === 0) ? currencyStringToNumber(value, e.type).toLocaleString("id-ID", options) : ''
}

function currencyStringToNumber(currencyString, eType) {
  const userLocale = navigator.language || navigator.userLanguage || 'en-US';
  const cleanedString = currencyString.trim().replace(/^[^\d-]+/, '').replace(/[^\d.,\-]+$/, '');

  const numberFormat = new Intl.NumberFormat(userLocale);
  const formatParts = numberFormat.formatToParts(1234.5);
  const decimalSeparator = formatParts.find(part => part.type === 'decimal')?.value || '.';
  const groupSeparator = formatParts.find(part => part.type === 'group')?.value || ',';

  let normalizedString = cleanedString.replace(new RegExp(`\\${groupSeparator}`, 'g'), '').replace(decimalSeparator, '.');
  let number = parseFloat(normalizedString);

  if (isNaN(number)) throw new Error('Invalid number format');

  number = (eType == 'focus') ? normalizedString.replace('.', ',') : number;
  return number;
};

function eventCurrency() {
  // var currencyInput = document.querySelector('input[type="currency"]');

  // if (currencyInput) {
  //   // Format nilai awal
  //   currencyOnBlur({ target: currencyInput });

  //   // Bind event listeners
  //   currencyInput.addEventListener('focus', function (e) {
  //     var value = e.target.value;
  //     e.target.value = value ? currencyStringToNumber(value, e.type) : '';
  //   });

  //   currencyInput.addEventListener('blur', currencyOnBlur);
  //   // currencyInput.addEventListener('input', function (e) {
  //   //   var cursorPos = e.target.selectionStart; // Simpan posisi kursor
  //   //   var rawValue = e.target.value;
  //   //   var oldLength = rawValue.length; // Panjang string sebelum perubahan

  //   //   // Pastikan pengguna bisa mengetik koma
  //   //   if (rawValue.slice(-1) === ',') {
  //   //     e.target.value = rawValue;
  //   //     e.target.setSelectionRange(cursorPos, cursorPos);
  //   //     return;
  //   //   }

  //   //   var numberValue = currencyStringToNumber(rawValue, 'input');
  //   //   if (numberValue !== null) {
  //   //     e.target.value = numberValue.toLocaleString("id-ID", { minimumFractionDigits: 2 });
  //   //   }

  //   //   var newLength = e.target.value.length; // Panjang string setelah perubahan
  //   //   var diff = newLength - oldLength; // Hitung perubahan panjang string

  //   //   var newCursorPos = cursorPos + diff;
  //   //   e.target.setSelectionRange(newCursorPos, newCursorPos);
  //   // });
  // }

  let inputs = document.querySelectorAll('form input[data-type="currency"]');

  inputs.forEach(input => {
    input.addEventListener("keydown", function (event) {
      let selectionStart = input.selectionStart;
      let value = input.value;

      if (event.ctrlKey && event.shiftKey && event.key === "R") {
        return; // Jangan cegah event ini
      }

      // Izinkan hanya angka, backspace, delete, panah kiri, panah kanan, koma, dan titik
      if (!event.key.match(/[0-9,\.]/) && !["Backspace", "Delete", "ArrowLeft", "ArrowRight", "Home", "End", "Tab"].includes(event.key) || (event.key === "Backspace" && value.indexOf(",") + 1 == selectionStart) || (event.key === "Delete" && value.indexOf(",") > selectionStart - 1)) {
        event.preventDefault();
      }
    });

    input.addEventListener("input", function (event) {
      let selectionStart = input.selectionStart;
      let value = input.value;

      // Hanya izinkan angka, titik, dan koma
      value = value.replace(/[^0-9,\.]/g, "");

      // Gantilah titik pertama (jika ada) dengan kosong agar tidak menyebabkan kesalahan
      value = value.replace(/^\./, "");

      // Pisahkan bagian integer dan desimal
      let parts = value.split(",");

      // Jika bagian integer kosong, tambahkan "0"
      let intPart = parts[0].replace(/\./g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      if (intPart === "") {
        intPart = "0";
      }

      // Jika integer lebih dari atau sama dengan 1 dan memiliki 0 di depan, hapus 0 di paling depan
      if (intPart.length > 1 && intPart.startsWith("0")) {
        intPart = intPart.replace(/^0+/, "");
      }

      // Jika ada bagian desimal, pastikan hanya ada satu koma dan maksimal dua digit setelahnya
      let decimalPart = parts.length > 1 ? "," + parts[1].replace(/[^0-9]/g, "").slice(0, 2) : "";

      // Jika nilai masih kosong, jangan tambahkan ,00
      if (intPart.length > 0 && decimalPart === "") {
        decimalPart = ",00";
      }

      // Tetapkan nilai yang sudah diformat kembali ke input
      input.value = intPart + decimalPart;

      // Hitung posisi caret yang baru agar tetap berada di tempat sebelumnya
      let newPos = selectionStart;
      if (event.inputType === "insertText" && value.length < input.value.length) {
        newPos += (input.value.length - value.length);
      } else if (event.inputType === "deleteContentBackward" && value.length > input.value.length) {
        newPos -= (value.length - input.value.length);
      }

      // Jika angka pertama baru dimasukkan, pindahkan kursor ke depan koma
      if ((value.length > input.value.length && value.length === 5) || value.length === 1) {
        newPos = 1;
      }

      input.setSelectionRange(newPos, newPos);
    });

    input.addEventListener("change", function (event) {
      let value = input.value;
      let parts = value.split(",");
      if (parts[1].length < 1) input.value = value + "00";
    });
  })

}

function modalAction() {
  $('.opt-value').on('keydown', function (e) {
    e.preventDefault();
  });

  $('#fieldData').DataTable();

  $('#fieldModal button.close, #pwdModal button.close').click(function () {
    $(this).closest('.modal').modal('hide');
  });

  $('.option-list input').on('click', function () {
    $(this).siblings('.btn-option').find('button').trigger('click');
  });

  $('#fieldData').on('click', '.dataopt-change', function () {
    let row = $(this).closest('tr');
    row.find('.row-data').each(function () {
      const target = $(this).data('target');
      $('#' + target).val($(this).data('val'));
      if ($(this).hasClass('change-data')) {
        $('#' + target).trigger('change');
      }
    });
    $('#fieldModal').modal('hide');
  });

  //modal category display
  $('#dataOption_category').on('click', function () {
    $('#category').removeClass('border border-danger');

    $('#fieldModal').modal('show');
    $('#fieldData').DataTable().destroy();
    $('#fieldData thead tr').empty().append(`<th></th> <th></th> <th></th>`)
    $('#fieldData thead tr th').eq(0).text('ID');
    $('#fieldData thead tr th').eq(1).text('Kategori');
    $('#fieldData tbody').empty();

    $('#modalSpinner').show();
    var table = $('#fieldData').DataTable({
      autoWidth: false,
      columns: [
        { data: 'category_code', width: "10%" },
        { data: 'category_name' },
        { data: 'button', width: "10%", orderable: false }
      ]
    });
    table.clear().draw();
    fetch('endpoint/api_category.php', {
      method: 'GET',
      headers: { 'Content-Type': 'application/json' }
    })
      .then(response => {
        if (!response.ok) { throw new Error(`HTTP error! Status: ${response.status}`); }
        return response.text();
      })
      .then(res => {
        const response = JSON.parse(res);
        if (response['data'].length > 0) {
          $.each(response['data'], (i, v) => {
            let rowNode = table.row.add({
              category_code: v['category_code'],
              category_name: v['category_name'],
              button: `<button type="button" class="btn btn-success btn-sm dataopt-change">Pilih</button>`
            }).draw().node();
            $(rowNode).find('td').eq(0).addClass('row-data change-data').data({ "val": v['category_code'], 'target': 'catCode' });
            $(rowNode).find('td').eq(1).addClass('row-data').data({ "val": v['category_name'], 'target': 'category' });
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

  //modal package display
  $('#dataOption_package').on('click', function () {
    const catCode = $('#catCode').val();
    if (!catCode) {
      $('#category').addClass('border border-danger');
      return false;
    }
    $('#fieldModal').modal('show');
    $('#fieldData').DataTable().destroy();
    $('#fieldData thead tr').empty().append(`<th></th><th></th><th></th><th></th>`);
    $('#fieldData thead tr th').eq(0).text('Kode');
    $('#fieldData thead tr th').eq(1).text('Nama');
    $('#fieldData thead tr th').eq(2).text('Harga');
    $('#fieldData tbody').empty();

    $('#modalSpinner').show();
    var table = $('#fieldData').DataTable({
      autoWidth: false,
      columns: [
        { data: 'package_code', width: "10%" },
        { data: 'package_name' },
        { data: 'price' },
        { data: 'button', width: "10%", orderable: false }
      ]
    });
    table.clear().draw();
    fetch('endpoint/api_package.php?category=' + catCode, {
      method: 'GET',
      headers: { 'Content-Type': 'application/json' }
    })
      .then(response => {
        if (!response.ok) { throw new Error(`HTTP error! Status: ${response.status}`); }
        return response.text();
      })
      .then(res => {
        const response = JSON.parse(res);
        if (response['data'].length > 0) {
          $.each(response['data'], (i, v) => {
            let price = parseFloat(v['price']).toLocaleString("id-ID", { minimumFractionDigits: 2 });

            let rowNode = table.row.add({
              package_code: v['package_code'],
              package_name: v['package_name'],
              price: price,
              button: `<button type="button" class="btn btn-success btn-sm dataopt-change">Pilih</button>`
            }).draw().node();
            $(rowNode).find('td').eq(0).addClass('row-data change-data').data({ "val": v['package_code'], 'target': 'package' });
            $(rowNode).find('td').eq(1).addClass('row-data').data({ "val": v['package_name'], 'target': 'packageName' });
            $(rowNode).find('td').eq(2).addClass('row-data').data({ "val": price, 'target': 'price' });
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

  //modal courier display
  $('#dataOption_courier').on('click', function () {
    $('#fieldModal').modal('show');
    $('#fieldData').DataTable().destroy();
    $('#fieldData thead tr').empty().append(`<th></th> <th></th> <th></th>`)
    $('#fieldData thead tr th').eq(0).text('ID');
    $('#fieldData thead tr th').eq(1).text('Kategori');
    $('#fieldData tbody').empty();

    $('#modalSpinner').show();
    var table = $('#fieldData').DataTable({
      autoWidth: false,
      columns: [
        { data: 'ship_code', width: "10%" },
        { data: 'ship_name' },
        { data: 'button', width: "10%", orderable: false }
      ]
    });
    table.clear().draw();
    fetch('endpoint/api_courier.php', {
      method: 'GET',
      headers: { 'Content-Type': 'application/json' }
    })
      .then(response => {
        if (!response.ok) { throw new Error(`HTTP error! Status: ${response.status}`); }
        return response.text();
      })
      .then(res => {
        const response = JSON.parse(res);
        if (response['data'].length > 0) {
          $.each(response['data'], (i, v) => {
            let rowNode = table.row.add({
              ship_code: v['ship_code'],
              ship_name: v['ship_name'],
              button: `<button type="button" class="btn btn-success btn-sm dataopt-change">Pilih</button>`
            }).draw().node();
            $(rowNode).find('td').eq(0).addClass('row-data change-data').data({ "val": v['ship_code'], 'target': 'ship' });
            $(rowNode).find('td').eq(1).addClass('row-data').data({ "val": v['ship_name'], 'target': 'shipName' });
          });
        } else {
          $('.dataTables_empty').append(viewEmptyData());
        }
        $('#modalSpinner').hide();
      })
      .catch(error => { console.error("Terjadi kesalahan:", error); });
  });

  //modal mitra display
  $('#dataOption_mitra').on('click', function () {
    $('#fieldModal').modal('show');
    $('#fieldData').DataTable().destroy();
    $('#fieldData thead tr').empty().append(`<th></th> <th></th> <th></th>`)
    $('#fieldData thead tr th').eq(0).text('ID');
    $('#fieldData thead tr th').eq(1).text('Name');
    $('#fieldData tbody').empty();

    $('#modalSpinner').show();
    var table = $('#fieldData').DataTable({
      autoWidth: false,
      columns: [
        { data: 'id_mitra', width: "10%" },
        { data: 'mitra_name' },
        { data: 'button', width: "10%", orderable: false }
      ]
    });
    table.clear().draw();
    fetch('endpoint/api_mitra.php', {
      method: 'GET',
      headers: { 'Content-Type': 'application/json' }
    })
      .then(response => {
        if (!response.ok) { throw new Error(`HTTP error! Status: ${response.status}`); }
        return response.text();
      })
      .then(res => {
        const response = JSON.parse(res);
        if (response['data'].length > 0) {
          $.each(response['data'], (i, v) => {
            let rowNode = table.row.add({
              id_mitra: v['id_mitra'],
              mitra_name: v['name'],
              button: `<button type="button" class="btn btn-success btn-sm dataopt-change">Pilih</button>`
            }).draw().node();
            $(rowNode).find('td').eq(0).addClass('row-data change-data').data({ "val": v['id_mitra'], 'target': 'mitra' });
            $(rowNode).find('td').eq(1).addClass('row-data').data({ "val": v['name'], 'target': 'mitraName' });
          });
        } else {
          $('.dataTables_empty').append(viewEmptyData());
        }
        $('#modalSpinner').hide();
      })
      .catch(error => { console.error("Terjadi kesalahan:", error); });
  });

  //modal type display
  $('#dataOption_type').on('click', function () {
    $('#fieldModal').modal('show');
    $('#fieldData').DataTable().destroy();
    $('#fieldData thead tr').empty().append(`<th></th><th></th><th></th>`)
    $('#fieldData thead tr th').eq(0).text('ID');
    $('#fieldData thead tr th').eq(1).text('Jenis');
    $('#fieldData tbody').empty();

    $('#modalSpinner').show();
    var table = $('#fieldData').DataTable({
      autoWidth: false,
      columns: [
        { data: 'type_id', width: "10%" },
        { data: 'type_name' },
        { data: 'button', width: "10%", orderable: false }
      ]
    });
    table.clear().draw();
    fetch('endpoint/api_types.php?group=smell', {
      method: 'GET',
      headers: { 'Content-Type': 'application/json' }
    })
      .then(response => {
        if (!response.ok) { throw new Error(`HTTP error! Status: ${response.status}`); }
        return response.text();
      })
      .then(res => {
        const response = JSON.parse(res);
        if (response['data'].length > 0) {
          $.each(response['data'], (i, v) => {
            let rowNode = table.row.add({
              type_id: v['type_id'],
              type_name: v['type_name'],
              button: `<button type="button" class="btn btn-success btn-sm dataopt-change">Pilih</button>`
            }).draw().node();
            $(rowNode).find('td').eq(0).addClass('row-data change-data').data({ "val": v['type_id'], 'target': 'type' });
            $(rowNode).find('td').eq(1).addClass('row-data').data({ "val": v['type_name'], 'target': 'smell_name' });
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
}

function viewEmptyData(elemOpen = '', elemClose = '') {
  return `${elemOpen}<div class="d-flex flex-column align-items-center no-data py-2">
    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path opacity="0.4" d="M20.68 6.31982V19.9498C20.68 21.7498 19.39 22.5098 17.82 21.6398L12.94 18.9198C12.42 18.6398 11.58 18.6398 11.06 18.9198L6.18 21.6398C5.76 21.8698 5.36 21.9898 5 21.9998L20.68 6.31982Z" fill="#292D32"></path> <path d="M20.1203 3.88L3.39031 20.61C3.34031 20.41 3.32031 20.19 3.32031 19.95V5.86C3.32031 3.74 5.05031 2 7.18031 2H16.8203C18.2203 2 19.4503 2.75 20.1203 3.88Z" fill="#292D32"></path> <path d="M21.7709 2.22988C21.4709 1.92988 20.9809 1.92988 20.6809 2.22988L2.23086 20.6899C1.93086 20.9899 1.93086 21.4799 2.23086 21.7799C2.38086 21.9199 2.57086 21.9999 2.77086 21.9999C2.97086 21.9999 3.16086 21.9199 3.31086 21.7699L21.7709 3.30988C22.0809 3.00988 22.0809 2.52988 21.7709 2.22988Z" fill="#292D32"></path> </g></svg>
    <div>Data tidak ditemukan!</div>
    </div>${elemClose}`;
}

$(document).ready(function () {
  init();
  eventCurrency();
  modalAction();
  formAction();
});