<?php
include_once __DIR__ . '/../Model/baseDatos.php';


function AgregarProductoModel($nombre, $descripcion, $precio, $cantidad, $id_proveedor)
{
    try {
        $enlace = AbrirBD();
        $sentencia = $enlace->prepare("CALL RegistrarPaciente(?, ?, ?, ?)");
        if(!$sentencia) {
            throw new Exception($enlace->error);
        }

       
        $sentencia->bind_param("ssii", 
            $nombre, 
            $descripcion, 
            $precio, 
            $id_proveedor
        );

        $sentencia->execute();
        $sentencia->close();
        CerrarBD($enlace);

        return ['resultado' => 1, 'mensaje' => 'Producto agregado con éxito'];

    } catch(Exception $ex) {
        return ['resultado' => 0, 'mensaje' => 'Error en el servidor: '.$ex->getMessage()];
    }
}
    
function ObtenerProductos($ProductoId = null){
    try{
        $enlace = AbrirBD();

        if($ProductoId) {
        $sentencia = $enlace->prepare("CALL FiltroPorId(?)");
        $sentencia->bind_param("i", $ProductoId);
        }else{
            $sentencia = $enlace->prepare("CALL MostrarProductos()");
        }

        $sentencia->execute();
        $resultado = $sentencia->get_result();

        $producto = [];
        while($row = $resultado->fetch_assoc()) {
            $stock = (int)$row['Stock'];

            if($stock < 20){
                $colorBarra ='bg-danger';
            }elseif($stock <= 50){
                $colorBarra ='bg-warning';
            }else{
                $colorBarra = 'bg-success';
            }
   //hay que preguntarle al cliente si tiene un maximo para los productos
    $anchoBarra = ($stock > 100)? 100 : $stock;

    $row['ColorBarra'] = $colorBarra;
    $row['AnchoBarra'] = $anchoBarra;

            $producto[] = $row;
        }

        $sentencia->close();
        CerrarBD($enlace);
        return $producto;

    }catch(Exception $ex){
        return [];
    }
}

function EditarProductoModel($productoId, $nombre, $descripcion, $precio, $cantidad, $id_Proveedor)
{
    try {
        $enlace = AbrirBD();
        $sentencia = $enlace->prepare("CALL EditarProducto(?, ?, ?, ?, ?, ?)");
        if(!$sentencia) {
            throw new Exception($enlace->error);
        }

       
        $sentencia->bind_param("issiii", 
             $productoId,
             $nombre, 
             $descripcion,
             $precio, 
             $cantidad, 
             $id_Proveedor
        );

        $sentencia->execute();
        $sentencia->close();
        CerrarBD($enlace);

        return ['resultado' => 1, 'mensaje' => 'Cambio realizado con exito'];

    } catch(Exception $ex) {
        return ['resultado' => 0, 'mensaje' => 'Error en el servidor: '.$ex->getMessage()];
    }
}
?>