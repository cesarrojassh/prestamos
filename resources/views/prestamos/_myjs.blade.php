<script>
 $('#btnBuscarCliente').click(function() {
     $('#addcliente').modal('show');
 });

 $('#btnCancelar').click(function() {
        $('#formSimulador')[0].reset();
        
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
            fecha_emision : fecha_emision
        },
        beforeSend: function() {
            $('.btnConfirmar').prop('disabled', true);
            $('.btnConfirmar').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...');
        },
        success: function(response) {
            if(!response.status){
                var msg  = 'Error al registrar el préstamo.';
                var type = 'danger';
                var icon = 'bi bi-check-circle'
                toast_info(msg, type, icon);
               
            }
            var msg  = response.message;
            var type = 'error';
            var icon = 'bi bi-x-circle'
            toast_info(msg, type, icon);
            $('.btnConfirmar').prop('disabled', false);
            $('.btnConfirmar').html('Confirmar préstamo');
            $('.cuotasDetalleBody').html(response.data.cuotasDetalle);
            $('#detalleCuotasModal').modal('show');
            
        },
        error: function() {
            alert("Ocurrió un error al registrar el préstamo.");
            $('.btnConfirmar').prop('disabled', false);
            $('.btnConfirmar').html('Confirmar préstamo');
        }
    });
})

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