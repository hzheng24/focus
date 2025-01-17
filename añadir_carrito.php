<?php
session_start();
require 'conexion.php';
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar'])) {
        // Revisar que el usuario está autenticado
        if (!isset($_SESSION['usuario'])) {
            header("location: ./iniciarsesion.php"); // Redirigir al login si no está autenticado
            exit();
        }
        print_r($_POST);
        $producto_id = test_input($_POST['producto_id']);
        $usuario = $_SESSION['usuario'];
        $cantidad = test_input($_POST["cantidad"]);
        $precio = test_input($_POST['precio']);
        // Verificar el carrito_id del usuario al que pertenece
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
        }
        else{
            header("location: ./registro.php");
        }
        mysqli_stmt_close($stmt);
        //Revisar si el producto introducido ya está en la tabla con ese mismo carrito_id para aumentar la cantidad
        $sql = "SELECT * FROM producto_carrito WHERE carrito_id = ? AND producto_id = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ./registro.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "is", $carrito_id,$producto_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $precio2 = $row['precio'];
            $sql = "UPDATE producto_carrito SET precio = precio + ?, cantidad = cantidad + ? WHERE carrito_id = ? AND producto_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiis", $precio2, $cantidad, $carrito_id, $producto_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("Location: ./H_CAM.php");
        }
        else{
            $sql = "INSERT INTO producto_carrito (producto_id, cantidad, precio, carrito_id) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ./registro.php?error=stmtfailed");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "siii", $producto_id, $cantidad, $precio, $carrito_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("location: ./H_CAM.php");
        }
    }
?>