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
        }
    })
})
 
</script>