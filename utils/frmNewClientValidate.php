<?php
echo "$('#frmNewClient').validate({
        rules: {
            txtNombre: {
                required: true
            },
            txtDireccion: {
                required: true
            },
            txtTelefono: {
                required: true
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
