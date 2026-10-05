<?php

require_once "../config/conexion.php";

// Verificar que exista el ID
if (!isset($_GET["id"])) {
    header("Location: listar.php");
    exit;
}

$id = $_GET["id"];

// Buscar el producto antes de eliminarlo
$consulta = $conexion->prepare(
    "SELECT id FROM productos WHERE id = ?"
);

$consulta->execute([$id]);

$producto = $consulta->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    header("Location: listar.php");
    exit;
}

// Eliminar producto
$eliminar = $conexion->prepare(
    "DELETE FROM productos WHERE id = ?"
);

$eliminar->execute([$id]);

// Regresar a la lista
header("Location: listar.php");
exit;

?>