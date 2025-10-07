<?php
 include('layout.php'); 
  include_once __DIR__ . '/../Model/productoModel.php';

$productoFiltro = $_GET['idProducto'] ?? null;

 $listaProductos =ObtenerProductos($productoFiltro);
?>

<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Óptica Grisol</title>
   <?php IncluirCSS();?>
</head>
    <body>
       <?php MostrarMenu();?>

 <section class="container my-5 ">
        <div class="d-flex justify-content-between align-items-center mb-4">
       <h2>Inventario de Productos</h2>
       <a href="agregarProducto.php" class="btn btn-custom">
        <i class="bi bi-plus-circle"></i>Agregar Producto</a>
</div>



<div class="mb-4 d-flex justify-content-center">
  <form class="filter-form text-center d-flexflex-wrap gap-2" method="GET">
    <label for="codigoInput" class="form-label">Filtrar por ID</label>
    <input type="text" id="codigoInput" name="idProducto" class="form-control" placeholder="555">
    <button type="submit" class="mb-2 my-2 btn btn-custom">Buscar</button>
   <a href="inventario.php" class="mb-2 my-2 btn btn-outline-secondary mt-2">Limpiar</a>
  </form>
</div>

<div class="row" id="listaProductos">
<?php if (!empty($listaProductos)) {
foreach($listaProductos as $producto){
    ?>
  <div class="col-md-6 mb-4 producto">
        <div class="card shadow-sm">
        <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="card-title mb-0"><?php echo $producto['Nombre']; ?></h5>
 <span class="fw-bold text-primary">₡<?php echo number_format($producto['Precio'], 2); ?></span>
</div>
        
<p class="mb-2">Stock: <strong><?php echo $producto['Stock']; ?></strong></p>
<div class="progress mb-3">
    <div class="progress-bar <?php echo $producto['ColorBarra']; ?>"
        role= "progressbar"
        style="width: <?php echo $producto['AnchoBarra']; ?>%;"
        aria-valuenow="<?php echo $producto['Stock']; ?>"
        aria-valuemin="0"
        aria-valuemax="100">
</div>
</div>

<div class="d-flex justify-content-end">
                       <a href="editarproducto.php?id=<?php echo $producto['ProductoId']; ?>" 
                       class="btn btn-custom me-2">Editar</a>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarEliminarModal">Eliminar</button>
                     </div>
                </div>
            </div>
        </div>
    <?php 
}
}else{ ?>
  <div class="col-12 text-center text-muted">
  <p>No se encontraron productos</p>
  </div>
<?php }
?>
</div>
    </section>

    <?php MostrarFooter(); ?>
    <?php IncluirScripts(); ?>

    
<div class="modal fade" id="confirmarEliminarModal" tabindex="-1" aria-labelledby="confirmarEliminarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmarEliminarLabel">Confirmar eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro que quieres eliminar este producto?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger">Sí, eliminar</button>
      </div>
    </div>
  </div>
</div>
</body>

</html>