<?php
include('../Model/baseDatos.php'); // Asegúrate de que la ruta sea correcta

// 🔹 Si viene la acción para obtener el PacienteId (desde el expediente)
if (isset($_GET['action']) && $_GET['action'] === 'getPacienteId') {
    $enlace = AbrirBD();
    $usuarioId = $_GET['usuarioId'] ?? null;

    if (!$usuarioId) {
        echo json_encode(['success' => false, 'error' => 'Falta el usuarioId']);
        exit;
    }

    $sql = "SELECT PacienteId FROM Paciente WHERE UsuarioId = ?";
    $stmt = $enlace->prepare($sql);
    $stmt->bind_param("i", $usuarioId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result) {
        echo json_encode(['success' => true, 'PacienteId' => $result['PacienteId']]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Paciente no encontrado']);
    }

    $stmt->close();
    CerrarBD($enlace);
    exit;
}

$enlace = AbrirBD();

// 1️⃣ Validar Paciente
$pacienteId = $_POST['PacienteId'] ?? null;
if (!$pacienteId) {
    die("Error: Paciente no seleccionado. No se puede guardar el expediente.");
}

// 2️⃣ Datos Generales (permitir campos vacíos)
$ocupacion = $_POST['Ocupacion'] ?? null;
$motivoConsulta = $_POST['MotivoConsulta'] ?? null;
$usaLentes = $_POST['usaLentes'] ?? null;
$ultimoControl = $_POST['UltimoControl'] ?? null;

// 3️⃣ Guardar Expediente
$stmt = $enlace->prepare("
    INSERT INTO Expediente (PacienteId, Ocupacion, MotivoConsulta, UsaLentes, UltimoControl) 
    VALUES (?, ?, ?, ?, ?)
");
$stmt->bind_param("issss", $pacienteId, $ocupacion, $motivoConsulta, $usaLentes, $ultimoControl);
$stmt->execute();
$expedienteId = $stmt->insert_id;
$stmt->close();

// 4️⃣ Guardar Antecedentes (opcional)
$descripcion = $_POST['Descripcion'] ?? null;
if ($descripcion) {
    $stmt = $enlace->prepare("INSERT INTO Antecedente (IdExpediente, Descripcion) VALUES (?, ?)");
    $stmt->bind_param("is", $expedienteId, $descripcion);
    $stmt->execute();
    $stmt->close();
}

// 5️⃣ Guardar Lensometría
$lensometria = [
    'OD' => ['lensometria_od','av_vl_od','add_od','av_vp_od','dp_OD'],
    'OI' => ['lensometria_oi','av_vl_oi','add_oi','av_vp_oi','dp_oi']
];

$stmt = $enlace->prepare("
    INSERT INTO Lensometria (IdExpediente, Ojo, Esfera, Cilindro, Eje, AgudezaVisual) 
    VALUES (?, ?, ?, ?, ?, ?)
");
foreach($lensometria as $ojo => $campos){
    $esfera = $_POST[$campos[0]] ?? null;
    $eje = $_POST[$campos[1]] ?? null;
    $add = $_POST[$campos[2]] ?? null;
    $av = $_POST[$campos[3]] ?? null;
    $dp = $_POST[$campos[4]] ?? null;

    $stmt->bind_param("isssss", $expedienteId, $ojo, $esfera, $add, $eje, $av);
    $stmt->execute();
}
$stmt->close();

// 6️⃣ Guardar Agudeza Visual
$ojos = ['OD','OI','AO'];
$tipos = ['AV_VL_SC','PH','AV_VP_SC','DISTANCIA_OPTOTIPO'];

$stmt = $enlace->prepare("
    INSERT INTO AgudezaVisual (IdExpediente, Ojo, Tipo, Valor) 
    VALUES (?, ?, ?, ?)
");
foreach($ojos as $ojo){
    foreach($tipos as $tipo){
        $valor = $_POST["{$tipo}_{$ojo}"] ?? null;
        if($valor !== null && $valor !== ''){
            $stmt->bind_param("isss", $expedienteId, $ojo, $tipo, $valor);
            $stmt->execute();
        }
    }
}
$stmt->close();

// 7️⃣ Examen Externo
$orbitaCejas = $_POST['orbitaCejas'] ?? null;
$parpadosPestanas = $_POST['parpadosPestanas'] ?? null;
$sistemaLagrimal = $_POST['sistemaLagrimal'] ?? null;

$stmt = $enlace->prepare("
    INSERT INTO ExamenExterno (IdExpediente, orbitaCejas, parpadosPestanas, sistemaLagrimal) 
    VALUES (?, ?, ?, ?)
");
$stmt->bind_param("isss", $expedienteId, $orbitaCejas, $parpadosPestanas, $sistemaLagrimal);
$stmt->execute();
$stmt->close();

// 8️⃣ Oftalmoscopia
$descOD = $_POST['DescripcionOD'] ?? null;
$descOI = $_POST['DescripcionOI'] ?? null;

$stmt = $enlace->prepare("
    INSERT INTO Oftalmoscopia (IdExpediente, DescripcionOD, DescripcionOI) 
    VALUES (?, ?, ?)
");
$stmt->bind_param("iss", $expedienteId, $descOD, $descOI);
$stmt->execute();
$stmt->close();

// 9️⃣ Examen Final / Fórmula Final
$ojosExamen = ['OD','OI'];
$stmt = $enlace->prepare("
    INSERT INTO ExamenFinal (IdExpediente, Ojo, Esfera, Cilindro, Eje, Adicion, DP, Prisma, Base, AV, AO) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

foreach($ojosExamen as $ojo){
    // Obtener valores del POST, usar string vacío si no existe
    $esfera = $_POST["Esfera_{$ojo}"] ?? '';
    $cilindro = $_POST["Cilindro_{$ojo}"] ?? '';
    $eje = $_POST["Eje_{$ojo}"] ?? '';
    $adicion = $_POST["Add_{$ojo}"] ?? '';
    $dp = $_POST["DP_{$ojo}"] ?? '';
    $prisma = $_POST["Prisma_{$ojo}"] ?? '';
    $base = $_POST["Base_{$ojo}"] ?? '';
    $av = $_POST["AV_{$ojo}"] ?? '';
    $ao = $_POST["AO_{$ojo}"] ?? '';

    // Bind y ejecutar
    $stmt->bind_param(
        "issssssssss",
        $expedienteId,
        $ojo,
        $esfera,
        $cilindro,
        $eje,
        $adicion,
        $dp,
        $prisma,
        $base,
        $av,
        $ao
    );
    $stmt->execute();
}

$stmt->close();

// 10️⃣ Datos Adicionales
$observaciones = $_POST['Observaciones'] ?? null;
$altura = $_POST['Altura'] ?? null;
$diagnostico = $_POST['Diagnostico'] ?? null;

$stmt = $enlace->prepare("
    INSERT INTO DatosAdicionales (IdExpediente, Observaciones, Altura, Diagnostico) 
    VALUES (?, ?, ?, ?)
");
$stmt->bind_param("isss", $expedienteId, $observaciones, $altura, $diagnostico);
$stmt->execute();
$stmt->close();

// Cerrar conexión
CerrarBD($enlace);

// Verificamos si se insertó correctamente el expediente
if ($expedienteId > 0) {
    header("Location: ../View/historialExpedientes.php?mensaje=exito");
} else {
    header("Location: ../View/historialExpedientes.php?mensaje=error");
}
exit;


?>
