<?php include('layout.php'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Historia Clínica de Optometría</title>
  <?php IncluirCSS(); ?>
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
  <?php MostrarMenu(); ?>

  <main class="container my-5">

    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-bold text-primary mb-0">👁️ Historia Clínica de Optometría</h2>
      <a href="historialExpedientes.php" class="btn btn-outline-secondary">⬅ Volver</a>
    </div>

    <!-- Datos del paciente -->
    <!-- Formulario -->
    <form action="../Controller/HistorialController.php" method="POST" id="formExpediente">

      <!-- Datos del paciente -->
      <div class="form-section">
        <div class="section-title">🧑 Información del Paciente</div>
        <div class="row g-3">
          <input type="hidden" name="PacienteId" id="PacienteId" value="<?= $_GET['id'] ?? '' ?>">
          <div class="col-md-3">
            <label class="form-label">Cédula</label>
            <input type="text" name="cedula" class="form-control" value="<?= $_GET['cedula'] ?? '' ?>" readonly>
          </div>
          <div class="col-md-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= $_GET['nombre'] ?? '' ?>" readonly>
          </div>
          <div class="col-md-3">
            <label class="form-label">Primer Apellido</label>
            <input type="text" name="apellido" class="form-control" value="<?= $_GET['apellido1'] ?? '' ?>" readonly>
          </div>
          <div class="col-md-3">
            <label class="form-label">Segundo Apellido</label>
            <input type="text" name="apellidoDos" class="form-control" value="<?= $_GET['apellido2'] ?? '' ?>" readonly>
          </div>
        </div>
      </div>

      <div class="accordion" id="accordionExpediente">

        <!-- 1️⃣ Datos generales y antecedentes -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading1">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#datosGenerales">
              🧩 Datos Generales y Antecedentes
            </button>
          </h2>
          <div id="datosGenerales" class="accordion-collapse collapse show" data-bs-parent="#accordionExpediente">
            <div class="accordion-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label>Ocupación</label>
                  <input type="text" name="Ocupacion" class="form-control">
                </div>
                <div class="col-md-6">
                  <label>Motivo de consulta</label>
                  <input type="text" name="MotivoConsulta" class="form-control">
                </div>
                <div class="col-md-6">
                  <label>Usa lentes</label>
                  <select name="usaLentes" class="form-select">
                    <option value="Si">Sí</option>
                    <option value="No">No</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label>Último control visual</label>
                  <input type="date" name="UltimoControl" class="form-control">
                </div>

                <div class="col-12">
                  <label>Antecedentes Generales</label>
                  <textarea name="Descripcion" rows="2" class="form-control"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- 2️⃣ Lensometría y Agudeza Visual -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading2">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
              data-bs-target="#lensometria">
              👁️ Lensometría y Agudeza Visual
            </button>
          </h2>
          <div id="lensometria" class="accordion-collapse collapse" data-bs-parent="#accordionExpediente">
            <div class="accordion-body">

              <!-- Lensometría -->
              <div class="section-title">👁️ Lensometría</div>
              <table class="table table-bordered text-center">
                <thead class="table-light">
                  <tr>
                    <th></th>
                    <th>Lensometría</th>
                    <th>AV VL</th>
                    <th>ADD</th>
                    <th>AV VP</th>
                    <th>DIST. PUPILAR</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th>OD</th>
                    <td><input type="text" name="lensometria_od" class="form-control"></td>
                    <td><input type="text" name="av_vl_od" class="form-control"></td>
                    <td><input type="text" name="add_od" class="form-control"></td>
                    <td><input type="text" name="av_vp_od" class="form-control"></td>
                    <td><input type="text" name="dp_OD" class="form-control"></td>
                  </tr>
                  <tr>
                    <th>OI</th>
                    <td><input type="text" name="lensometria_oi" class="form-control"></td>
                    <td><input type="text" name="av_vl_oi" class="form-control"></td>
                    <td><input type="text" name="add_oi" class="form-control"></td>
                    <td><input type="text" name="av_vp_oi" class="form-control"></td>
                    <td><input type="text" name="dp_oi" class="form-control"></td>
                  </tr>
                </tbody>
              </table>

              <!-- Agudeza Visual -->
              <div class="section-title mt-4">👁️ Agudeza Visual</div>
              <table class="table table-bordered text-center">
                <thead class="table-light">
                  <tr>
                    <th></th>
                    <th>AV VL SC</th>
                    <th>PH</th>
                    <th>AV VP SC</th>
                    <th>DISTANCIA OPTOTIPO</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th>OD</th>
                    <td><input type="text" name="AV_VL_SC_OD" class="form-control"></td>
                    <td><input type="text" name="PH_OD" class="form-control"></td>
                    <td><input type="text" name="AV_VP_SC_OD" class="form-control"></td>
                    <td><input type="text" name="DISTANCIA_OPTOTIPO_OD" class="form-control"></td>
                  </tr>
                  <tr>
                    <th>OI</th>
                    <td><input type="text" name="AV_VL_SC_OI" class="form-control"></td>
                    <td><input type="text" name="PH_OI" class="form-control"></td>
                    <td><input type="text" name="AV_VP_SC_OI" class="form-control"></td>
                    <td><input type="text" name="DISTANCIA_OPTOTIPO_OI" class="form-control"></td>
                  </tr>
                  <tr>
                    <th>AO</th>
                    <td><input type="text" name="AV_VL_SC_AO" class="form-control"></td>
                    <td><input type="text" name="PH_AO" class="form-control"></td>
                    <td><input type="text" name="AV_VP_SC_AO" class="form-control"></td>
                    <td><input type="text" name="DISTANCIA_OPTOTIPO_AO" class="form-control"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- 3️⃣ Examen Externo -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading3">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
              data-bs-target="#examenExterno">
              🔬 Examen Externo
            </button>
          </h2>
          <div id="examenExterno" class="accordion-collapse collapse" data-bs-parent="#accordionExpediente">
            <div class="accordion-body">
              <textarea name="orbitaCejas" class="form-control mb-2" placeholder="Órbita / Cejas"></textarea>
              <textarea name="parpadosPestanas" class="form-control mb-2" placeholder="Párpados / Pestañas"></textarea>
              <textarea name="sistemaLagrimal" class="form-control mb-2" placeholder="Sistema Lagrimal"></textarea>
            </div>
          </div>
        </div>

        <!-- 4️⃣ Examen Final -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading4">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
              data-bs-target="#examenFinal">
              🩻 Oftalmoscopía
            </button>
          </h2>
          <div id="examenFinal" class="accordion-collapse collapse" data-bs-parent="#accordionExpediente">
            <div class="accordion-body">
              <textarea name="DescripcionOD" class="form-control mb-2" placeholder="Ojo Derecho"></textarea>
              <textarea name="DescripcionOI" class="form-control mb-2" placeholder="Ojo Izquierdo"></textarea>
            </div>
          </div>
        </div>

        <!-- 5️⃣ Fórmula Final y Datos Adicionales -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading5">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
              data-bs-target="#formulaFinal">
              👓 Fórmula Final y Datos Adicionales
            </button>
          </h2>
          <div id="formulaFinal" class="accordion-collapse collapse" data-bs-parent="#accordionExpediente">
            <div class="accordion-body">
              <div class="section-title">👁️ Fórmula Final</div>
              <table class="table table-bordered text-center">
                <thead class="table-light">
                  <tr>
                    <th></th>
                    <th>Esfera</th>
                    <th>Cilindro</th>
                    <th>Eje</th>
                    <th>DP</th>
                    <th>Prisma</th>
                    <th>Base</th>
                    <th>A.V</th>
                    <th>A.O</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th>OD</th>
                    <td><input type="text" name="Esfera_OD" class="form-control"></td>
                    <td><input type="text" name="Cilindro_OD" class="form-control"></td>
                    <td><input type="text" name="Eje_OD" class="form-control"></td>
                    <td><input type="text" name="DP_OD" class="form-control"></td>
                    <td><input type="text" name="Prisma_OD" class="form-control"></td>
                    <td><input type="text" name="Base_OD" class="form-control"></td>
                    <td><input type="text" name="AV_OD" class="form-control"></td>
                    <td><input type="text" name="AO_OD" class="form-control"></td>
                  </tr>
                  <tr>
                    <th>OI</th>
                    <td><input type="text" name="Esfera_OI" class="form-control"></td>
                    <td><input type="text" name="Cilindro_OI" class="form-control"></td>
                    <td><input type="text" name="Eje_OI" class="form-control"></td>
                    <td><input type="text" name="DP_OI" class="form-control"></td>
                    <td><input type="text" name="Prisma_OI" class="form-control"></td>
                    <td><input type="text" name="Base_OI" class="form-control"></td>
                    <td><input type="text" name="AV_OI" class="form-control"></td>
                    <td><input type="text" name="AO_OI" class="form-control"></td>
                  </tr>
                </tbody>
              </table>

              <div class="section-title mt-4">🧾 Datos Adicionales</div>
              <div class="row g-2">
                <div class="col-md-6"><textarea name="Observaciones" class="form-control mb-2"
                    placeholder="Uso, Color, Material, Lente, Segmento, Disposición"></textarea></div>
                <div class="col-md-6"><textarea name="Altura" class="form-control mb-2" placeholder="Altura"></textarea>
                </div>
                <div class="col-md-6"><textarea name="Diagnostico" class="form-control mb-2"
                    placeholder="Diagnóstico"></textarea></div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- Botón -->
      <div class="text-center mt-4">
        <button type="submit" class="btn btn-success">💾 Guardar expediente</button>
      </div>
    </form>
  </main>

  <?php MostrarFooter(); ?>
  <?php IncluirScripts(); ?>

  <script>
window.addEventListener('DOMContentLoaded', () => {
    const paciente = JSON.parse(sessionStorage.getItem('paciente'));

    if (paciente) {
        document.querySelector('input[name="cedula"]').value = paciente.cedula ?? '';
        document.querySelector('input[name="nombre"]').value = paciente.nombre ?? '';
        document.querySelector('input[name="apellido"]').value = paciente.apellido ?? '';
        document.querySelector('input[name="apellidoDos"]').value = paciente.apellidoDos ?? '';
        document.getElementById('PacienteId').value = paciente.PacienteId ?? '';
        console.log('Paciente cargado desde sessionStorage:', paciente);
    } else {
        console.error('No se encontró información del paciente en sessionStorage');
    }
});

  </script>

</body>

</html>