<?php
  include('layout.php'); 
  include_once __DIR__ . '/../Controller/usuarioController.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Óptica Grisol</title>
  <?php IncluirCSS(); ?>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    :root {
      --bg: #f4f6f9;
      --card: #ffffff;
      --text: #2a2f3a;
      --muted: #6b7280;
      --accent: #0d6efd;
      --accent-dark: #0b5ed7;
      --selected: #d9f9e8;
      --selected-border: #26a37a;
      --slot-border: #dde2ea;
      --shadow-strong: rgba(0,0,0,0.06);
      --font-size-base: 18px;
      --navbar-green: #198754;
    }

    .theme-dark {
      --bg: #0f1623;
      --card: #1a2233;
      --text: #e6eaf2;
      --muted: #a8b0c0;
      --accent: #5aa2ff;
      --accent-dark: #418ef0;
      --selected: #173f34;
      --selected-border: #2ac39a;
      --slot-border: #2d3b57;
      --shadow-strong: rgba(0,0,0,0.35);
      --navbar-green: #198754;
    }

    body {
      font-family: 'Noto Sans', sans-serif;
      font-size: var(--font-size-base);
      background: var(--bg);
      color: var(--text);
      margin: 0;
      min-height: 100vh;
    }

    .app-header {
      background: var(--card);
      box-shadow: 0 2px 4px var(--shadow-strong);
      padding: 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .title {
      font-size: 1.75rem;
      font-weight: 700;
      margin: 0;
    }

    .calendar-frame {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      gap: .5rem;
      padding: 1rem;
    }

    .day {
      background: var(--card);
      border-radius: 12px;
      padding: .5rem;
      box-shadow: 0 2px 4px var(--shadow-strong);
      transition: background 0.3s;
    }

    .theme-dark .day {
      background: #1a2233;
      color: #ffffff;
    }

    .day h5 {
      font-weight: 700;
      font-size: 1.1rem;
      margin-bottom: .5rem;
    }

    .time-slot {
      display: block;
      border: 1px solid var(--slot-border);
      border-radius: 8px;
      padding: .4rem;
      margin-bottom: .4rem;
      cursor: pointer;
      background: #fffef0;
      text-align: center;
      transition: background 0.2s, color 0.2s;
    }

    .theme-dark .time-slot {
      background: #2a3246;
      color: #fff;
    }

    .time-slot:hover {
      background: #fff8cc;
    }

    .theme-dark .time-slot:hover {
      background: #3a4460;
    }

    .time-slot.selected {
      border-color: var(--selected-border);
      background: var(--selected);
      font-weight: 600;
    }

    .week-control {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 1rem 0;
      gap: .5rem;
    }

    .switch-wrapper {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-weight: 600;
      color: var(--text);
    }

    .theme-dark .switch-wrapper {
      color: #fff;
    }

    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 30px;
    }

    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0; left: 0;
      right: 0; bottom: 0;
      background-color: var(--slot-border);
      transition: 0.4s;
      border-radius: 30px;
    }

    .slider::before {
      position: absolute;
      content: "";
      height: 26px; width: 26px;
      left: 2px;
      bottom: 2px;
      background-color: white;
      transition: 0.4s;
      border-radius: 50%;
    }

    input:checked + .slider::before {
      transform: translateX(30px);
    }

    /* MODAL HEADER VERDE */
    .modal-header {
      background-color: var(--navbar-green);
      color: white;
    }

    .modal-header .btn-close {
      filter: invert(1);
    }

    /* MODO NOCHE PARA MODAL DE DATOS */
    .theme-dark .modal-content {
      background-color: var(--card);
      color: var(--text);
    }

    .theme-dark .modal-content .form-control {
      background-color: #2a3246;
      color: #fff;
      border-color: #3a4460;
    }

    .theme-dark .modal-content .form-control::placeholder {
      color: #a8b0c0;
    }

    .theme-dark .modal-content .alert-info {
      background-color: #173f34;
      color: #fff;
      border-color: #2ac39a;
    }

    /* ESTILO PARA DATE INPUT */
    #datePicker {
      border-radius: 8px;
      border: 1px solid var(--accent);
      padding: 0.3rem 0.5rem;
      cursor: pointer;
      font-weight: 600;
      background-color: var(--card);
      color: var(--text);
    }

    .theme-dark #datePicker {
      background-color: #2a3246;
      color: #fff;
      border-color: var(--accent);
    }

  </style>
</head>

