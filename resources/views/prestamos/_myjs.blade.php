<script>
 $('#btnBuscarCliente').click(function() {
     $('#addcliente').modal('show');
 });

 $('#btnCancelar').click(function() {
        $('#formSimulador')[0].reset();
        $('#valorCuota').empty().text('S/ 0.00');
        $('#valorInteres').empty().text('S/ 0.00');
        $('#montoTotal').empty().text('S/ 0.00');
        $('#cliente_id').val('');

 });

$('#btnSimular').click(function() {
    var idcliente = $('#cliente').val();
    var monto = parseFloat($('#monto').val());
    var interes = parseFloat($('#interes').val());
    var cuotas = parseInt($('#cuotas').val());
    var forma_pago = $('#forma_pago').val();
    var moneda = $('#moneda').val();
    var fecha_emision = $('#fecha_emision').val();

    if(!validarCampos()){
        return;
    }

    $.ajax({
        url   : "{{ route('prestamos.simular') }}",
        type  : "POST",
        data  : {
            _token        : "{{ csrf_token() }}",
            cliente       : idcliente, 
            monto         : monto,
            interes       : interes,
            cuotas        : cuotas,
            forma_pago    : forma_pago,
            moneda        : moneda,
            fecha_emision : fecha_emision
        },
        beforeSend: function() {
            $('#btnSimular').prop('disabled', true);
            $('#btnSimular').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculando...');
        },
        success: function(response) {
          
            $('#valorCuota').text("S/ " + response.valorCuota.toFixed(2));
            $('#valorInteres').text("S/ " + response.interesTotal.toFixed(2));
            $('#montoTotal').text("S/ " + response.montoTotal.toFixed(2));

        
            $('#btnSimular').prop('disabled', false);
            $('#btnSimular').html('Calcular');
        },
        error: function() {
            alert("Ocurrió un error al calcular el préstamo.");
            $('#btnSimular').prop('disabled', false);
            $('#btnSimular').html('Calcular');
        }
    });
});

// Confirmar préstamo → abre el modal con cuotas paginadas
$('body').on('click', '.btnConfirmar', function(){
    if(!validarCampos()){
        return;
    }

    var idcliente = $('#cliente').val();
    var monto = parseFloat($('#monto').val());
    var interes = parseFloat($('#interes').val());
    var cuotas = parseInt($('#cuotas').val());
    var forma_pago = $('#forma_pago').val();
    var moneda = $('#moneda').val();
    var fecha_emision = $('#fecha_emision').val();

    $.ajax({
        url   : "{{ route('prestamos.store') }}",
        type  : "POST",
        data  : {
            _token        : "{{ csrf_token() }}",
            cliente       : idcliente, 
            monto         : monto,
            interes       : interes,
            cuotas        : cuotas,
            forma_pago    : forma_pago,
            moneda        : moneda,
            fecha_emision : fecha_emision,
            page          : 1 // primera página
        },
        beforeSend: function() {
            $('.btnConfirmar').prop('disabled', true);
            $('.btnConfirmar').html('<span class="spinner-border spinner-border-sm"></span> Cargando...');
        },
        success: function(response) {
            $('.btnConfirmar').prop('disabled', false).html('Ver Cuotas');
            
            if(response.status === 'success'){
                $('#cuotasDetalleBody').html(response.data.cuotasDetalle);
                $('#paginacion').html(response.data.paginacion);
                $('#detalleCuotasModal').modal('show');
            } else {
                toast_info('Error al calcular el préstamo', 'danger', 'bi bi-x-circle');
            }
        },
        error: function() {
            $('.btnConfirmar').prop('disabled', false).html('Ver Cuotas');
            toast_info('Ocurrió un error en la solicitud', 'danger', 'bi bi-x-circle');
        }
    });
});


// Función global para cambiar de página
function cargarPaginaCuotas(page){
    var idcliente = $('#cliente').val();
    var monto = parseFloat($('#monto').val());
    var interes = parseFloat($('#interes').val());
    var cuotas = parseInt($('#cuotas').val());
    var forma_pago = $('#forma_pago').val();
    var moneda = $('#moneda').val();
    var fecha_emision = $('#fecha_emision').val();

    $.ajax({
        url   : "{{ route('prestamos.store') }}",
        type  : "POST",
        data  : {
            _token        : "{{ csrf_token() }}",
            cliente       : idcliente, 
            monto         : monto,
            interes       : interes,
            cuotas        : cuotas,
            forma_pago    : forma_pago,
            moneda        : moneda,
            fecha_emision : fecha_emision,
            page          : page
        },
        success: function(response) {
            if(response.status === 'success'){
                $('#cuotasDetalleBody').html(response.data.cuotasDetalle);
                $('#paginacion').html(response.data.paginacion);
            }
        }
    });
}

$('#btnGuardarPrestamo').click(function(){
    var idcliente = $('#cliente_id').val();
    var monto = parseFloat($('#monto').val());
    var interes = parseFloat($('#interes').val());
    var cuotas = parseInt($('#cuotas').val());
    var forma_pago = $('#forma_pago').val();
    var moneda = $('#moneda').val();
    var fecha_emision = $('#fecha_emision').val();
    if(!validarCampos()){
        return;
    }
    $.ajax({
        url   : "{{ route('prestamos.guardar') }}",
        type  : "POST",
        data  : {
            _token        : "{{ csrf_token() }}",
            cliente       : idcliente, 
            monto         : monto,
            interes       : interes,
            cuotas        : cuotas,
            forma_pago    : forma_pago,
            moneda        : moneda,
            fecha_emision : fecha_emision
        },
        beforeSend: function() {
            $('#btnGuardarPrestamo').prop('disabled', true);
            $('#btnGuardarPrestamo').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...');
        },
        success: function(response) {
            if(response.status === 'success'){
                toast_info('Préstamo guardado con éxito', 'success', 'bi bi-check-circle');
                setTimeout(function(){
                    window.location.href = "{{ route('prestamos.detalle') }}";
                }, 1500);
            } else {
                toast_info('Error al guardar el préstamo', 'danger', 'bi bi-x-circle');
            }
            $('#btnGuardarPrestamo').prop('disabled', false);
            $('#btnGuardarPrestamo').html('Guardar Préstamo');
        },
        error: function() {
            toast_info('Ocurrió un error en la solicitud', 'danger', 'bi bi-x-circle');
            $('#btnGuardarPrestamo').prop('disabled', false);
            $('#btnGuardarPrestamo').html('Guardar Préstamo');
        }
    });
});

function validarCampos(){
    var campos = [
        { id: '#cliente',      valor: $('#cliente').val() },
        { id: '#monto',        valor: $('#monto').val() },
        { id: '#interes',      valor: $('#interes').val() },
        { id: '#cuotas',       valor: $('#cuotas').val() },
        { id: '#forma_pago',   valor: $('#forma_pago').val() },
        { id: '#moneda',       valor: $('#moneda').val() },
        { id: '#fecha_emision', valor:$('#fecha_emision').val() },
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