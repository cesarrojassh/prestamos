<script>

    function verDetalle(id) {
        $.ajax({
            url     : "{{ route('prestamos.datos') }}",
            method  : 'POST',
            data    : {
                _token  : '{{ csrf_token() }}',
                id      : id
            },
            dataType: 'json',
            success : function(r) {
                if(!r.status) {
                    var msg  = 'No se pudo obtener los datos del préstamo.';
                    var type = 'info';
                    var icon = 'bi bi-exclamation-triangle'
                    toast_info(msg, type, icon);
                    return;
                }
                $('#nro_prestamo').val(r.nro);
                $('#cliente').val(r.data.cliente);
                $('#monto_total').val('S/' + r.data.monto_total);
                $('#interes').val(r.data.interes);
                $('#cuotas').val(r.data.cuotas);
                $('#forma_pago').val(r.data.forma_pago);
                $('#fecha_emision').val(r.data.fecha_emision);
                $('#monto_cuota').val(r.data.monto_cuota);
                $('#cuotas_pagadas').val(r.data.cuotas_pagadas);
                $('#moneda').val(r.data.moneda);
                $('#usuario').val(r.data.usuario);
                $('#monto_cuota').val(r.cuota.monto_cuota);
                $('#cuotas_pagadas').val(r.cuotas_pagadas+ ' de ' + r.data.cuotas);
            },
        })
        $('#modal_detalle_prestamos').modal('show');
        load_cuotas(id);
    }

   function pagarCuota(id, idprestamo) {
    
    Swal.fire({
        text: "¿Deseas pagar esta cuota?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, pagar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('prestamos.efectuar_pago') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    idprestamo:idprestamo
                },
                dataType: "json",
                success: function (r) {
                    if(r.señal == 1){
                        Swal.fire({
                            title: "El prestamo pagada correctamente",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                     
                        load_cuotas(idprestamo);
                       
                    }
                    if (r.status) {
                        Swal.fire({
                            title: "Cuota pagada correctamente",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        load_cuotas(idprestamo)
                       
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: r.message || "No se pudo registrar el pago.",
                            icon: "error"
                        });
                    }
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        title: "Error de servidor",
                        text: "No se pudo conectar con el servidor.",
                        icon: "error"
                    });
                }
            });
        }
    });
}

function EnviarEmail(id){
   $.ajax({

        url     : "{{ route('prestamo.send')}}",
        method  : 'post',
        data    : {id:id,   _token: "{{ csrf_token() }}",},
        dataType: 'json',
        success : function(response){
            if(!response.status){
                Swal.fire({
                    title: "Error",
                    text: response.msg || "No se pudo registrar el pago.",
                    icon: "error"
                });
               
                return;
            }
             Swal.fire({
                title: "Correo enviado exitosamente",
                icon: "success",
                timer: 2000,
                showConfirmButton: false
            });
        }

   })
}

</script>