<script>
        $(document).ready(function(){
            $('#addcliente').modal({
                backdrop: 'static', 
                keyboard: false     
            });

              
        });

      $('body').on('click', '.add_cliente', function() {
    
        $('#addclienteLabel').text('Registrar Cliente');
        $('.text-login').text('Guardar');
        $('#cli_numdoc').val('');
        $('#cli_nom').val('');
        $('#cli_direcion').val('');
        $('#cli_telefono').val('');

        $('#cli_tipodoc').val('0');
        const btn = $('.btn_update, .btn_save'); 
        btn.removeClass('btn_update btn-primary') 
        .addClass('btn_save btn-success');    
        btn.find('i').removeClass().addClass('bi bi-check-circle me-1');
        $('#addcliente').modal('show');
    });


       $('body').on('click', '.btn_save', function(e) {
            e.preventDefault();

            if (!validarCampos()) return;

            let datos = $('#form_cliente').serialize();

            $.ajax({
                url: "{{ route('clientes.store') }}",
                type: "POST",
                data: datos + '&_token={{ csrf_token() }}',
                beforeSend: function() {
                    $('.btn_save .text-login').text('Guardando...');
                    $('.btn_save').prop('disabled', true);
                },
                success: function(response) {
                    if(!response.status){
                        $('#form_cliente')[0].reset();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al registrar cliente',
                            text: response.msg
                        });
                        return;
                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'Cliente registrado con éxito',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $('#addcliente').modal('hide');
                    $('#form_cliente')[0].reset();
                    load_datatable();
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ocurrió un error',
                        text: 'No se pudo guardar el cliente. Intenta nuevamente.'
                    });
                },
                complete: function() {
                    $('.btn_save .text-login').text('Guardar');
                    $('.btn_save').prop('disabled', false);
                }
            });
        });

       $('body').on('click', '.btn-reniec', function(event){
                event.preventDefault();
                var dni = $('#cli_numdoc').val();
                if (dni === '' || (dni.length !== 8 && dni.length !== 11)) {
                    toast_info('Introduzca un Nro Documento válido', 'info', 'bi bi-exclamation-triangle');
                    $('#cli_numdoc').focus();
                    return;
                }
                $('.spinner-border').removeClass('d-none');
                $('.btn-reniec').prop('disabled', true);
                $('.text-login_reniec').text('Buscando...');
                $.ajax({
                url     : "{{ route('clientes.reniec') }}",
                method  : 'POST',
                data    : { dni: dni, '_token': "{{ csrf_token() }}" },
                dataType: 'json',
                success : function(response) {
                    $('.spinner-border').addClass('d-none');
                    $('.btn-reniec').prop('disabled', false);
                    $('.text-login_reniec').text('Reniec');
                    if (!response.status) {
                        toast_info(response.msg, response.type, response.icon);
                        return;
                    }
                    $('#cli_nom').val((response.nombres ?? '') + " " + (response.apellidos ?? ''));
                    $('#cli_direcion').val(response.direccion);
                    $('#cli_telefono').val(response.telefono);
                    if(dni.length == 8){
                        $('#cli_tipodoc').val('DNI')
                    }
                    else{
                        $('#cli_tipodoc').val('RUC')
                    }
                    
                },
                error: function() {
                    $('.spinner-border').addClass('d-none');
                    $('.btnBuscarDoc').prop('disabled', false);
                    $('.text-login_reniec').text('Buscar');
                    toast_info('Error en la conexión. Intente nuevamente.', 'error', 'bi bi-x-circle');
                }
            });
        });
         
        $('body').on('click', '.btn-desactivar', function(){
            event.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
                title: '¿Está seguro de eliminar el cliente?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('clientes.delete') }}",
                        method: 'POST',
                        dataType: 'json',
                        data: { id:id, '_token': "{{ csrf_token() }}" },
                        success: function(response) {
                            if (!response.status) {
                                Swal.fire('Error', response.msg, 'error');
                                return;
                            }
                            Swal.fire({
                                icon: 'success',
                                title: 'Cliente eliminado con éxito',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            load_datatable();
                        },
                        error: function() {
                            Swal.fire('Error', 'No se pudo eliminar el cliente. Intente nuevamente.', 'error');
                        }
                    });
                }
            });

        })
         $('body').on('click', '.btn-activar', function(){
            event.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
                title: '¿Está seguro de activar el cliente?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'rgba(51, 221, 94, 1)',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, activar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('clientes.activar') }}",
                        method: 'POST',
                        dataType: 'json',
                        data: { id:id, '_token': "{{ csrf_token() }}" },
                        success: function(response) {
                            if (!response.status) {
                                Swal.fire('Error', response.msg, 'error');
                                return;
                            }
                            Swal.fire({
                                icon: 'success',
                                title: 'Cliente activado con éxito',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            load_datatable();
                        },
                        error: function() {
                            Swal.fire('Error', 'No se pudo eliminar el cliente. Intente nuevamente.', 'error');
                        }
                    });
                }
            });

        })

        //Editar 

       $('body').on('click', '.btn-detail', function(event){
        event.preventDefault();
        var id = $(this).data('id');

        $.ajax({
            url: "{{ route('clientes.edit') }}",
            method: 'GET',
            dataType: 'json',
            data: { id:id },
            success: function(response) {
                if (!response.status) {
                    Swal.fire('Error', response.msg, 'error');
                    return;
                }

                let data = response.data;

                $('#addclienteLabel').text('Editar Cliente');
                $('.text-login').text('Actualizar');
                $('#cli_numdoc').val(data.numdoc);
                $('#cli_nom').val(data.nom);
                $('#cli_direcion').val(data.direcion);
                $('#cli_telefono').val(data.telefono);
                $('#cli_tipodoc').val(data.tipodoc);
                const btn = $('.btn_save');
                btn.removeClass('btn_save');
                btn.addClass('btn_update');
                btn.find('i').removeClass().addClass('bi bi-pencil-square me-1');
                btn.val(data.id); 
                $('#addcliente').modal('show');
            },
            error: function() {
                Swal.fire('Error', 'No se pudo obtener los datos del cliente. Intente nuevamente.', 'error');
            }
        });
    });


  $('body').on('click', '.btn_update', function(e) {
    e.preventDefault();
    var id = $(this).val();

    if (!validarCampos()) return;

    let datos = $('#form_cliente').serialize();

    $.ajax({
        url: "{{ route('clientes.update') }}",
        type: "PUT",
        data: datos + '&id=' + id + '&_token={{ csrf_token() }}',
        beforeSend: function() {
            $('.btn_update .text-login').text('Actualizando...');
            $('.btn_update').prop('disabled', true);
        },
        success: function(response) {
            if (!response.status) {
                $('#form_cliente')[0].reset();
                Swal.fire({
                    icon: 'error',
                    title: 'Error al actualizar cliente',
                    text: response.msg
                });
                return;
            }

            Swal.fire({
                icon: 'success',
                title: 'Cliente actualizado con éxito',
                timer: 2000,
                showConfirmButton: false
            });

            $('#addcliente').modal('hide');
            $('#form_cliente')[0].reset();
            load_datatable();
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Ocurrió un error',
                text: 'No se pudo actualizar el cliente. Intenta nuevamente.'
            });
        },
        complete: function() {
            $('.btn_update .text-login').text('Actualizar');
            $('.btn_update').prop('disabled', false);
        }
    });
});




        function validarCampos(){
            var campos = [
                { id: '#cli_numdoc',        valor: $('#cli_numdoc').val() },
                { id: '#cli_tipodoc',       valor: $('#cli_tipodoc').val() },
                { id: '#cli_nom',           valor: $('#cli_nom').val() },
                { id: '#cli_direcion',      valor: $('#cli_direcion').val() },
                { id: '#cli_telefono',      valor: $('#cli_telefono').val() },
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