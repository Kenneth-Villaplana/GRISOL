<?php
include('layout.php');
include_once __DIR__ . '/../Controller/productoController.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Óptica Grisol</title>
  <?php IncluirCSS(); ?>
</head>

<body>
  <?php MostrarMenu(); ?>

  <section class="full-height-section">
    <div class="container" data-aos="fade-up">
            <?php
                if(isset($_SESSION["txtMensaje"])){
                 echo '<div class="alert alert-' . (isset($_SESSION["CambioExitoso"]) ? 'success' : 'danger') . '">' . $_SESSION["txtMensaje"] . '</div>';
                 unset($_SESSION["txtMensaje"]);   
                 unset($_SESSION["CambioExitoso"]);        
          }
          ?>  
      <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="profile-card" data-aos="fade-up">
            <div class="profile-header">
                  <h4 class="mb-0">Editar Producto</h4>
                  </div>


          <form method="POST" name="contactForm" class="row justify-content-center p-4" >
            <div class="col-md-8 col-lg-6">
            <h6 class="profile-section-title text-center mb-4">Datos</h6>
      

                   <div class="mb-3">
                <label for="nombre" class="form-label">Producto ID</label>
                <input type="text" id="ProductoId" name="ProductoId" class="form-control"  value= "<?php echo $producto['ProductoId']; ?>"readonly>
              </div>
                  <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" id="Nombre" name="Nombre" class="form-control"  value= "<?php echo $producto['Nombre']; ?>" required>
              </div>
                <div class="mb-3">
              <label for="descripcion" class="form-label">Descripcion</label>
              <textarea name="Descripcion" id="descripcion" class="form-control" rows="5" required><?php echo $producto['Descripcion']; ?></textarea>
            </div>
              <div class="mb-3">
              <label for="precio" class="form-label">Precio</label>
              <input type="number" name="Precio" id="precio" class="form-control" value= "<?php echo $producto['Precio']; ?>"required>
            </div>
              <div class="mb-3">
              <label for="cantidad" class="form-label">Cantidad</label>
              <input type="number" name="Cantidad" id="cantidad" class="form-control" value= "<?php echo $producto['Stock']; ?>"required>
            </div>

            <div class="mb-4">
              <label for="Id_Proveedor" class="form-label">Proveedor</label>
              <select name="Id_Proveedor" id="Id_Proveedor" class="form-select" required>
                <option value="">Seleccionar</option>
                <?php foreach($proveedores as $prov):?>
                <option value="<?php echo $prov['ProveedorId'];?>"
                <?php if($prov['ProveedorId'] == $producto['Id_Proveedor']) echo 'selected'; ?>>
                <?php echo $prov['Nombre'];?>
        </option>
        <?php endforeach;?>
        </select>
        </div>
           
            <div class="col-12 text-center mt-3">
              <button type="submit" class="btn btn-custom px-4" id="" name="btnEditarProducto">
                <i class="bi bi-pencil-square"></i> Guardar Cambios
              </button>
            </div>

          </form>

        </div>
      </div>
    </div>
  </section>

  <?php MostrarFooter(); ?>
  <?php IncluirScripts(); ?>
</body>
</html>