<!doctype html>
<html lang="en" data-bs-theme="blue-theme">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IGFACT</title>
  <!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png">
  <!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet">
	<script src="assets/js/pace.min.js"></script>

  <!--plugins-->
  <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/plugins/metismenu/metisMenu.min.css">
  <link rel="stylesheet" type="text/css" href="assets/plugins/metismenu/mm-vertical.css">

  


  <!--bootstrap css-->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
 <!--main css-->
  <link href="assets/css/bootstrap-extended.css" rel="stylesheet">
  <link href="sass/main.css" rel="stylesheet">
  <link href="sass/dark-theme.css" rel="stylesheet">
  <link href="sass/blue-theme.css" rel="stylesheet">
  <link href="sass/responsive.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/extra-icons.css">


  </head>

<body>


  <!--authentication-->

  <div class="section-authentication-cover">
    <div class="">
      <div class="row g-0">

        <div class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex border-end bg-transparent">

          <div class="card rounded-0 mb-0 border-0 shadow-none bg-transparent bg-none">
            <div class="card-body">
              <img src="assets/images/auth/reset-password1.png" class="img-fluid auth-img-cover-login" width="650" alt="">
            </div>
          </div>

        </div>

        <div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center border-top border-4 border-primary border-gradient-1">
          <div class="card rounded-0 m-3 mb-0 border-0 shadow-none bg-none">
            <div class="card-body p-sm-5">
              <img src="" class="mb-4" width="145" alt="">
              <h4 class="fw-bold">IGFACT {{ date('Y')}}</h4>
             
            <div class="form-body mt-4">
                <form class="row g-3">
                  <div class="col-12">
                    <label for="inputEmailAddress" class="form-label">Usuario</label>
                    <input type="email" class="form-control" id="users" placeholder="Admin">
                  </div>
                  <div class="col-12">
                    <label for="inputChoosePassword" class="form-label">Contraseña</label>
                    <div class="input-group" id="show_hide_password">
                      <input type="password" class="form-control" id="password" value="" placeholder="Contraseña"> 
                     </div>
                  </div>


                  <div class="col-12">
                    <div class="d-grid">
                    <button class="btn btn-primary btn_login" type="submit"> <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
						        <span class="text-login">Iniciar sesión</span>
                    </button>
                    </div>
                  </div>
                  
                </form>
              </div>

          </div>
          </div>
        </div>

      </div>
      <!--end row-->
    </div>
  </div>

  <!--authentication-->




  <!--plugins-->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/plugins/notifications/js/lobibox.min.js"></script>
  <script src="assets/plugins/notifications/js/notifications.min.js"></script>
  <script src="{{ asset('notificaciones.js')}}"></script>
  <link rel="stylesheet" href="assets/plugins/notifications/css/lobibox.min.css">


  <script>
    $(document).ready(function () {
      $("#show_hide_password a").on('click', function (event) {
        event.preventDefault();
        if ($('#show_hide_password input').attr("type") == "text") {
          $('#show_hide_password input').attr('type', 'password');
          $('#show_hide_password i').addClass("bi-eye-slash-fill");
          $('#show_hide_password i').removeClass("bi-eye-fill");
        } else if ($('#show_hide_password input').attr("type") == "password") {
          $('#show_hide_password input').attr('type', 'text');
          $('#show_hide_password i').removeClass("bi-eye-slash-fill");
          $('#show_hide_password i').addClass("bi-eye-fill");
        }
      });
    });

    $('body').on('click', '.btn_login', function(e){
        e.preventDefault();
        var users   = $('#users').val();
        var contra  = $('#password').val(); 
        $('.spinner-border').removeClass('d-none');
        $('.btn_login').prop('disabled', true);
        $('.text-login').text('Iniciando...')

        $.ajax({

            url     : "{{ route('login')}}",
            method  : 'POST',
            data    : { users:users, contra:contra, '_token'    : "{{ csrf_token() }}",},
            success : function(r)
            {
                if(!r.status)
                {
                   
                    $('.spinner-border').addClass('d-none');
                    $('.btn_login').prop('disabled', false);
                    $('.text-login').text('Iniciar sesión')
                    toast_info(r.msg, r.type, r.icon);
                    return;
                   
                }
                $('.spinner-border').addClass('d-none');
                $('.btn_login').prop('disabled', false);
                $('.text-login').text('Iniciar sesión');
                toast_info(r.msg, r.type, r.icon);
                setTimeout(function() {
                    window.location.href = "{{ route('admin') }}";     
                }, 1000);

            
            },
            dataType: 'json'
        })
        

       
    })
  </script>

</body>

</html>