<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 4 admin, bootstrap 4, css3 dashboard, bootstrap 4 dashboard, Ample lite admin bootstrap 4 dashboard, frontend, responsive bootstrap 4 admin template, Ample admin lite dashboard bootstrap 4 dashboard template">
    <meta name="description" content="Ample Admin Lite is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    <title>Hospital São Miguel</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favico.png">
    <!-- Custom CSS -->
    <link href="plugins/select2/css/select2.min.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <?php
        session_start();
        if( isset($_SESSION['usuario']['id']) ) {
            echo "<script>window.location='index.php'</script>";
        }
    ?>

    <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="plugins/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="plugins/bower_components/popper.js/dist/umd/popper.min.js"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="js/app-style-switcher.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <script src="plugins/select2/js/select2.min.js"></script>
    <script src="js/custom.js"></script>

    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:#d7dde2">
            <div class="auth-box">
                <div id="loginform">
                    <div class="logo">
                    <h5 class="font-medium mb-2 mt-3">
                        Agradecemos por realizar o seu pedido!<br><br>
                        Prezado(a),<br><br>
                        Recebemos o seu pedido com sucesso! Nossa equipe está trabalhando para garantir que sua escolha seja preparada com o máximo cuidado e carinho.<br><br>
                        Se precisar ajustar algo ou tiver dúvidas, não hesite em entrar em contato com a nossa equipe. Estamos aqui para tornar sua experiência a mais tranquila possível.<br><br>
                        Atenciosamente,<br>
                        <strong>Equipe São Miguel</strong>
                    </h5>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>