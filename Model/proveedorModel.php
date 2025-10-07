<?php
include_once __DIR__ . '/../Model/baseDatos.php';




function ObtenerProveedores(){
    try{
        $enlace = AbrirBD();
        $sentencia = $enlace->prepare("CALL MostrarProveedores()");
        $sentencia->execute();

        $resultado = $sentencia->get_result();
        $proveedores = [];
        while($row = $resultado->fetch_assoc()){
        $proveedores[] = $row;
    }
    $sentencia->close();
    CerrarBD($enlace);
    return $proveedores;
} catch(Exception $ex) {
    return[];
}
}
?>