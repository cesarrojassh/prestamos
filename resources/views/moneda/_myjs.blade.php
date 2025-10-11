<script>
$('.add_moneda').on('click', function() {
    $('#form_moneda')[0].reset();
    $('#addmoneda').modal('show');
});

$('.btn_save').on('click', function() {
    let nombre = $('#moneda_nombre').val().trim();
    if (nombre === '') {
        var msg  = 'Todos los campos tienen que estas llenados';
        var type = 'info';
        var icon = 'bi bi-exclamation-triangle'
        toast_info(msg, type, icon);
    }
    $.ajax({
        url: "{{ route('monedas.store') }}",
        method: 'POST',
        data: {
            moneda_nombre: nombre,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if(!response.status){
                $('#form_moneda')[0].reset();
                Swal.fire({
                    icon: 'error',
                    title: 'Error guardando la moneda',
                    text: response.msg
                });
                return;
            }
            Swal.fire({
                icon: 'success',
                title: 'Moneda guardada con éxito',
                timer: 2000,
                showConfirmButton: false
            });

            $('#addmoneda').modal('hide');
            $('#form_moneda')[0].reset();
            load_datatable();
            
        },
        error: function(xhr) {
            alert('Ocurrió un error al guardar la moneda.');
        }
    });
});

$('body').on('click', '.btn_detail', function() {
    let id = $(this).data('id');
    $.ajax({
        url   : "{{ route('monedas.edit') }}",
        method: 'POST',
        data  : {
            id: id,
            _token: '{{ csrf_token() }}'
        },  
        dataType: 'json',
        success : function(response){
            if(!response.status){
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.msg
                });
                return;
            }
            $('#editar_nombre').val(response.data.nombre);
            $('#editmoneda').modal('show');
            $('.btn_edit').val(response.data.id);
        },

    })
});

$('body').on('click', '.btn_edit', function() {
    let id     = $(this).val();
    let nombre = $('#editar_nombre').val().trim();
    if (nombre === '') {
        var msg  = 'Todos los campos tienen que estas llenados';
        var type = 'info';
        var icon = 'bi bi-exclamation-triangle'
        toast_info(msg, type, icon);
        return;
    }
    $.ajax({
        url: "{{ route('monedas.update') }}",
        method: 'PUT',
        data: {
            id: id,
            editar_nombre: nombre,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if(!response.status){
                Swal.fire({
                    icon: 'error',
                    title: 'Error actualizando la moneda',
                    text: response.msg
                });
                return;
            }
            Swal.fire({
                icon: 'success',
                title: 'Moneda actualizada con éxito',
                timer: 2000,
                showConfirmButton: false
            });

            $('#editmoneda').modal('hide');
            $('#form_moneda')[0].reset();
            load_datatable();
            
        },
        error: function(xhr) {
            alert('Ocurrió un error al actualizar la moneda.');
        }
    });
});

    $('body').on('click', '.btn-danger', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('monedas.destroy') }}",
                    type: 'POST',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if(!response.status){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error eliminando la moneda',
                                text: response.msg
                            });
                            return;
                        }
                        Swal.fire({
                            icon: 'success',
                            title: 'Moneda eliminada con éxito',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        load_datatable();
                    },
                    error: function(xhr) {
                        alert('Ocurrió un error al eliminar la moneda.');
                    }
                });
            }
        })
    });
</script>