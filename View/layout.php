<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

function MostrarMenu() {
   

    $rol = $_SESSION['RolID'] ?? null;       
    $EmpleadoRol = $_SESSION['EmpleadoRol'] ?? null;

    echo '
    <nav class="navbar navbar-expand-lg navbar-dark bg-blue-dark">
        <div class="container-fluid px-5 d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="/OptiGestion/index.php">Óptica Grisol</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="/OptiGestion/index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="/OptiGestion/view/about.php">Sobre Nosotros</a></li>
                    <li class="nav-item"><a class="nav-link" href="/OptiGestion/view/anteojos.php">Anteojos</a></li>';

    // controla el usuario no logueado
    if (!$rol) {
        echo '<li class="nav-item ms-lg-3"><a class="nav-link" href="/OptiGestion/view/iniciarSesion.php">Iniciar Sesión</a></li>';
    }

    // este es para el de paciente
    else if ($rol === 'Paciente') {

        //se pone debajo del primer 
           // </ul>
        //</li>
        echo '
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCitas" role="button" data-bs-toggle="dropdown">
                Citas
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownCitas">
                <li><a class="dropdown-item" href="/OptiGestion/view/appointmentForm.php">Agendar Cita</a></li>
                <li><a class="dropdown-item" href="/OptiGestion/view/editarcita.php">Mis Citas</a></li>
                <li><a class="dropdown-item" href="/OptiGestion/view/historialMedico.php">Historial Médico</a></li>
            </ul>
        </li>';
    }

    // este para el de empleado
    else if ($rol === 'Empleado') {
        // este es para el empleado con rol de administrador
        if ($EmpleadoRol == 1) {
            //de aqui(sin el echo y las ') despues de ponerlo arriba se comenta desde el else a la llave
            // para que les funcione y luego se pone todo como estaba
              echo ' 
             <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPersonal" role="button" data-bs-toggle="dropdown">
                     Personal
                 </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownPersonal">
                    <li><a class="dropdown-item" href="/OptiGestion/view/personal.php">Ver Personal</a></li>
                     
                </ul>
            </li>';
            //hasta aqui (igual sin ' y ;)
        }

        // este para todos los demás empleados
        echo '
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAdmin" role="button" data-bs-toggle="dropdown">
                Administración
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownAdmin">
                <li><a class="dropdown-item" href="/OptiGestion/view/reportes.php">Reportes</a></li>
                <li><a class="dropdown-item" href="/OptiGestion/view/inventario.php">Inventario</a></li>
                <li><a class="dropdown-item" href="/OptiGestion/view/facturacion.php">Facturación</a></li>
            </ul>
        </li>';
    }
if ($rol) {
        echo '
        <li class="nav-item dropdown ms-lg-3">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPerfil" role="button" data-bs-toggle="dropdown">
                Perfil
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownPerfil">
                <li><a class="dropdown-item" href="/OptiGestion/view/editarPerfil.php">Editar Perfil</a></li>
                <li><a class="dropdown-item" href="/OptiGestion/view/editarcita.php">Mis Citas</a></li>
                <li><a class="dropdown-item" href="/OptiGestion/logout.php">Cerrar Sesión</a></li>
            </ul>
        </li>';
    }
    echo '
                </ul>
            </div>
        </div>
    </nav>';
}


function MostrarFooter() {
    echo '
    <footer class="footer bg-dark text-light pt-5 pb-3 ">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-md-3 mb-4">
                    <h6 class="fw-bold text-uppercase">Sucursal</h6>
                    <a href="https://maps.app.goo.gl/8xCe7rQRBhBzRZsr7" class="text-light text-decoration-none small">Ver ubicacion</a>
                </div>
                <div class="col-md-3 mb-4">
                    <h6 class="fw-bold text-uppercase">Redes Sociales</h6>
                    <p class="mb-1 small">
                        <a href="https://www.instagram.com/opticagrisol?igsh=cm5zMXprZmphczAz" class="text-light text-decoration-none">
                            <i class="bi bi-instagram me-1"></i> Instagram
                        </a>
                    </p>
                    <p class="mb-1 small">
                        <a href="https://www.facebook.com/share/19kUWTvjNF/?mibextid=wwXIfr" class="text-light text-decoration-none">
                            <i class="bi bi-facebook me-1"></i> Facebook
                        </a>
                    </p>
                    <p class="mb-1 small">
                    <a href="https://wa.me/50612345678" class="text-light text-decoration-none" target="_blank">
                   <i class="bi bi-whatsapp"></i> WhatsApp
                     </a>
                    </p>
                </div>
                <div class="col-md-3 mb-4">
                    <h6 class="fw-bold text-uppercase">Oficina Central</h6>
                    <p class="mb-1 small">Avenida 1A, Cartago Province, Cartago</p>
                    <h6 class="fw-bold mt-2 small">Contacto</h6>
                    <p class="mb-1 small">8813-9883 || 2592-5460</p>
                    <p class="mb-0 small">opticagrisol@gmail.com</p>
                </div>
            </div>

            <hr class="border-secondary">

            <div class="row">
                <div class="col">
                    <p class="mb-0 small">
                        &copy; <script>document.write(new Date().getFullYear());</script> Óptica Grisol. Todos los derechos reservados.
                    </p>
                </div>
            </div>
        </div>
    </footer>';
}


function IncluirCSS() {
    echo '
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/OptiGestion/assets/css/animate.css">
    <link rel="stylesheet" href="/OptiGestion/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/OptiGestion/assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="/OptiGestion/assets/css/magnific-popup.css">
    <link rel="stylesheet" href="/OptiGestion/assets/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="/OptiGestion/assets/css/jquery.timepicker.css">
    <link rel="stylesheet" href="/OptiGestion/assets/css/flaticon.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/OptiGestion/assets/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/OptiGestion/assets/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="/OptiGestion/assets/css/styles.css?v=2.2">
    
    ';
}


function IncluirScripts() {
    echo '
    <script src="/OptiGestion/assets/js/jquery.min.js"></script>
    <script src="/OptiGestion/assets/js/jquery-migrate-3.0.1.min.js"></script>
    <script src="/OptiGestion/assets/js/popper.min.js"></script>
    <script src="/OptiGestion/assets/js/bootstrap.min.js"></script>
    <script src="/OptiGestion/assets/js/jquery.easing.1.3.js"></script>
    <script src="/OptiGestion/assets/js/jquery.waypoints.min.js"></script>
    <script src="/OptiGestion/assets/js/jquery.stellar.min.js"></script>
    <script src="/OptiGestion/assets/js/jquery.animateNumber.min.js"></script>
    <script src="/OptiGestion/assets/js/bootstrap-datepicker.js"></script>
    <script src="/OptiGestion/assets/js/jquery.timepicker.min.js"></script>
    <script src="/OptiGestion/assets/js/owl.carousel.min.js"></script>
    <script src="/OptiGestion/assets/js/jquery.magnific-popup.min.js"></script>
    <script src="/OptiGestion/assets/js/scrollax.min.js"></script>
    <script src="/OptiGestion/assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    ';
}

?>