<body>
  <?php MostrarMenu(); ?>

  <!-- HEADER -->
  <header class="app-header">
    <h1 class="title">Agendar Cita</h1>
    <div class="switch-wrapper">
      <label class="switch">
        <input type="checkbox" id="toggleTheme">
        <span class="slider"></span>
      </label>
      <span id="themeLabel">Modo noche</span>
    </div>
  </header>

  <!-- CONTENEDOR PRINCIPAL -->
  <main class="container my-3">
    <div class="week-control">
      <button class="btn btn-primary" id="prevWeek">← Semana anterior</button>
      <input type="date" id="datePicker">
      <button class="btn btn-primary" id="nextWeek">Semana siguiente →</button>
    </div>

    <section class="calendar-frame" id="calendarGrid"></section>
  </main>

  <!-- MODAL DE FORMULARIO -->
  <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="formModalLabel">Datos del paciente</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div id="selectionPreview" class="alert alert-info">Sin selección</div>
          <form action="forms/appointment.php" method="post">
            <input type="hidden" name="date" id="selectedDate">
            <input type="hidden" name="time" id="selectedTime">
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Cédula</label>
                <input type="text" class="form-control" name="id" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="Name" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Apellidos</label>
                <input type="text" class="form-control" name="name" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Edad</label>
                <input type="number" class="form-control" name="edad" min="1" max="120" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" name="email" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Teléfono</label>
                <input type="tel" class="form-control" name="phone" required>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Mensaje (opcional)</label>
              <textarea class="form-control" name="message" rows="3"></textarea>
            </div>
            <div class="d-flex justify-content-end gap-2">
              <button type="submit" class="btn btn-primary">Agendar Cita</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php MostrarFooter(); ?>
  <?php IncluirScripts(); ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // ======= ESTADO REACTIVO =======
    const state = new Proxy({
      currentMonday: new Date(),
      selectedDate: '',
      selectedTime: '',
      darkMode: false,
    }, {
      set(target, prop, value) {
        target[prop] = value;
        if(prop === 'currentMonday') renderWeek(value);
        if(prop === 'darkMode') document.body.classList.toggle('theme-dark', value);
        if(prop === 'selectedDate' || prop === 'selectedTime') updatePreview();
        return true;
      }
    });

    const calendarGrid = document.getElementById("calendarGrid");
    const formModal = new bootstrap.Modal(document.getElementById("formModal"));
    const selectionPreview = document.getElementById("selectionPreview");
    const datePicker = document.getElementById("datePicker");
    const toggleThemeCheckbox = document.getElementById("toggleTheme");
    const themeLabel = document.getElementById("themeLabel");

    function getMonday(d) {
      d = new Date(d);
      const day = d.getDay();
      const diff = d.getDate() - day + (day === 0 ? -6 : 1);
      return new Date(d.setDate(diff));
    }

    function updatePreview() {
      if(state.selectedDate && state.selectedTime) {
        const d = new Date(state.selectedDate);
        const options = { weekday: 'long', year: 'numeric', month: '2-digit', day: '2-digit' };
        selectionPreview.textContent = `Seleccionado: ${d.toLocaleDateString('es-ES', options)} a las ${state.selectedTime}`;
      }
    }

    function renderWeek(startDate) {
      calendarGrid.innerHTML = "";
      const daysOfWeek = ["Lunes","Martes","Miércoles","Jueves","Viernes","Sábado","Domingo"];
      datePicker.value = startDate.toISOString().split("T")[0];

      for(let i=0;i<7;i++){
        const dayDate = new Date(startDate);
        dayDate.setDate(startDate.getDate()+i);
        const isoDate = dayDate.toISOString().split("T")[0];

        const dayDiv = document.createElement("div");
        dayDiv.classList.add("day");
        dayDiv.innerHTML = `<h5>${daysOfWeek[i]}<br><small>${isoDate}</small></h5>`;

        for(let hour=8; hour<=16; hour++){
          const time = `${hour.toString().padStart(2,'0')}:00`;
          const slot = document.createElement("div");
          slot.classList.add("time-slot");
          slot.textContent = time;

          slot.addEventListener("click",()=> {
            document.querySelectorAll(".time-slot").forEach(s=>s.classList.remove("selected"));
            slot.classList.add("selected");
            state.selectedDate = isoDate;
            state.selectedTime = time;
            formModal.show();
          });

          dayDiv.appendChild(slot);
        }
        calendarGrid.appendChild(dayDiv);
      }
    }

    document.getElementById("prevWeek").addEventListener("click", ()=> {
      state.currentMonday.setDate(state.currentMonday.getDate()-7);
      state.currentMonday = getMonday(state.currentMonday);
    });

    document.getElementById("nextWeek").addEventListener("click", ()=> {
      state.currentMonday.setDate(state.currentMonday.getDate()+7);
      state.currentMonday = getMonday(state.currentMonday);
    });

    datePicker.addEventListener("change", ()=> {
      state.currentMonday = getMonday(new Date(datePicker.value));
    });

    toggleThemeCheckbox.addEventListener("change", ()=> {
      state.darkMode = toggleThemeCheckbox.checked;
      themeLabel.textContent = toggleThemeCheckbox.checked ? "Modo día" : "Modo noche";
    });

    // Inicialización
    state.currentMonday = getMonday(new Date());

  </script>
</body>
</html>
