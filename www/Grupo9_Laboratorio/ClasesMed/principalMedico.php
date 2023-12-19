<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="">

  <title> CLINICA MEDICA </title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />

</head>
	
<body class="sub_page">

<div class="hero_area">

  <div class="hero_bg_box">
	<img src="../../images/hero-bg.png" alt="">
  </div>

  <!-- header section strats -->


<header >
        <!-- Navbar -->
        
        <?php

            echo '<div class="header_section">
                    <div class="page-header" style="display: flex; justify-content: space-between;">
                        <h2>BIENVENIDO</h2>
                        <h1 class="navbar-brand">HOLA: <span>MEDICO</span></h1>
                        <button class="btn btn-dark"><a class="text-black navbar-brand" href="../Sesion/cerrar.php">CERRAR SESION</a></button>
                    </div>
                </div>';
        ?>
    </header>

    <body>
        <?php
       $html = '
       <div class="card">
                        <div class="card-header">
                        <table>
                        <tr>
                          <td>
                            <ul class="nav nav-tabs justify-content-center" role="tablist">
                            
                              <li class="nav-item">
                              <a class="nav-link " data-toggle="tab" href="#consultas" role="tab">
                                  <i></i> CONSULTAS
                                </a>
                              </li>
                             
                              <li class="nav-item">
                              <a class="nav-link " data-toggle="tab" href="#recetas" role="tab">
                                  <i></i> RECETAS
                                </a>
                              </li>
                              
                            </ul>
                          </td>
                        </tr>
                      </table>
                        </div>
                        <div class="card-body">
                            <!-- Tab panes -->
                            <div class="tab-content text-center">

                                <div class="tab-pane" id="consultas" role="tabpanel">
                                <iframe src="Consultas/consultas.php" style="width: 95%; height: 890px; border: none;"></iframe>
                            </div>
                            
                            
                        <div class="tab-pane" id="recetas" role="tabpanel">
                        <iframe src="Recetas1/recetas.php" style="width: 95%; height: 890px; border: none;"></iframe>
                    </div>
                </div>
            </div>
        </div>
';
       echo $html;
   
       ?>
   
    <!-- Script para manejar los tabs -->
    <script>
        $(document).ready(function () {
            $(".nav-tabs a").click(function () {
                $(this).tab("show");
            });
        });
    </script>
    </body>
    </footer>
<!-- footer section -->

<!-- jQery -->
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
<!-- popper js -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<!-- bootstrap js -->
<script type="text/javascript" src="js/bootstrap.js"></script>
<!-- owl slider -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
</script>
<!-- custom js -->
<script type="text/javascript" src="js/custom.js"></script>
<!-- Google Map -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
</script>
<!-- End Google Map -->
</body>

</html>

