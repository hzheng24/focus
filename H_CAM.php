<!DOCTYPE html>
<html lang="en">
<?php
session_start();
?>

<head>
    <meta charset="utf-8">
    <title>Focus</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <!-- Favicon -->
    <link href="img/favi.ico" rel="icon">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-2 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark" href="">FAQs</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="">AYUDA</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="">SOPORTE</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark px-2" href="https://www.facebook.com">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-dark px-2" href="https://www.twitter.com">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-dark px-2" href="https://es.linkedin.com/">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-dark px-2" href="https://www.instagram.com/">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="text-dark pl-2" href="https://www.youtube.com/">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="./index.php" class="text-decoration-none drop-shadow">
                    <img src="./img/imgindex/logof2.png" style="width: 50%;">
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="buscar.php" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Buscar productos" name="query">
                        <div class="input-group-append">
                            <button type="submit" class="btn bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 col-6 text-right">
                <a href="./carrito.php" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge"></span>
                </a>
            </div>
        </div>
    </div>
    <div class="text-lg-right">
        <?php
        if (isset($_SESSION["usuario"])) {
        ?>
            <p style="font-style: italic; ">Hola, <?php echo $_SESSION["usuario"] ?>&nbsp;</p>
            <a href="perfil.php">&nbsp;Perfil&nbsp;</a>/
            <a href="cerrarsesion.php">&nbsp;Cerrar Sesión</a>
        <?php
        } else {
        ?>
            <a href="./iniciarsesion.php" class="nav-item nav-link">Iniciar Sesión</a>
            <a href="./registro.php" class="nav-item nav-link">Registrarse</a>
        <?php
        }
        ?>
    </div>
    <!-- Topbar End -->
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center text-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Camisas para Hombre</h1>
            <div class="d-inline-flex">
                <p class="m-0" style="font-style: italic;">Colección exclusiva de camisas para hombre! Diseños elegantes,
                    materiales de alta calidad y una confección impecable para cada ocasión. Renueva tu estilo con nuestras camisas
                    y marca la diferencia en tu día a día.</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
    <!-- Shop Start -->
    <?php
    include 'productos_functions.php';
    $categoria = 'CAMISA';
    $tipoPersona = 'H';
    $productos = obtenerProductosPorCategoriaYTipo($tipoPersona, $categoria);
    ?>
    <div class="col-md-12">
        <div class="row pb-3">
            <?php
            foreach ($productos as $producto) {
            ?>
                <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                    <form method="post" action="añadir_carrito.php">
                        <a class="text-decoration-none" href="#">
                            <h3 class="text-center"><?php echo $producto['nombre']; ?></h3>
                        </a>
                        <div class="card product-item border-0 mb-4">
                            <div class="product-img position-relative overflow-hidden bg-transparent p-0">
                                <img class="img-fluid w-100" src="./img/hombre/camisas/<?php echo $producto["producto_id"]; ?>.png" style="width:100%">
                            </div>
                            <h6 class="text-truncate mb-3 text-center"><?php echo $producto['descripcion']; ?></h6>
                            <h6>Precio: $<?php echo $producto['precio']; ?></h6>
                            <input type="hidden" name="precio" value="<?php echo $producto['precio']; ?>">
                            <input type="hidden" name="producto_id" value="<?php echo $producto['producto_id']; ?>">
                            <div class="card-footer d-flex justify-content-between bg-light border">
                                <select name="cantidad">
                                    <?php for ($i = 1; $i <= 10; $i++) { ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                                <button type="submit" name="agregar" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Añadir al carrito</button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <!-- Shop End -->
    <!-- Footer Start -->
    <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <a href="" class="text-decoration-none">
                    <h1 class="mb-4 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border border-white px-3 mr-1">FOCUS</span></h1>
                </a>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Calle San Benito, 13</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>asir202400@estudiantes.salesianasnsp.es</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+34 666 666 666</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+34 919 919 919</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Sobre nosotros</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <p>En FOCUS, nos apasiona la moda y creemos que cada prenda cuenta una historia. Nuestra misión es ofrecerte ropa de alta calidad,
                                diseño único y a precios accesibles, para que puedas expresar tu estilo personal sin límites.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Enlaces</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="index.php"><i class="fa fa-angle-right mr-2"></i>Página principal</a>
                            <a class="text-dark mb-2" href="cart.php"><i class="fa fa-angle-right mr-2"></i>Carrito</a>
                            <a class="text-dark mb-2" href="checkout.html"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-dark" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Contacto</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Escríbenos</h5>
                        <form action="escribenos.php">
                            <div class="form-group">
                                <input type="text" class="form-control border-0 py-4" placeholder="Nombre" required="required" />
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control border-0 py-4" placeholder="Correo Electrónico" required="required" />
                            </div>
                            <div>
                                <button class="btn btn-primary btn-block border-0 py-3" type="submit">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top border-light mx-xl-5 py-4">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-dark">
                    &copy; <a class="text-dark font-weight-semi-bold" href="#">FOCUS</a>. All Rights Reserved. Designed
                    by
                    <a class="text-dark font-weight-semi-bold" href="https://htmlcodex.com">HTML Codex</a>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="img/payments.png" alt="">
            </div>
        </div>
    </div>
    <!-- Footer End -->
    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
</body>