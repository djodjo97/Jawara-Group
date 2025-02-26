//aturan password
const reRules = {
  lower: /[a-z]/,  // Minimal satu huruf kecil
  upper: /[A-Z]/,  // Minimal satu huruf besar
  digit: /\d/,      // Minimal satu angka
  special: /[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/, // Minimal satu karakter spesial
  noRepeat: /(.)\1{2,}/, // Tidak boleh ada tiga karakter yang sama berurutan
};
const minLength = 8;
const allowedKeys = ["Backspace", "Tab", "Enter", "Shift", "Control", "Alt", "CapsLock", "ArrowLeft", "ArrowRight", "Delete"];

// Fungsi untuk mengecek pola tiga karakter yang berulang
// function hasRepeatedPattern(pwd) {
//   for (let i = 0; i < pwd.length - 2; i++) {
//     let pattern = pwd.substring(i, i + 3);
//     let safePattern = pattern.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
//     let regex = new RegExp(safePattern, "g");
//     if ((pwd.match(regex) || []).length > 1) return true;
//   }
//   return false;
// }

// Fungsi untuk mengecek pola tiga karakter yang berdekatan
function hasRepeatedPattern(pwd) {
  for (let i = 0; i < pwd.length - 3; i++) {
    if (pwd.substring(i, i + 3) === pwd.substring(i + 3, i + 6)) return true;
  }
  return false;
}

function validatePwd(pwd) {
  let $res = "";

  if (pwd.length < minLength) $res = "Minimal 8 karakter";
  else if (!reRules.lower.test(pwd)) $res = "Setidaknya mengandung satu huruf kecil";
  else if (!reRules.upper.test(pwd)) $res = "Setidaknya mengandung satu huruf kapital";
  else if (!reRules.digit.test(pwd)) $res = "Setidaknya mengandung satu angka";
  else if (!reRules.special.test(pwd)) $res = "Setidaknya mengandung ?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]";
  else if (reRules.noRepeat.test(pwd)) $res = "Tidak boleh ada tiga karakter berulang berturut-turut";
  else if (hasRepeatedPattern(pwd)) $res = `Tidak boleh ada <b>pola tiga karakter</b> berdekatan yang berulang dalam password`;

  if ($res) $('#newPwd').addClass('border-danger');
  else $('#newPwd').removeClass('border-danger');
  return $res;
}

$(document).ready(function () {
  $('body').on('keydown', 'form', function (e) {
    if (e.key == "Enter") $(this).find('.submit-btn').trigger('click');
  });

  //profile events
  $('#formChangeProfile').on('input', '.form-control', function () {
    $(this).addClass('row-change');
  });

  $('#btnChangeProfile').click(function () {
    if ($('#formChangeProfile .row-change').length > 0) {
      $('#formChangeProfile').submit();
    }
  });

  //password events
  $('#pwd').on('keydown', function () {
    $('#pwdInfo').text('');
    $(this).removeClass('border-danger');
  });

  $('#newPwd').on('keydown', function (e) {
    let key = e.key;
    !Object.values(reRules).some((regex) => regex.test(key)) && !allowedKeys.includes(key) && e.preventDefault();
  });

  $("#newPwd").on("input", function () {
    let newPwd = $(this).val().trim();
    let invalidChars = newPwd.match(/[^a-zA-Z0-9!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/g);
    if (invalidChars) {
      $(this).val('');
      $("#newPwdInfo").text(`( ${[...new Set(invalidChars)].join(', ')} ) tidak diizinkan!`);
      return
    }
    $("#newPwdInfo").html(validatePwd(newPwd));
  });

  $('#confPwd, #newPwd').on('input', function () {
    if ($('#confPwd').val().trim() !== $('#newPwd').val().trim()) {
      $("#confPwdInfo").text("Password tidak sama!");
      $("#confPwd").addClass('border-danger');
    } else {
      $("#confPwdInfo").text("");
      $("#confPwd").removeClass('border-danger');
    }
  });

  $('#btnChangePwd').on('click', function (e) {
    $('#formChangePwd .form-control').each(function (i, elem) {
      if (!$(this).val()) $(this).addClass('border-danger');
      return;
    });

    if (!$('#formChangePwd').get(0).checkValidity()) {
      $('#formChangePwd').get(0).reportValidity();
      return false;
    }

    let newPwd = $('#newPwd').val().trim();
    let confPwd = $('#confPwd').val().trim();
    if ($('#pwd').val().trim() && newPwd && confPwd && newPwd === confPwd && validatePwd(newPwd) === "") {
      $('#formChangePwd').submit();
    }
  });

  //$('#formChangePwd').on('keydown', e => e.key == "Enter" && $('#btnChangePwd').trigger('click') || true);
});

