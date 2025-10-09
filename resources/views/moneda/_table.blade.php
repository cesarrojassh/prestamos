<script>
    function load_datatable() {
        let datatable = $('#lista_monedas').DataTable({
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
            ajax: "{{ route('monedas.listar') }}",
            columns: [
                { data: 'acciones', className: 'text-center' },
                { data: 'nom', className: 'text-left' },
                { data: 'numdoc', className: 'text-left' },
                { data: 'telefono', className: 'text-left' },
                { data: 'direcion', className: 'text-left' },
                { data: 'estado', className: 'text-center' },

            ]
        });
    }

    $(document).ready(function() {
        load_datatable();
    });
</script>
