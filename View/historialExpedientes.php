<?php
include('layout.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Historial de Expedientes Digitales</title>
    <?php IncluirCSS(); ?>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <?php MostrarMenu(); ?>

    <main class="container my-5">

        <!-- Banner superior -->
        <div class="banner-expediente">
            <div class="banner-text">
                <h2><i class="bi bi-folder2-open"></i> Historial de Expedientes Digitales</h2>
                <p class="lead mb-0">Consulta, gestiona y administra la información de tus pacientes</p>
            </div>
        </div>

        <!-- Formulario de búsqueda -->
        <div class="container mt-4">
            <div class="card p-4 shadow">
                <h4 class="mb-3">Buscar Paciente por Cédula</h4>
                <input type="text" id="cedula" class="form-control mb-3" placeholder="Ingrese la cédula">
                <button class="btn btn-primary" onclick="buscarPaciente()">Buscar</button>

                <div id="resultado" class="mt-4"></div>

                <!-- Grupo de botones para paciente registrado -->
                <div class="col-md-8 mb-3 text-center d-flex flex-column justify-content-center mt-3">
                    <div class="btn-group-vertical mx-auto" style="width: 70%;">
                        <a id="btnAgregarExpediente" class="btn btn-primary mb-2" style="display:none;">
                            <i class="bi bi-plus-square"></i> Agregar Expediente
                        </a>
                        <a id="btnVerUltimo" class="btn btn-outline-info mb-2" style="display:none;">
                            <i class="bi bi-journal-text"></i> Ver Último Expediente Digital
                        </a>
                        <a id="btnHistorial" class="btn btn-outline-secondary mb-2" style="display:none;">
                            <i class="bi bi-clock-history"></i> Historial Clínico
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <?php MostrarFooter(); ?>
    <?php IncluirScripts(); ?>

   <script>
    // FUNCION GLOBAL
    async function buscarPaciente() {
        const cedula = document.getElementById('cedula').value.trim();
        const resultadoDiv = document.getElementById('resultado');
        const btnAgregar = document.getElementById('btnAgregarExpediente');
        const btnUltimo = document.getElementById('btnVerUltimo');
        const btnHistorial = document.getElementById('btnHistorial');

        // Ocultar botones antes de mostrar resultado
        btnAgregar.style.display = 'none';
        btnUltimo.style.display = 'none';
        btnHistorial.style.display = 'none';
        resultadoDiv.innerHTML = '';

        if (!cedula) {
            alert("Por favor ingrese una cédula.");
            return;
        }

        try {
            const response = await fetch('../Controller/pacienteController.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'cedula=' + encodeURIComponent(cedula)
            });

            const data = await response.json();

            // Escenario 3: Paciente no encontrado
            if (data.error) {
                resultadoDiv.innerHTML = `<div class="alert alert-danger">${data.error}</div>
                    <a href="RegistrarPaciente.php" class="btn btn-success mt-2">Registrar Paciente</a>`;
                    
                return;
            }

            // Escenario 1: Paciente encontrado
            if (data.PacienteId) {
                resultadoDiv.innerHTML = `<div class="alert alert-success">
                    <strong>Nombre:</strong> ${data.nombre} ${data.apellido} ${data.apellidoDos}<br>
                    <strong>Teléfono:</strong> ${data.telefono ?? ''}<br>
                    <strong>Dirección:</strong> ${data.direccion ?? ''}
                </div>`;

                sessionStorage.setItem('paciente', JSON.stringify(data));

                btnAgregar.href = 'expedienteDigital.php';
                btnAgregar.style.display = 'block';
                btnUltimo.href = `ultimoExpediente.php?PacienteId=${data.PacienteId}`;
                btnUltimo.style.display = 'block';
                btnHistorial.href = `historialExpedientePaciente.php?PacienteId=${data.PacienteId}`;
                btnHistorial.style.display = 'block';
            }

            // Escenario 2: Usuario existe pero no paciente
            else if (data.UsuarioId) {
                resultadoDiv.innerHTML = `<div class="alert alert-warning">Usuario registrado pero sin paciente asociado.</div>`;

                btnAgregar.onclick = async (e) => {
                    e.preventDefault();
                    try {
                        const res = await fetch('../Controller/pacienteController.php?action=crearPaciente', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: 'UsuarioId=' + data.UsuarioId
                        });
                        const newData = await res.json();
                        if (newData.success) {
                            sessionStorage.setItem('paciente', JSON.stringify({
                                PacienteId: newData.PacienteId,
                                nombre: data.nombre,
                                apellido: data.apellido,
                                apellidoDos: data.apellidoDos
                            }));
                            window.location.href = 'expedienteDigital.php?PacienteId=' + newData.PacienteId;
                        } else {
                            alert("Error al crear paciente.");
                        }
                    } catch (err) {
                        console.error(err);
                        alert("Error al crear paciente.");
                    }
                };
                btnAgregar.style.display = 'block';
            }

        } catch (err) {
            console.error(err);
            alert("Ocurrió un error al buscar el paciente.");
        }
    }
</script>

</body>

</html>