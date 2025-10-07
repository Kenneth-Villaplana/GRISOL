<?php

include_once __DIR__ . '/../Model/productoModel.php';
include_once __DIR__ . '/../Model/proveedorModel.php';

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_POST["btnEditarProducto"])) {
    $productoId = $_POST["ProductoId"] ?? null;
    $nombre = $_POST["Nombre"];
    $descripcion = $_POST["Descripcion"];
    $precio= $_POST["Precio"];
    $cantidad = $_POST["Cantidad"];
    $id_proveedor = $_POST["Id_Proveedor"] ?? null;
   

        $resultadoEdit = EditarProductoModel($productoId, $nombre, $descripcion, $precio, $cantidad, $id_proveedor);
       
        $_SESSION["txtMensaje"] = $resultadoEdit['mensaje'];
         if($resultadoEdit['resultado'] == 1) 
            $_SESSION["CambioExitoso"] = true;
       header ("Location: editarProducto.php?id=".$productoId);
        exit;
    }
    
    $productoId = $_GET['id'] ?? null;
    if(!$productoId){
            die("Producto no encontrado");
        }

    $productos = ObtenerProductos($productoId);
    $producto = $productos[0] ?? null;
    if (!$producto) 
        die ("Producto no encontrado");

    $proveedores = ObtenerProveedores();


?>