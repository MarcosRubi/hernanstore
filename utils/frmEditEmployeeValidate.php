<?php
echo "$('#frmEditEmployee').validate({
    rules: {
        txtNombre: {
            required: true
        },
        txtCorreo: {
            required: true
        },
    },
    messages: {
        txtNombre: {
            required: \"El nombre es obligatorio\",
        },
        txtCorreo: {
            required: \"El correo es obligatorio\",
        },
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
