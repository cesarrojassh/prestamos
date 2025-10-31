<script>

$('body').on('click', '.add_modulo', function(){
    $('#form_modulo')[0].reset();
    $('#modulo_ruta').val('#')
    $('#addmodulo').modal('show');
})

$('body').on('click', '.btn_save', function(){
     if (!validarCampos()) return;
     let datos =  $('#form_modulo').serialize();
     $.ajax({

          url       : "{{ route('modulos.store')}}",
          method    : 'POST',
          data      : datos + '&_token={{ csrf_token() }}',
          beforeSend: function() {
                $('.btn_save .text-login').text('Guardando...');
                $('.btn_save').prop('disabled', true);
            },
          success: function(response){
             if(!response.status){
                 $('#form_modulo')[0].reset();
                 Swal.fire({
                    icon: 'error',
                    title: 'Error al registrar el modulo',
                    text: response.msg
                });
                return;
             }
             Swal.fire({
                icon: 'success',
                title: 'Modulo registrado con éxito',
                timer: 2000,
                showConfirmButton: false
            });
           
              $('#form_modulo')[0].reset();
              $('#addmodulo').modal('hide');
              load_datatable();
          }

     })
})

$('body').on('click', '.btn_detail', function(){

    var id = $(this).data('id')
    $.ajax({

        url     : "{{ route('modulos.details')}}",
        method  : 'POST',
        data    : {id:id, '_token': "{{ csrf_token() }}" },
        dataType: 'json',
        success : function(response){
            if(!response.status){
                 Swal.fire('Error', response.msg, 'error');
                return; 
            }
            $('#editmodulo_nombre').val(response.modulo.modulo_nombre);
            $('#editmodulo_ruta').val(response.modulo.ruta);
            $('#editmodulo_icono').val(response.modulo.icono);
            $('#editmodulo_orden').val(response.modulo.orden);
            $()
            var count = response.modulos.length;
            var html = '';
             for (let i = 0; i < count; i++) {
                    let modulos = response.modulos[i];
                    if( modulos.modulo_padre == response.modulo.modulo_padre){
                        html += `<option value="${modulos.modulo_padre}"selected>${modulos.modulo_nombre}</option>`;
                    }
                    else{
                        html += `<option value="${modulos.modulo_padre}">${modulos.modulo_nombre}</option>`;
                    }
            }
            $('.btn_update').val(response.modulo.id);
            $('#editmodulo_padre').html(html);
            $('#editmodulo').modal('show');
          
        }   
    })

})

$('body').on('click', '.btn_update', function(){

    var id      = $(this).val();
    var datos   = $('#form_modulo_edit').serialize();
    $.ajax({

        url     : "{{ route('modulos.update')}}",
        method  : 'post',
        data    : datos + '&id=' + id + '&_token={{ csrf_token() }}',
        dataType: 'json',
        success : function(response){
            if(!response.status){
                Swal.fire({
                    icon: 'error',
                    title: 'Error al actualizar al Modulo',
                    text: response.msg
                });
                return; 
            }
            Swal.fire({
                icon: 'success',
                title: 'Modulo actualizado con éxito',
                timer: 2000,
                showConfirmButton: false
            });
            $('#editmodulo').modal('hide');
            load_datatable();
        }
    })
})

$('body').on('click', '.btn-delete', function(){
    var id = $(this).data('id');
     Swal.fire({
        text: "¿Deseas desactivar este Modulo?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, Desactivar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
        $.ajax({
                url     :  "{{ route('modulos.delete')}}",
                method  : 'post',
                data    : {id:id, '_token': "{{ csrf_token() }}" },
                dataType: 'json',
                success : function(response){
                    if(!response.status){
                    Swal.fire({
                            icon: 'warning',
                            title: 'Error al procesar',
                            text : response.msg,
                        }); 
                        return;   
                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'Modulo desactivado con éxito',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    load_datatable();
                }
            })
        }

    })

})


$('body').on('click', '.btn-activar', function(){
    var id = $(this).data('id');
     Swal.fire({
        text: "¿Deseas activar este Modulo?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, Activar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
        $.ajax({
                url     :  "{{ route('modulos.activar')}}",
                method  : 'post',
                data    : {id:id, '_token': "{{ csrf_token() }}" },
                dataType: 'json',
                success : function(response){
                    if(!response.status){
                    Swal.fire({
                            icon: 'warning',
                            title: 'Error al procesar',
                            text : response.msg,
                        }); 
                        return;   
                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'Modulo activado con éxito',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    load_datatable();
                }
            })
        }

    })

})



 function validarCampos(){
            var campos = [
                { id: '#modulo_nombre',      valor: $('#modulo_nombre').val() },
                { id: '#modulo_padre',       valor: $('#modulo_padre').val() },
                { id: '#modulo_ruta',        valor: $('#modulo_ruta').val() },
                { id: '#modulo_icono',       valor: $('#modulo_icono').val() },
                { id: '#modulo_orden',       valor: $('#modulo_orden').val() },
            ];
            for (var i = 0; i < campos.length; i++) {
                if (campos[i].valor === '') {
                    $(campos[i].id).focus(); 
                    var msg  = 'Todos los campos tienen que estas llenados';
                    var type = 'info';
                    var icon = 'bi bi-exclamation-triangle'
                    toast_info(msg, type, icon);
                    return false; 
                }
            }
            return true; 
        }
    
$(document).ready(function() {
     $('body').on('change', '#modulo_padre', function() {
       var selectedValue = $(this).val();
       var rutaInput = $('#modulo_ruta');
     if (selectedValue == "0") {
          
            rutaInput.val('#'); 
            rutaInput.prop('readonly', true)
        } else {
          
            rutaInput.val(''); 
            rutaInput.prop('readonly', false); 
        }
    });
     $('#addmodulo').on('hidden.bs.modal', function () {
        $('#modulo_ruta').prop('readonly', false);
    });

});

</script>