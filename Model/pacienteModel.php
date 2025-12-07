<?php
include_once __DIR__ . '/../Model/baseDatos.php';

class PacienteModel {

    public function buscarPorCedula($cedula) {
        // Abrir conexión (mysqli)
        $dbConn = AbrirBD();

        // Usamos un procedimiento almacenado con mysqli
        $stmt = $dbConn->prepare("CALL BuscarPacientePorCedulaUsuario(?)");
        if (!$stmt) {
            // Opcional: logging de error
            error_log("Error en prepare: " . $dbConn->error);
            return null;
        }

        // Vincular parámetro
        $stmt->bind_param("s", $cedula); // "s" = string

        // Ejecutar
        if (!$stmt->execute()) {
            error_log("Error en execute: " . $stmt->error);
            $stmt->close();
            CerrarBD($dbConn);
            return null;
        }

        // Obtener resultado
        $resultado = null;
        $res = $stmt->get_result();
        if ($res) {
            $fila = $res->fetch_assoc();
            if ($fila) {
                $resultado = $fila;
            }
            $res->free();
        }

        // Cerrar statement y conexión
        $stmt->close();
        CerrarBD($dbConn);

        // Devolver array asociativo o null
        return $resultado ?: null;
    }
}
?>
