<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Focus</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <link rel="icon" type="image/x-icon" href="./img/favi.ico">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-2 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block"></div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark px-2" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="text-dark px-2" href=""><i class="fab fa-twitter"></i></a>
                    <a class="text-dark px-2" href=""><i class="fab fa-linkedin-in"></i></a>
                    <a class="text-dark px-2" href=""><i class="fab fa-instagram"></i></a>
                    <a class="text-dark pl-2" href=""><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
            <a href="./index.php" class="text-decoration-none">
                    <img src="./img/imgindex/logof2.png" style="width: 50%;">
                </a>
            </div>
            <div class="navbar-nav ml-auto py-0">
                <a href="./registro.php" class="nav-item nav-link">Registrarse</a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->
    <!-- Validar formulario -->
    <?php
    function test_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }
    $usuario = $contraseña = $usuarioErr = $contraseñaErr = $usucontraErr = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = test_input($_POST["usuario"]);
        $contraseña = test_input($_POST["contraseña"]);
        if (empty($usuario)) {
            $usuarioErr = "Falta el usuario";
        }
        if (empty($contraseña)) {
            $contraseñaErr = "Falta la contraseña";
        }
        if (empty($usuarioErr) && empty($contraseñaErr)) {
            require "./conexion.php";
            try {
                $sql = "SELECT * FROM clientes WHERE usuario=?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "Error en la preparación de la consulta.";
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $usuario);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if ($row = mysqli_fetch_assoc($result)) {
                        if (password_verify($contraseña, $row["contraseña"])) {
                            $_SESSION["usuario"] = $row["usuario"];
                            header("Location: ./index.php");
                            exit();
                        } else {
                            $usucontraErr = "Usuario o contraseña incorrectos";
                        }
                    } else {
                        $usucontraErr = "Usuario o contraseña incorrectos";
                    }
                }
                mysqli_stmt_close($stmt);
            } catch (Exception $e) {
                echo "Se ha producido un error al buscar. Error: " . $e->getMessage();
            }
        }
    }
    ?>
    <!-- Validar formulario -->
    <!-- Formulario inicio -->
    <div class="cuenta">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="text-center">
            <p>
                <input type="text" placeholder="Nombre de usuario" name="usuario" value="<?php echo $usuario; ?>">
                <span class="error"><?php echo $usuarioErr; ?></span>
            </p>
            <p>
                <input type="password" placeholder="Contraseña" name="contraseña" value="<?php echo $contraseña; ?>">
                <span class="error"><?php echo $contraseñaErr; ?></span>
            </p>
            <span class="error"><?php echo $usucontraErr; ?></span>
            <p><input type="submit" value="INICIAR SESIÓN" class="btn btn-primary btn-block border-0 py-3"></p>
        </form>
    </div>
    <!-- Formulario Fin -->
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