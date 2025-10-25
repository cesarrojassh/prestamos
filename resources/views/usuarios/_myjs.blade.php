<script>

$('body').on('click', '.add_usuario', function(){
    $('#form_usuario')[0].reset();
    $('#addusuarios').modal('show');
})

$('body').on('click', '.btn_save', function(e){
    e.preventDefault();
    if(!validarCampos()) return;
    let datos =  $('#form_usuario').serialize();
    $.ajax({
        url     : "{{ route('usuarios.store')}}",
        method  : 'POST',
        data: datos + '&_token={{ csrf_token() }}',
        beforeSend: function(){
            $('.btn_save .text-login').text('Guardando...');
            $('.btn_Save').prop('disable', true);
        },
        success: function(response){
            if(!response.status){
               Swal.fire({
                    icon : 'error',
                    title: 'Error al procesar',
                    text : response.msg,
                });
                $('.btn_save .text-login').text('Guardar');
                $('.btn_save').prop('disabled', false);
                $('#form_usuario')[0].reset();
                return;
            }
                Swal.fire({
                    icon: 'success',
                    title: 'Usuario registrado con éxito',
                    timer: 2000,
                    showConfirmButton: false
                });
                 $('#addusuarios').modal('hide');
                 $('#form_usuario')[0].reset();
                 $('.btn_save .text-login').text('Guardar');
                 $('.btn_save').prop('disabled', false);
        }
    })


})

$('body').on('click', '.btn_detail', function(){

    let id = $(this).data('id');
    $.ajax({
        url     : "{{ route('usuarios.details')}}",
        method  : 'POST',
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
            $('#edit_numdoc').val(response.data.dni);
            $('#edit_nom').val(response.data.nombres);
            $('#edit_usuario').val(response.data.usuario);
            $('#edit_password').val(response.data.password);
            $('.btn_update').val(response.data.id);
            var count = response.perfiles.length;
            var html = ''; 
            for (let i = 0; i < count; i++) {
                    let perfil = response.perfiles[i];
                    if(response.data.idperfil == perfil.id){
                        html += `<option value="${perfil.id}"selected>${perfil.nombre}</option>`;
                    }
                    else{
                        html += `<option value="${perfil.id}">${perfil.nombre}</option>`;
                    }
            }
            $('#editidperfil').html(html);
            $('#editusuarios').modal('show');
        }
    })
})

$('body').on('click', '.btn_update', function(){
    var id = $(this).val();
    let datos =  $('#form_usuario_edit').serialize();
    
    $.ajax({

        url     : "{{ route('usuarios.update') }}",
        method  : 'post',
        data    : datos + '&id=' + id + '&_token={{ csrf_token() }}',
        dataType: 'json',
        success : function(response){
            if(!response.status){
                 Swal.fire({
                    icon: 'error',
                    title: 'Error al actualizar al usuario',
                    text: response.msg
                });
                return; 
            }
            Swal.fire({
                icon: 'success',
                title: 'Usuario actualizado con éxito',
                timer: 2000,
                showConfirmButton: false
            });
            $('#editusuarios').modal('hide');
            $('#form_usuario_edit')[0].reset();
            load_datatable();

        }
    })
})


$('body').on('click', '.btn-delete', function(){
    var id = $(this).data('id');
     Swal.fire({
        text: "¿Deseas desactivar este Usuario?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, Desactivar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
        $.ajax({
                url     :  "{{ route('usuario.delete')}}",
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
                        title: 'Usuario desactivado con éxito',
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
        text: "¿Deseas activar este Usuario?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, Activar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
        $.ajax({
                url     :  "{{ route('usuario.activar')}}",
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
                        title: 'Usuario activado con éxito',
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
        { id: '#user_numdoc',    valor: $('#user_numdoc').val() },
        { id: '#user_nom',       valor: $('#user_nom').val() },
        { id: '#user_usuario',   valor: $('#user_usuario').val() },
        { id: '#cli_password',   valor: $('#cli_password').val() },
        { id: '#idperfil',       valor: $('#idperfil').val() },

       
    ];
    for (var i = 0; i < campos.length; i++) {
        if (campos[i].valor === '' || campos[i].valor === '0') {
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


</script> 