<?php 
include("includes/conn_admin.php");
?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <html lang="es">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <!-- Meta Viewport -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <title>SpringPlaza</title>
        <meta name="description" content="iMasideas">
        <!--Metas de fav iconos -->
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#f68a1f">
        <meta name="apple-mobile-web-app-title" content="SpringPlaza">
        <meta name="application-name" content="SpringPlaza">
        <meta name="theme-color" content="#ffffff">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.7.0/sweetalert2.min.css">
        <!--Validation CSS-->
        <link rel="stylesheet" href="js/validator/validationEngine.jquery.css" type="text/css"/>
        <!--SweetAlert CSS-->
        <link rel="stylesheet" type="text/css" href="js/sweetalert/sweetalert.css">
        <link rel="stylesheet" href="css/main.css?v=<?php echo rand(5, 15);?>">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>
        <div id="loader">
            <p>Subiendo Archivo</p>
            <div id="bar_blank">
                <div id="bar_color"></div>
            </div>
            <div id="status"></div>
        </div>

        <div class="container">

            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <center>
                        <form class="form-horizontal" id="form1">
                          <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                              <input type="text" class="validate[required, minSize[3]] form-control" id="nombre" name="nombre" placeholder="Nombre">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                              <input type="number" class="validate[required, custom[phone]] form-control" id="telefono" name="telefono" placeholder="Teléfono">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                              <input type="email" class="validate[required, custom[email]] form-control" id="email" name="email" placeholder="Correo Electrónico">
                            </div>
                          </div>
                          <div class="form-group">
                            
                            <div class="col-sm-8 col-sm-offset-2">
                              <input type="number" class="validate[required, minSize[6]] form-control" id="cedula" name="cedula" placeholder="Cédula de Ciudadanía">
                            </div>
                          </div>
                          
                          <div class="form-group"> 
                            <div class="col-sm-8 col-sm-offset-2">
                              <div class="checkbox">
                                <label><input type="checkbox" class="validate[required]" name="acepto" id="aceptar">He leído y acepto las políticas de privacidad, 
    tratamiento de información y datos personales para uso comercial</label>
                              </div>
                            </div>
                          </div>
                          <input type="hidden" value="8" name="s" />
                          <input type="hidden" value="registros" name="tabla" />
                          <div class="form-group"> 
                            <div class="col-sm-8 col-sm-offset-2">
                              <button type="submit" class="btn btn-reg btn-default">Registrarme</button>
                            </div>
                          </div>
                        </form>
                    </center>
                </div>
            </div>
        </div>
        

        <!-- scripts -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        

        <script src="js/vendor/bootstrap.min.js"></script>
        <!--Font Awesome-->
        <script src="https://use.fontawesome.com/8bf7c8c8dd.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.7.0/sweetalert2.min.js"></script>
        <!--Validation Engine-->
        <script src="js/validator/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/validator/languages/jquery.validationEngine-es.js" type="text/javascript" charset="utf-8"></script>
        <!--GreenSock-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/plugins/CSSPlugin.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/easing/EasePack.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
        <!--Fancybox-->
        <script type="text/javascript" src="js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
        <!--SweetAlert-->
        <script src="js/sweetalert/sweetalert.min.js"></script> 
        <!-- JS principal -->
        <script src="js/main.js?v=<?php echo rand(5, 15);?>"></script>
    </body>
</html>
