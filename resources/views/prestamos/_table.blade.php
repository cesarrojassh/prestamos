<script>
function load_datatable() {
    let datatable = $('#lista_clientes_prestamos').DataTable({
        serverSide: true,
        paging: true,
        searching: true,
        destroy: true,
        responsive: true,
        ordering: false,
        autoWidth: false,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        language: {
            decimal: "",
            emptyTable: "No hay información",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty: "Mostrando 0 a 0 de 0 registros",
            infoFiltered: "(Filtrado de _MAX_ total registros)",
            lengthMenu: "Mostrar _MENU_ registros",
            loadingRecords: "Cargando...",
            processing: "Procesando...",
            search: "Buscar:",
            zeroRecords: "Sin resultados encontrados",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            }
        },
        ajax: "{{ route('prestamos.listar') }}",
        columns: [
            { data: 'id', className: 'text-center' },
            { data: 'nom', className: 'text-left' },
            { data: 'numdoc', className: 'text-left' },
            { data: 'estado_prestamos', className: 'text-center' }
        ]
    });

  
    $('#lista_clientes_prestamos tbody').on('click', 'tr', function() {
        if ($(this).hasClass('select_tr')) {
            $(this).removeClass('select_tr');
        } else {
            datatable.$('tr.select_tr').removeClass('select_tr');
            $(this).addClass('select_tr');
        }
    });

    
    $('#lista_clientes_prestamos tbody').on('dblclick', 'tr', function() {
        let data = datatable.row(this).data();
        if (data) {
            if(data.estado_prestamo == 1) {
                toast_info('El cliente seleccionado ya tiene un préstamo activo.', 'warning', 'bi bi-exclamation-triangle');
                return;
            }
        
            $('#cliente_id').val(data.id);
            $('#cliente').val(data.nom);

         
            $('#addcliente').modal('hide');
        }
    });
}

$(document).ready(function() {
    load_datatable();
});
</script>
