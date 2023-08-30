<?php
echo "
$('#frmEditClient').validate({
    rules: {
        txtNombre: {
            required: true
        },
        txtDireccion: {
            required: false
        },
        txtTelefono: {
            required: false
        },
        txtCorreo: {
            required: false
        },
    },
    messages: {
        txtNombre: {
            required: \"El nombre es obligatorio\",
        },
        txtDireccion: {
            required: \"La dirección es obligatoria\",
        },
        txtTelefono: {
            required: \"El teléfono es obligatorio\",
        },
        txtCorreo: {
            required: \"El correo es obligatorio\",
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
