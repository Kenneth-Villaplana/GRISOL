<?php
include_once __DIR__ . '/../Model/baseDatos.php';

class HistorialModel
{
    public static function guardarExpediente($data)
    {
        $conn = AbrirBD();
        if (!$conn) return false;

        try {
            mysqli_begin_transaction($conn);

            // 1️⃣ Insertar expediente
            $sqlExp = "INSERT INTO Expediente (PacienteId, Ocupacion, MotivoConsulta, UsaLentes, UltimoControl)
                       VALUES (?, ?, ?, ?, ?)";
            $stmtExp = mysqli_prepare($conn, $sqlExp);
            mysqli_stmt_bind_param(
                $stmtExp,
                "issss",
                $data['PacienteId'],
                $data['Ocupacion'],
                $data['MotivoConsulta'],
                $data['UsaLentes'],
                $data['UltimoControl']
            );
            mysqli_stmt_execute($stmtExp);
            $idExpediente = mysqli_insert_id($conn);

            // 2️⃣ Antecedente
            if (!empty($data['Antecedente'])) {
                $sqlAnt = "INSERT INTO Antecedente (IdExpediente, Descripcion) VALUES (?, ?)";
                $stmtAnt = mysqli_prepare($conn, $sqlAnt);
                mysqli_stmt_bind_param($stmtAnt, "is", $idExpediente, $data['Antecedente']);
                mysqli_stmt_execute($stmtAnt);
            }

            // 3️⃣ Lensometría
            if (!empty($data['Ojo']) && is_array($data['Ojo'])) {
                foreach ($data['Ojo'] as $index => $ojo) {
                    $sqlLen = "INSERT INTO Lensometria (IdExpediente, Ojo, Esfera, Cilindro, Eje, AgudezaVisual)
                               VALUES (?, ?, ?, ?, ?, ?)";
                    $stmtLen = mysqli_prepare($conn, $sqlLen);
                    mysqli_stmt_bind_param(
                        $stmtLen,
                        "isddss",
                        $idExpediente,
                        $ojo,
                        $data['Esfera'][$index],
                        $data['Cilindro'][$index],
                        $data['Eje'][$index],
                        $data['AgudezaVisual'][$index]
                    );
                    mysqli_stmt_execute($stmtLen);
                }
            }

            // 4️⃣ Examen Externo
            if (!empty($data['ExamenExterno'])) {
                $sqlExt = "INSERT INTO ExamenExterno (IdExpediente, Descripcion) VALUES (?, ?)";
                $stmtExt = mysqli_prepare($conn, $sqlExt);
                mysqli_stmt_bind_param($stmtExt, "is", $idExpediente, $data['ExamenExterno']);
                mysqli_stmt_execute($stmtExt);
            }

            // 5️⃣ Examen Final
            if (!empty($data['OjoDerecho']) || !empty($data['OjoIzquierdo'])) {
                $sqlFin = "INSERT INTO ExamenFinal (IdExpediente, OjoDerecho, OjoIzquierdo, DP)
                           VALUES (?, ?, ?, ?)";
                $stmtFin = mysqli_prepare($conn, $sqlFin);
                mysqli_stmt_bind_param(
                    $stmtFin,
                    "iddi",
                    $idExpediente,
                    $data['OjoDerecho'],
                    $data['OjoIzquierdo'],
                    $data['DP']
                );
                mysqli_stmt_execute($stmtFin);
            }

            // 6️⃣ Datos Adicionales
            $sqlDat = "INSERT INTO DatosAdicionales (IdExpediente, DoctorResponsable, FechaExamen, Observaciones)
                       VALUES (?, ?, ?, ?)";
            $stmtDat = mysqli_prepare($conn, $sqlDat);
            mysqli_stmt_bind_param(
                $stmtDat,
                "isss",
                $idExpediente,
                $data['Observaciones'],
                $data['Altura'],
                $data['Diagnostico']
            );
            mysqli_stmt_execute($stmtDat);

            mysqli_commit($conn);
            CerrarBD($conn);
            return true;

        } catch (Exception $e) {
            mysqli_rollback($conn);
            CerrarBD($conn);
            return false;
        }
    }
}
?>
