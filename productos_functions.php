<?php
include 'conexion.php';
function obtenerProductosPorCategoriaYTipo($tipoPersona, $categoria) {
    global $conn;
    $sql = "SELECT * FROM productos WHERE producto_id LIKE ? AND tipo = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('Error al preparar la consulta: ' . $conn->error);
    }
    $tipo = $tipoPersona . '%'; // Añadir el comodín para buscar productos que comienzan con N, M, H
    $stmt->bind_param("ss", $tipo, $categoria);
    $stmt->execute();
    $result = $stmt->get_result();
    $productos = [];
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
    $stmt->close();
    return $productos;
}
function micarrito($carrito_id) {
    global $conn;
    $sql = "SELECT * FROM producto_carrito WHERE carrito_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('Error al preparar la consulta: ' . $conn->error);
    }
    $stmt->bind_param("i", $carrito_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $micarrito = [];
    while ($row = $result->fetch_assoc()) {
        $micarrito [] = $row;
    }
    $stmt->close();
    return $micarrito;
}

function validartarjeta($tarjeta){
    $patron = "/^[0-9]{16}$/";
    return preg_match($patron, $tarjeta);
}

?>