<script>
$('.add_perfiles').on('click', function(){
        
    $('#addperfiles').modal('show');
})

$('body').on('click', '.btn_save', function(){
       var nombre = $('#descripcion').val();
       if(nombre == ''){
            var msg  = 'Todos los campos tienen que estas llenados';
            var type = 'info';
            var icon = 'bi bi-exclamation-triangle'
            toast_info(msg, type, icon);
       }
       $.ajax({
         
           url      : "{{ route('perfiles.store') }}",
           method   : 'post',
           data     : {nombre:nombre,
                     _token: '{{ csrf_token() }}'
           },
           dataType : 'json',
           success  : function(response){
            if(!response.status){
                  Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.msg
                });
                return;
            }
          
            var msg  = 'Perfil registrada con exito';
            var type = 'success';
            var icon = 'bi bi-check-circle'
            toast_info(msg, type, icon);
            $('#addperfiles').modal('hide');
            load_datatable();
            $('#descripcion').val('');
            $('#form_perfiles')[0].reset();
           }

       })
})

$('body').on('click', '.btn_detail', function(){
    var id = $(this).data('id');
    $.ajax({
        url       : "{{ route('perfiles.details') }}",
        method    : 'post',
        data      : {id:id,   _token: '{{ csrf_token() }}'},
        dataType  : 'json',
        success   : function(response){
            if(!response.status){
              Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.msg
                });
                return;  
            }
            $('#edit_descripcion').val(response.data.nombre);
            $('.btn_update').val(response.data.id);
            $('#editperfiles').modal('show');
        }
    })
})

$('body').on('click', '.btn_update', function(){
    
    var nombre = $('#edit_descripcion').val();
    var id     = $(this).val();
    if(nombre == ''){
         var msg  = 'Todos los campos tienen que estas llenados';
         var type = 'info';
         var icon = 'bi bi-exclamation-triangle'
         toast_info(msg, type, icon);
    }
    $.ajax({
        url    : "{{ route('perfiles.update')}}",
        method : 'post',
        data   : {nombre:nombre, id:id,  _token: '{{ csrf_token() }}'},
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
            $('#editperfiles').modal('hide');
            var msg  = 'Perfil actualizado con exito';
            var type = 'success';
            var icon = 'bi bi-check-circle'
            toast_info(msg, type, icon);
            load_datatable();
            nombre.val('');
            
        }
    })

})

$('body').on('click', '.btn-delete', function(){
    var id = $(this).data('id');
    Swal.fire({
        title: '¿Está seguro de desactivar el Perfil',
        text: "¡Vamos!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, Desactivar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('perfiles.delete') }}",
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
                    var msg = 'Perfil desactivado con éxito';
                    var type = 'success';
                    var icon = 'bi bi-check-circle';
                    toast_info(msg, type, icon);
                    load_datatable();
                }
            });
        }
    });
})


$('body').on('click', '.btn-activar', function(){
    var id = $(this).data('id');
    Swal.fire({
        title: '¿Está seguro de activar el Perfil',
        text: "¡Vamos!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, Activar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('perfiles.activar') }}",
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
                    var msg = 'Perfil activado con éxito';
                    var type = 'success';
                    var icon = 'bi bi-check-circle';
                    toast_info(msg, type, icon);
                    load_datatable();
                }
            });
        }
    });
})
 
</script>