<script>
    function load_datatable() {
        let datatable = $('#listar_prestamos').DataTable({
            serverSide  : true,
            paging      : true,
            searching   : true,
            destroy     : true,
            responsive  : true,
            ordering    : false,
            autoWidth   : false,
            lengthMenu  : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            language: {
                decimal: "",
                emptyTable: "No hay información",
                info: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
                infoEmpty: "Mostrando 0 a 0 de 0 Registros",
                infoFiltered: "(Filtrado de _MAX_ total Registros)",
                lengthMenu: "Mostrar _MENU_ Registros",
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
            ajax: "{{ route('prestamos.listarDetalle') }}",
            columns: [
                { data: 'nro_prestamos', className: 'text-center' },
                { data: 'cliente', className: 'text-left' },
                { data: 'monto', className: 'text-center' },
                { data: 'interes', className: 'text-center' },
                { data: 'cuotas', className: 'text-center' },
                { data: 'forma_pago', className: 'text-center' },
                { data: 'usuario', className: 'text-center' },
                { data: 'fecha_emision', className: 'text-center' },
                { data: 'estado', className: 'text-center' },
                { data: 'acciones', className: 'text-center' }
              

            ]
        });
    }

    function load_cuotas(id) {
    let datatable = $('#listar_cuotas').DataTable({
        serverSide  : true,
        paging      : true,
        searching   : true,
        destroy     : true,
        responsive  : true,
        ordering    : false,
        autoWidth   : false,
        lengthMenu  : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        language: {
            decimal: "",
            emptyTable: "No hay información",
            info: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
            infoEmpty: "Mostrando 0 a 0 de 0 Registros",
            infoFiltered: "(Filtrado de _MAX_ total Registros)",
            lengthMenu: "Mostrar _MENU_ Registros",
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
        ajax: {
            url: "{{ route('prestamos.pagarCuotas') }}",
            type: "POST", 
            data: function (d) {
                d._token = '{{ csrf_token() }}';
                d.id = id;
            },
        },
        columns: [
            { data: 'nro_cuota', className: 'text-center' },
            { data: 'fecha', className: 'text-center' },
            { data: 'monto', className: 'text-center' },
            { data: 'estado', className: 'text-center' },
            { data: 'acciones', className: 'text-center' },

            
        ]
    });
}


    $(document).ready(function() {
        load_datatable();
    });


</script>
