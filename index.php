<?php
require_once __DIR__ . '/View/layout.php';
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

<header class="hero-home">
    <div class="hero-overlay"></div>

    <div class="hero-content text-center">
        <h1 class="hero-title fw-bold">Bienvenido a Óptica Grisol</h1>
        <p class="hero-subtitle">
            En Óptica Grisol combinamos tecnología, salud visual y estilo para brindarte la mejor experiencia.
        </p>

        <a href="/View/RegistrarPaciente.php" class="btn-cta-agendar mt-3">
            Agendar Cita
        </a>
    </div>
</header>

<section class="py-5">
    <div class="container px-4">
        <h2 class="text-center fw-bold mb-5">Mejor forma de cuidar tu vista</h2>

        <div class="row g-4">

            <div class="col-md-6 col-lg-3">
                <div class="beneficio-card shadow-sm p-4 text-center rounded-4">
                    <div class="icono-beneficio mx-auto mb-3">
                        <i class="bi bi-eye-fill"></i>
                    </div>
                    <h5 class="fw-bold">Servicios innovadores</h5>
                    <p class="text-muted small">
                        Soluciones personalizadas y tecnología avanzada para tu salud visual.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="beneficio-card shadow-sm p-4 text-center rounded-4">
                    <div class="icono-beneficio mx-auto mb-3">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <h5 class="fw-bold">Diagnóstico profesional</h5>
                    <p class="text-muted small">
                        Exámenes oculares completos y asesoría experta.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="beneficio-card shadow-sm p-4 text-center rounded-4">
                    <div class="icono-beneficio mx-auto mb-3">
                        <i class="bi bi-eyeglasses"></i>
                    </div>
                    <h5 class="fw-bold">Lentes de alta calidad</h5>
                    <p class="text-muted small">
                        Trabajamos con marcas premium para visión clara y comodidad total.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="beneficio-card shadow-sm p-4 text-center rounded-4">
                    <div class="icono-beneficio mx-auto mb-3">
                        <i class="bi bi-eye"></i>
                    </div>
                    <h5 class="fw-bold">Lentes de contacto</h5>
                    <p class="text-muted small">
                        Opciones cómodas y seguras para tu estilo de vida.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="py-5">
<div class="carousel-glass">

    <div id="carouselAuto" 
         class="carousel slide carousel-fade carousel-small" 
         data-bs-ride="carousel" 
         data-bs-interval="3000">

        <div class="carousel-inner">

            <div class="carousel-item active">
                <img src="/assets/img/carrusel1.jpg" class="d-block w-100 img-carrusel-small">
            </div>

            <div class="carousel-item">
                <img src="/assets/img/prueba2.jpg" class="d-block w-100 img-carrusel-small">
            </div>

            <div class="carousel-item">
                <img src="/assets/img/ejemplo.jpg" class="d-block w-100 img-carrusel-small">
            </div>

        </div>
    </div>

</div>
</section>

<?php MostrarFooter(); ?>
<?php IncluirScripts(); ?>

</body>
</html>