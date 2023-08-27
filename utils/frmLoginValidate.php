<?php
echo "
$('#frmLogin').validate({
    rules: {
      txtCorreo: {
        required: true
      },
      txtContrasenna: {
        required: true,
        minlength: 8,
      }
    },

    errorElement: 'span',
    errorPlacement: function(error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function(element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });";
