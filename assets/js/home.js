/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************!*\
  !*** ./src/js/home.js ***!
  \************************/
$(".vtr__modal__close").on('click', function () {
  $('#register_user').removeClass('open');
});
$("#form_user").submit(function (e) {
  e.preventDefault();
  var response_validation = true;
  var name = $('#name').val().trim();
  var email = $('#email').val().trim();
  var telephone = $('#telephone').val().trim();
  $('.error_message').css('display', 'none');

  if (name === '') {
    $('#name_error').css('display', 'block');
    $('#name_error').html('Ingresar nombre');
    response_validation = false;
  }

  if (email === '') {
    $('#email_error').css('display', 'block');
    $('#email_error').html('Ingresar email');
    response_validation = false;
  } else {
    var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;

    if (!pattern.test(email)) {
      $('#email_error').css('display', 'block');
      $('#email_error').html('Ingresar un formato válido de email');
      response_validation = false;
    }
  }

  if (telephone === '') {
    $('#telephone_error').css('display', 'block');
    $('#telephone_error').html('Ingresar teléfono');
    response_validation = false;
  } else {
    var _pattern = /^[0-9\-\(\)\s]+$/i;

    if (!_pattern.test(telephone)) {
      $('#telephone_error').css('display', 'block');
      $('#telephone_error').html('Ingresar un formato válido de teléfono');
      response_validation = false;
    }
  }

  if (grecaptcha === undefined) {
    //alert('Recaptcha not defined');
    $('#recaptcha_error').css('display', 'block');
    $('#recaptcha_error').html('Ingresar recaptcha');
    return;
  }

  var response = grecaptcha.getResponse();

  if (!response) {
    //alert('Coud not get recaptcha response');
    $('#recaptcha_error').css('display', 'block');
    $('#recaptcha_error').html('No se pudo obtener respuesta');
    return;
  }

  var formBody = [];
  formBody.push('g-recaptcha-response=' + response);
  fetch("captcha.php", {
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    method: "POST",
    body: formBody
  }).then(function (res) {
    return res.json();
  }).then(function (data) {
    if (data == "1") {
      var form = new FormData();
      form.append("name", document.getElementById('name').value.trim());
      form.append("email", document.getElementById('email').value.trim());
      form.append("telephone", document.getElementById('telephone').value.trim());
      form.append("message", document.getElementById('message').value.trim());
      form.append("artist_id", document.getElementById('artist_id').value);
      var urlForm = document.getElementById('url_form').value;
      fetch(urlForm, {
        headers: {},
        method: "POST",
        body: form
      }).then(function (res) {
        return res.json();
      }).then(function (data) {
        $('#register_user').addClass('open');
        document.getElementById('name').value = '';
        document.getElementById('email').value = '';
        document.getElementById('telephone').value = '';
        document.getElementById('message').value = '';
      });
    }
  });
  return false;
  /*$.ajax({
          type: "POST",
          url: "captcha.php",
          data: {
              //This will tell the form if user is captcha varified.
              g-recaptcha-response: grecaptcha.getResponse()
          },
          success: function(response) {
              console.log(response);
              //console.log("Form successfully submited");
          }
  })*/
});
/******/ })()
;