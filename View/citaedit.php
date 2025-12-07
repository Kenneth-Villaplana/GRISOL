<?php
session_start();
include_once __DIR__ . '/../layout.php';
include_once __DIR__ . '/../Model/baseDatos.php';

// Validar sesión
if (!isset($_SESSION['UsuarioID'])) {
    header('Location: /View/iniciarSesion.php');
    exit;
}

$usuarioId = $_SESSION['UsuarioID'];
$rolId = $_SESSION['Id_rol'] ?? null;

// --------------------- FUNCIONES ---------------------

function puedeGestionarCitas($rolId)
{
    return $rolId != 4; // Cajero no puede
}

// Obtener citas del usuario o todas
function obtenerCitas($conn, $usuarioId, $rolId)
{
    if ($rolId == 4) {
        return [];
    }

    // Si es paciente
    if ($_SESSION['RolID'] === 'Paciente') {
        return obtenerCitasPaciente($conn, $usuarioId);
    }

    // Empleado o Administrador
    return obtenerTodasLasCitas($conn);
}

// Citas de paciente
function obtenerCitasPaciente($conn, $usuarioId)
{
    $query = "SELECT p.PacienteId FROM paciente p WHERE p.UsuarioId = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $usuarioId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $paciente = mysqli_fetch_assoc($result);

    if (!$paciente) return [];

    $query = "SELECT c.*, u.Nombre AS EmpleadoNombre, u.Apellido AS EmpleadoApellido,
                     p.Nombre AS PacienteNombre
              FROM cita c
              LEFT JOIN usuario u ON c.id_empleado = u.IdUsuario
              LEFT JOIN paciente p ON c.ID_Paciente = p.PacienteId
              WHERE c.ID_Paciente = ?
              ORDER BY c.Fecha DESC";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $paciente['PacienteId']);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $citas = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $citas[] = $row;
    }

    return $citas;
}

// Todas las citas
function obtenerTodasLasCitas($conn)
{
    $query = "SELECT c.*, u.Nombre AS EmpleadoNombre, u.Apellido AS EmpleadoApellido,
                     p.Nombre AS PacienteNombre, p.PacienteId
              FROM cita c
              LEFT JOIN usuario u ON c.id_empleado = u.IdUsuario
              LEFT JOIN paciente p ON c.ID_Paciente = p.PacienteId
              ORDER BY c.Fecha DESC";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $citas = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $citas[] = $row;
    }

    return $citas;
}

// Cancelar cita
function cancelarCita($conn, $citaId, $usuarioId, $rolId)
{
    if (!puedeGestionarCitas($rolId)) {
        throw new Exception("No tienes permisos para cancelar citas");
    }

    $query = ($_SESSION['RolID'] === 'Paciente')
        ? "SELECT c.* FROM cita c JOIN paciente p ON c.ID_Paciente = p.PacienteId WHERE c.IdCita = ? AND p.UsuarioId = ?"
        : "SELECT * FROM cita WHERE IdCita = ?";

    $stmt = mysqli_prepare($conn, $query);

    if ($_SESSION['RolID'] === 'Paciente') {
        mysqli_stmt_bind_param($stmt, "ii", $citaId, $usuarioId);
    } else {
        mysqli_stmt_bind_param($stmt, "i", $citaId);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $cita = mysqli_fetch_assoc($result);

    if (!$cita) throw new Exception("Cita no encontrada");

    $query = "UPDATE cita SET Estado = 'cancelada' WHERE IdCita = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $citaId);

    return mysqli_stmt_execute($stmt);
}

// ---------------------- PROCESAR POST ----------------------

$mensajeExito = "";
$mensajeError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = AbrirBD();

    try {
        if ($_POST['action'] === 'cancelar_cita') {
            $citaId = intval($_POST['cita_id']);
            cancelarCita($conn, $citaId, $usuarioId, $rolId);
            $mensajeExito = "Cita cancelada exitosamente";
        }
    } catch (Exception $e) {
        $mensajeError = $e->getMessage();
    }

    CerrarBD($conn);
}

// ---------------------- CONSULTAR CITAS ----------------------

$conn = AbrirBD();
$citas = obtenerCitas($conn, $usuarioId, $rolId);
CerrarBD($conn);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Citas</title>
    <?php IncluirCSS(); ?>
</head>
<body>

<?php MostrarMenu(); ?>

<div class="container mt-4">

    <h2 class="mb-4">
        <?php echo ($_SESSION['RolID'] === 'Paciente') ? "Mis Citas" : "Gestión de Citas"; ?>
    </h2>

    <?php if ($mensajeExito): ?>
        <div class="alert alert-success"><?= $mensajeExito ?></div>
    <?php endif; ?>

    <?php if ($mensajeError): ?>
        <div class="alert alert-danger"><?= $mensajeError ?></div>
    <?php endif; ?>

    <?php if (empty($citas)): ?>
        <p>No hay citas disponibles.</p>
    <?php else: ?>
        <?php foreach ($citas as $cita): ?>
            <div class="card mb-3 p-3">
                <h5><?= htmlspecialchars($cita['Nombre']) ?></h5>
                <p><b>Fecha:</b> <?= $cita['Fecha'] ?></p>
                <p><b>Estado:</b> <?= ucfirst($cita['Estado']) ?></p>

                <?php if ($rolId != 4): ?>
                <form method="POST" class="d-inline">
                    <input type="hidden" name="action" value="cancelar_cita">
                    <input type="hidden" name="cita_id" value="<?= $cita['IdCita'] ?>">
                    <button class="btn btn-danger btn-sm">Cancelar</button>
                </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>

<?php IncluirScripts(); ?>

</body>
</html>
