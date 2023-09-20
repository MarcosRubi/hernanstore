<?php
echo "<script>
$(function() {
    $('#frmEditPrestamo').validate({
        rules: {
            txtValor: {
                required: true
            },
            txtNumCuotas: {
                required: true
            },
            txtInteres: {
                required: true
            }
        },
        messages: {
            txtValor: {
                required: \"El valor del préstamo es obligatorio\",
            },
            txtNumCuotas: {
                required: \"El número de cuotas es obligatorio\",
            },
            txtInteres: {
                required: \"El interés es obligatorio\",
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
    });
    document.querySelectorAll('.card-body')[1].childNodes[0].remove()

})
</script>";
