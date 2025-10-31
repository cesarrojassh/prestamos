<script>

    $('body').on('click', '.btn_save', function(e) {
       e.preventDefault(); 
       var formData = $('#modulos').serialize();
       var idperfil = $('#idperfil').val();
       var url = "{{ route('modulos.asignar')}}";
       var method = 'POST'
       var $button = $(this).find('.btn_save'); 
       $button.prop('disabled', true).text('Guardando...');
        $.ajax({
                url: url,
                method: method,
                data: formData + '&idperfil=' + idperfil,
                dataType: 'json', 
                success: function(response) {
                    if (response.success) {
                    
                        alert(response.mensaje); 
                    } else {
                     
                        alert('Error: ' + response.mensaje);
                    }
                },
            });
        });


</script>