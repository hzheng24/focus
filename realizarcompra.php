<?php
session_start();
require 'conexion.php';
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['realizarcompra'])) {
        // Revisar que el usuario está autenticado
        if (!isset($_SESSION['usuario'])) {
            header("location: ./iniciarsesion.php"); // Redirigir al login si no está autenticado
            exit();
        }
        print_r($_POST);
        $producto_id = test_input($_POST['producto_id']);
        $usuario = $_SESSION['usuario'];
        $precio = test_input($_POST['precio']);
        $fechahoy = date('Y-m-d');
        $preciototal = test_input($_POST['preciototal']);
        $pago = test_input($_POST['pago']);
        $tarjeta = test_input($_POST["tarjeta"]);
        $paypal = test_input($_POST["paypal"]);
        $patrontarjeta = "/^[0-9]{16}$/";
        // Expresión regular para validar el correo electrónico
        $patron = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
        //Comprobar la tarjeta de 16 dígitos
        if($pago == 1){
            $tarjetaErr = "Seleccione un método de pago!";
            header("location: ./compra.php?error=" . urlencode($tarjetaErr));
            exit();
        }
        elseif($pago == "tarjeta"){
            if (!preg_match($patrontarjeta, $tarjeta)) {
                $tarjetaErr = "Número de tarjeta inválido!";
                header("location: ./compra.php?error=" . urlencode($tarjetaErr));
                exit();
            }
        }
        elseif($pago == "paypal"){
            if (!preg_match($patron, $paypal)) {
                $tarjetaErr = "Cuenta de paypal inválida!";
                header("location: ./compra.php?error=" . urlencode($tarjetaErr));
                exit();
            }
        }
            //Sacar la direccion del usuario
            $sql = "SELECT * FROM clientes WHERE usuario = ?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ./registro.php?error=stmtfailed");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "s", $usuario,);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $direccion_id = $row['direccion_id'];
            }
            mysqli_stmt_close($stmt);
            //Insertar una nueva compra
                $sql = "INSERT INTO compra (usuario, direccion_id, fecha_compra, forma_pago, precio_total) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("location: ./registro.php?error=stmtfailed");
                    exit();
                }
                mysqli_stmt_bind_param($stmt, "sissi", $usuario, $direccion_id, $fechahoy, $pago, $preciototal);
                mysqli_stmt_execute($stmt);
                $compra_id = mysqli_insert_id($conn); // Obtener el id de la nueva compra
                mysqli_stmt_close($stmt);
        //Buscar el carrito_id de la tabla carrito
        $sql = "SELECT * FROM carrito WHERE usuario = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ./registro.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $usuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $carrito_id = $row['carrito_id'];
            mysqli_stmt_close($stmt);
        }
        //Insertar en la tabla compra_productos los datos de la tabla producto_carrito
        $sql = "SELECT * FROM producto_carrito WHERE carrito_id = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ./registro.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "i", $carrito_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $sql_insert = "INSERT INTO compra_productos (compra_id, producto_id, cantidad, precio_producto) values (?, ?, ?, ?)";
        $stmt_insert = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt_insert, $sql_insert)) {
            header("location: ./registro.php?error=stmtfailed");
            exit();
        }
        while ($row = mysqli_fetch_assoc($result)) {
            $producto_id = $row['producto_id'];
            $cantidad = $row['cantidad'];
            $precio = $row['precio'];
            mysqli_stmt_bind_param($stmt_insert, "isii", $compra_id, $producto_id, $cantidad, $precio);
            mysqli_stmt_execute($stmt_insert);
        }
        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmt_insert);
        $sql = "DELETE FROM producto_carrito WHERE carrito_id = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ./registro.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "i", $carrito_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $sql = "UPDATE productos SET stock = stock - ? WHERE producto_id = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ./registro.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "is", $cantidad,$producto_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ./carrito.php");
    }
?>