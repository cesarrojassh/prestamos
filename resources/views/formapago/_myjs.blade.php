<script>
$('.add_forma').on('click', function() {
    $('#form_forma_pago')[0].reset();
    $('#addformapago').modal('show');
});

$('body').on('click', '.btn_save', function(){
    var nombre = $('#forma_pago_nombre').val().trim();
    if(nombre === ''){
        var msg  = 'Todos los campos tienen que estas llenados';
        var type = 'info';
        var icon = 'bi bi-exclamation-triangle'
        toast_info(msg, type, icon);
    }
    $.ajax({
        url: "{{ route('formapagos.store') }}",
        method: 'POST',
        data: {
            forma_pago_nombre: nombre,
            _token: '{{ csrf_token() }}'
        }, 
        dataType: 'json',
        success: function(response){
            if(!response.status){
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.msg
                });
                return;
            }
            $('#addformapago').modal('hide');
            var msg  = 'Forma de pago registrada con exito';
            var type = 'success';
            var icon = 'bi bi-check-circle'
            toast_info(msg, type, icon);
            load_datatable();
            $('#form_forma_pago')[0].reset();
    }
      
    });
    
})

$('body').on('click', '.btn-delete', function(){
    var id = $(this).data('id');
    Swal.fire({
        title: '¿Está seguro de eliminar esta forma de pago?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('formaspago.delete') }}",
                method: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                    if (!response.status) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.msg
                        });
                        return;
                    }
                    var msg = 'Forma de pago eliminada con éxito';
                    var type = 'success';
                    var icon = 'bi bi-check-circle';
                    toast_info(msg, type, icon);
                    load_datatable();
                }
            });
        }
    });
})

$('body').on('click', '.btn_detail', function(){
    
    var id = $(this).data('id');
    $.ajax({
        url: "{{ route('formaspago.edit') }}",
        method: 'POST',
        data: {
            id: id,
            _token: '{{ csrf_token() }}'
        },
        dataType: 'json',
        success: function(response) {
            if (!response.status) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.msg
                });
                return;
            }
            $('#editar_nombre_forma').val(response.data.nombre);
            $('.btn_edit').val(response.data.id);
            $('#editformapago').modal('show');
        }
    });
})

$('body').on('click', '.btn_edit', function(){
    var id = $(this).val();
    var nombre = $('#editar_nombre_forma').val().trim();
    if(nombre === ''){
        var msg  = 'Todos los campos tienen que estas llenados';
        var type = 'info';
        var icon = 'bi bi-exclamation-triangle'
        toast_info(msg, type, icon);
        return;
    }
    $.ajax({
        url: "{{ route('formaspago.update') }}",
        method: 'POST',
        data: {
            id: id,
            editar_nombre_forma: nombre,
            _token: '{{ csrf_token() }}'
        },
        dataType: 'json',
        success: function(response) {
            if (!response.status) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.msg
                });
                return;
            }
            $('#editformapago').modal('hide');
            var msg = 'Forma de pago actualizada con éxito';
            var type = 'success';
            var icon = 'bi bi-check-circle';
            toast_info(msg, type, icon);
            load_datatable();
        }
    });
})



</script>