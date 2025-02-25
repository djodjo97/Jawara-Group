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
function hasRepeatedPattern(pwd) {
  for (let i = 0; i < pwd.length - 2; i++) {
    let pattern = pwd.substring(i, i + 3);
    let regex = new RegExp(pattern, "g");
    if ((pwd.match(regex) || []).length > 1) {
      return true; // Jika pola muncul lebih dari sekali, maka tidak valid
    }
  }
  return false;
}

function validatePwd(pwd) {
  if (pwd.length < minLength) return "Minimal 8 karakter";
  if (!reRules.lower.test(pwd)) return "Setidaknya mengandung satu huruf kecil";
  if (!reRules.upper.test(pwd)) return "Setidaknya mengandung satu huruf kapital";
  if (!reRules.digit.test(pwd)) return "Setidaknya mengandung satu angka";
  if (!reRules.special.test(pwd)) return "Setidaknya mengandung ?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]";
  if (reRules.noRepeat.test(pwd)) return "Tidak boleh ada tiga karakter berulang berturut-turut";
  if (hasRepeatedPattern(pwd)) return "Tidak boleh ada pola tiga karakter yang berulang dalam password";
  return "";
}

function pwdAction() {
  $('#pwd').on('keydown', function () {
    $('#pwdInfo').text('');
  });

  $('#newPwd').on('keydown', function (e) {
    let key = e.key;
    if (!Object.values(reRules).some((regex) => regex.test(key)) && !allowedKeys.includes(key)) {
      e.preventDefault();
    }
  });

  $("#newPwd").on("input", function () {
    let newPwd = $(this).val();
    let invalidChars = newPwd.match(/[^a-zA-Z0-9!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/g);
    if (invalidChars) {
      $(this).val('');
      $("#newPwdInfo").text(`( ${[...new Set(invalidChars)].join(', ')} ) tidak diizinkan!`);
      return
    }

    $("#newPwdInfo").text(validatePwd(newPwd));
  });

  $('#confPwd').on('input', function () {
    if ($(this).val() != $('#newPwd').val()) {
      $("#confPwdInfo").text("Password tidak sama!");
    } else {
      $("#confPwdInfo").text('');
    }
  });

  $('#formPwd').on('submit', function (e) {
    const pwd = $("pwd").val();
    const newPwd = $("newPwd").val();
    const confPwd = $("confPwd").val();
    const status = $("status");
    e.preventDefault();
  });
}

document.addEventListener("DOMContentLoaded", function () {
  if (window.jQuery) {
    pwdAction();
  }
  else {
    console.error("jQuery belum tersedia!");
  }
});