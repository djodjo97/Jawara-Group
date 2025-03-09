function init() {
  const params = new URLSearchParams(window.location.search);
  if (params.get('id')) {
    $('#title').text('Data Paket');
    $('#formAction').data('action', 'edit');
    $('#btnSave').text('Ubah');
  } else {
    $('#title').text('Tambah Paket');
    $('#formAction').data('action', 'add');
    $('#btnSave').text('Simpan');
  }

  $('.form-control[name="code"]').data('col', 'package_code');
  $('.form-control[name="name"]').data('col', 'package_name');
  $('.form-control[name="category"]').data('col', 'category_code');
  $('.form-control[name="type"]').data('col', 'smell_type');
  $('.form-control[name="gender"]').data('col', 'gender');
  $('.form-control[name="price"]').data('col', 'price');
  $('.form-control[name="comm"]').data('col', 'commission');
  $('.form-control[name="description"]').data('col', 'description');
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
    //row.find('.data-id').trigger('change');
    //$('#catCode').trigger('change');
  });

  //modal role display
  $('#dataOption_category').on('click', function () {
    $('#fieldModal').modal('show');
    $('#fieldData').DataTable().destroy();
    $('#fieldData thead tr').empty().append(`<th></th><th></th><th></th>`)
    $('#fieldData thead tr th').eq(0).text('ID');
    $('#fieldData thead tr th').eq(1).text('Category');

    $('#modalSpinner').show();
    var table = $('#fieldData').DataTable({
      autoWidth: false,
      columnDefs: [
        { targets: 0, width: "10%" },  // Kolom pertama (index 0) dengan lebar 50px
        { targets: 2, width: "10%" }   // Kolom ketiga dengan lebar otomatis
      ]
    });
    table.clear().draw();
    fetch('endpoint/api_category.php', {
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
              v['category_code'],
              v['category_name'],
              `<button type="button" class="btn btn-success btn-sm dataopt-change">Pilih</button>`
            ]).draw().node();
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
});