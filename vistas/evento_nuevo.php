<?php require_once "./php/main.php"; ?>
<div class="container is-fluid mb-6">
    <button class="button is-link mt-4" onclick="window.history.back();">Regresar</button>
    <h1 class="title has-text-centered">Nuevo Evento</h1>
</div>
<div class="container pb-6 pt-6">
    <form action="./php/evento_guardar.php" method="POST" enctype="multipart/form-data" id="formEvento" class="box" autocomplete="off">
        <div class="columns">
            <div class="column">
                <label class="label">Nombre del Evento</label>
                <input class="input" type="text" name="nombre" required>
            </div>
            <div class="column">
                <label class="label">Lugar</label>
                <div style="display: flex; gap: 8px;">
                    <div class="select is-fullwidth" style="flex:1;">
                        <select name="id_lugar" required>
                            <option value="">Seleccione un lugar</option>
                            <?php
                            $lugares = conexion()->query("SELECT * FROM lugar");
                            foreach($lugares as $lugar){
                                echo "<option value='{$lugar['id_lugar']}'>{$lugar['nombre']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <a href="index.php?vista=lugar_nuevo" class="button is-success is-small" title="Agregar Lugar" style="height: 2.25em;">
                        <span class="icon"><i class="fas fa-plus"></i></span> <strong>+</strong>
                    </a>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <label class="label">Fecha de Inicio</label>
                <input class="input" type="date" name="fecha_inicio" required>
            </div>
            <div class="column">
                <label class="label">Fecha de Fin</label>
                <input class="input" type="date" name="fecha_fin" required>
            </div>
            <div class="column">
                <label class="label">Horario</label>
                <input class="input" type="text" name="horario">
            </div>
        </div>
        <div class="field">
            <label class="label">Observaciones</label>
            <textarea class="textarea" name="observaciones"></textarea>
        </div>
        <!-- Tareas asignadas -->
        <div class="box">
            <h2 class="subtitle">Tareas asignadas al evento</h2>
            <div id="tareas-lista"></div>
            <div class="field is-grouped">
                <div class="control">
                    <input class="input" type="text" id="tarea_titulo" placeholder="Título de la tarea">
                </div>
                <div class="control">
                    <input class="input" type="text" id="tarea_descripcion" placeholder="Descripción">
                </div>
                <div class="control">
                    <input class="input" type="date" id="tarea_fecha_vencimiento">
                </div>
                <div class="control">
                    <select class="input" id="tarea_usuario_asignado">
                        <option value="">Asignar a...</option>
                        <?php
                        $usuarios = conexion()->query("SELECT usuario_id, usuario_nombre, usuario_apellido FROM usuario")->fetchAll(PDO::FETCH_ASSOC);
                        foreach($usuarios as $u){
                            echo "<option value='{$u['usuario_id']}'>".htmlspecialchars($u['usuario_nombre'].' '.$u['usuario_apellido'])."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="control">
                    <input class="input" type="text" id="tarea_comentarios" placeholder="Comentarios">
                </div>
                <div class="control">
                    <button type="button" class="button is-success" onclick="agregarTarea()">Agregar tarea</button>
                </div>
            </div>
            <input type="hidden" name="tareas_completas_json" id="tareas_completas_json">
        </div>

        <hr style="margin-top: 2.5rem; margin-bottom: 2.5rem;">
        <div class="field">
            <label class="label">Prioridad</label>
            <div class="select">
                <select name="prioridad">
                    <option value="Alta">Alta</option>
                    <option value="Media">Media</option>
                    <option value="Baja">Baja</option>
                </select>
            </div>
        </div>
        <div class="field">
            <label class="label">Recursos Estimados</label>
            <textarea class="textarea" name="recursos_estimados" placeholder="Un recurso por línea"></textarea>
        </div>
        <div class="field">
            <label class="label">Costos Estimados</label>
            <input class="input" type="number" name="costos_estimados" min="0" step="0.01" pattern="\d+(\.\d{1,2})?" placeholder="0.00">
        </div>
        <div class="field">
            <label class="label">Archivos Adjuntos</label>
            <input class="input" type="file" name="archivos_adjuntos[]" multiple>
        </div>
        <div class="field is-grouped is-grouped-centered" style="margin-top: 2rem;">
            <div class="control">
                <button type="submit" class="button is-success is-medium" style="padding-left:2.5em; padding-right:2.5em;">
                    <span class="icon"><i class="fas fa-save"></i></span>
                    <span>Guardar Evento</span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
let tareas = [];

function agregarTarea() {
    const titulo = document.getElementById('tarea_titulo').value.trim();
    const descripcion = document.getElementById('tarea_descripcion').value.trim();
    const fecha_vencimiento = document.getElementById('tarea_fecha_vencimiento').value;
    const usuario_asignado = document.getElementById('tarea_usuario_asignado').value;
    const usuario_nombre = document.getElementById('tarea_usuario_asignado').selectedOptions[0]?.text || '';
    const comentarios = document.getElementById('tarea_comentarios').value.trim();

    if (!titulo || !usuario_asignado) {
        alert('El título y el usuario asignado son obligatorios.');
        return;
    }

    tareas.push({
        titulo,
        descripcion,
        fecha_vencimiento,
        usuario_asignado,
        usuario_nombre,
        comentarios
    });

    mostrarTareas();
    document.getElementById('tarea_titulo').value = '';
    document.getElementById('tarea_descripcion').value = '';
    document.getElementById('tarea_fecha_vencimiento').value = '';
    document.getElementById('tarea_usuario_asignado').selectedIndex = 0;
}

function mostrarTareas() {
    const lista = document.getElementById('tareas-lista');
    lista.innerHTML = '';
    if (tareas.length === 0) {
        lista.innerHTML = "<p class='has-text-grey'>No hay tareas agregadas.</p>";
    } else {
        let html = "<table class='table is-fullwidth is-striped'><thead><tr><th>Título</th><th>Descripción</th><th>Vence</th><th>Asignado a</th><th>Quitar</th></tr></thead><tbody>";
        tareas.forEach((t, i) => {
            html += `<tr>
                <td>${t.titulo}</td>
                <td>${t.descripcion}</td>
                <td>${t.fecha_vencimiento}</td>
                <td>${t.usuario_nombre}</td>
                <td><button type="button" class="button is-danger is-small" onclick="quitarTarea(${i})">Quitar</button></td>
            </tr>`;
        });
        html += "</tbody></table>";
        lista.innerHTML = html;
    }
    document.getElementById('tareas_completas_json').value = JSON.stringify(tareas);
}

function quitarTarea(idx) {
    tareas.splice(idx, 1);
    mostrarTareas();
}

// Inicializar lista vacía
mostrarTareas();
</script>