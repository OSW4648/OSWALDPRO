<?php
require_once "./php/main.php";
$conexion = conexion();
$areas = $conexion->query("SELECT id_area, nombre FROM area ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);
$vendedores = $conexion->query("SELECT id, nombre, area_id FROM vendedor ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container is-fluid mb-6">
    <button class="button is-link mt-4" onclick="window.history.back();">Regresar</button>
    <h1 class="title has-text-centered">Nuevo Bordado(Vista Previa Avanzada)</h1>
</div>
<div class="container pb-6 pt-6">
    <form action="./php/bordado_guardar.php" method="POST" class="box" autocomplete="off" enctype="multipart/form-data" id="form-bordado">
        <div class="columns is-multiline">
            <div class="column is-4">
                <label class="label">Sucursal</label>
                <div class="select is-fullwidth">
                    <select name="area_id" required>
                        <option value="">Selecciona la sucursal</option>
                        <?php foreach($areas as $a): ?>
                            <option value="<?php echo $a['id_area']; ?>"><?php echo htmlspecialchars($a['nombre'] ?? ''); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="column is-4">
                <label class="label">Vendedor</label>
                <div class="select is-fullwidth">
                    <select name="vendedor_id" required>
                        <option value="">Selecciona vendedor</option>
                        <?php foreach($vendedores as $v): ?>
                            <option value="<?php echo $v['id']; ?>"><?php echo htmlspecialchars($v['nombre'] ?? ''); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="column is-4">
                <label class="label">Cliente</label>
                <input class="input" type="text" name="cliente" required>
            </div>
            <div class="column is-4">
                <label class="label">Empresa</label>
                <input class="input" type="text" name="departamento">
            </div>
            <div class="column is-4">
                <label class="label">Número de contacto</label>
                <input class="input" type="text" name="numero_contratacion">
            </div>
            <div class="column is-4">
                <label class="label">Fecha de solicitud</label>
                <input class="input" type="date" name="fecha_solicitud" required>
            </div>
            <div class="column is-4">
                <label class="label">Tipo/tela y color</label>
                <input class="input" type="text" name="tipo_tela_color">
            </div>
            <div class="column is-4">
                <label class="label">Folio de ticket</label>
                <input class="input" type="text" name="folio_ticket" required>
            </div>
        </div>
        <hr>
        <div class="columns">
            <!-- Columna de Logotipos -->
            <div class="column is-6">
                <div class="box">
                    <h2 class="subtitle">Logotipos</h2>
                    <div id="logos-container"></div>
                    <button type="button" class="button is-link is-light is-small" id="btn-agregar-logo">
                        <span class="icon"><i class="fas fa-plus"></i></span>
                        <span>Agregar logo</span>
                    </button>
                </div>
            </div>
            <!-- Columna de Textos -->
            <div class="column is-6">
                <div class="box">
                    <h2 class="subtitle">Textos</h2>
                    <div id="textos-container"></div>
                    <button type="button" class="button is-link is-light is-small" id="btn-agregar-texto">
                        <span class="icon"><i class="fas fa-plus"></i></span>
                        <span>Agregar texto</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- DETALLES POR PRENDA -->
        <div class="box" style="margin-bottom: 1.5rem;">
            <h2 class="subtitle has-text-centered">Detalles por prenda</h2>
            <table class="table is-fullwidth" id="detalles-prenda-table">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Talla</th>
                        <th>Cantidad</th>
                        <th>Nombre/Descripción</th>
                        <th>Tipografía</th>
                        <th>Código de hilo</th>
                        <th>Quitar</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Las filas se agregan con JS -->
                </tbody>
            </table>
            <div class="has-text-centered" style="margin-top: 10px;">
                <button type="button" class="button is-link" id="btn-agregar-detalle-prenda">
                    <span class="icon"><i class="fas fa-plus"></i></span>
                    <span>Agregar prenda</span>
                </button>
            </div>
        </div>
        <!-- VISTA PREVIA -->
        <div class="field">
            <label class="label">Vista previa:</label>
            <div id="preview-area" style="width:600px; height:960px; position:relative; margin-bottom:10px;">
                <img id="prenda_base" src="/assets/prenda_base.png">
                <!-- Botones de tamaño -->
                <div id="botones-tamano" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); z-index:10; display:flex; flex-direction:column; gap:8px;">
                    <button type="button" class="button is-small" id="btn-mas-grande" title="Más grande"><i class="fas fa-plus"></i></button>
                    <button type="button" class="button is-small" id="btn-mas-chico" title="Más chica"><i class="fas fa-minus"></i></button>
                </div>
                <!-- Los logos y textos se agregan aquí dinámicamente -->
            </div>
        </div>
        <!-- Selector de prenda base -->
        <div class="field">
            <label class="label">Tipo de prenda base:</label>
            <div class="select">
                <select id="select-prenda-base">
                    <option value="/assets/prenda_base-1.png">Prenda 1</option>
                    <option value="/assets/prenda_base2.png">Prenda 2</option>
                    <option value="/assets/prenda_base3.png">Prenda 3</option>
                    <option value="/assets/prenda_base4.png">Prenda 4</option>
                </select>
            </div>
        </div>
        <input type="hidden" name="logotipo_img_final" id="logotipo_img_final">
        <div class="field is-grouped is-grouped-centered mt-5">
            <div class="control">
                <button type="button" class="button is-success is-rounded is-medium mt-4" id="btn-guardar">
                    <span class="icon"><i class="fas fa-save"></i></span>
                    <span>Guardar</span>
                </button>
            </div>
        </div>
    </form>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.4/css/bulma.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
// --- LOGOS ---
let logoCount = 0;
const logosContainer = document.getElementById('logos-container');
const previewArea = document.getElementById('preview-area');
const logos = [];

function agregarLogoInput() {
    const idx = logoCount++;
    const div = document.createElement('div');
    div.className = 'box mb-3';
    div.innerHTML = `
        <div class="columns is-vcentered is-mobile">
            <div class="column is-7">
                <label class="label mb-1">Logo ${idx+1}</label>
                <input class="input mb-2" type="file" accept="image/*" id="input_logo_${idx}">
            </div>
            <div class="column is-5 has-text-right">
                <button type="button" class="button is-danger is-light is-small" id="btn-quitar-logo-${idx}" title="Quitar logo">
                    <span class="icon"><i class="fas fa-trash"></i></span>
                    <span>Quitar</span>
                </button>
            </div>
        </div>
    `;
    logosContainer.appendChild(div);

    // Vista previa y movimiento
    div.querySelector('input').addEventListener('change', function() {
        if(this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                // Crear logo en preview
                const logoImg = document.createElement('img');
                logoImg.src = ev.target.result;
                logoImg.className = 'logo-preview';
                logoImg.style.position = 'absolute';
                // POSICIÓN CENTRADA EN EL ÁREA DE PREVIEW (cuadro azul)
                logoImg.style.top = (previewArea.offsetHeight/2 - 60) + 'px';
                logoImg.style.left = (previewArea.offsetWidth/2 - 60) + 'px';
                logoImg.style.width = '120px';
                logoImg.style.height = '120px';
                logoImg.style.cursor = 'move';
                logoImg.style.zIndex = 2;
                logoImg.setAttribute('data-x', previewArea.offsetWidth/2 - 60);
                logoImg.setAttribute('data-y', previewArea.offsetHeight/2 - 60);
                logoImg.setAttribute('data-idx', idx);
                previewArea.appendChild(logoImg);
                logos[idx] = logoImg;

                // Drag & resize
                makeDraggableResizable(logoImg);

                // Quitar logo
                div.querySelector(`#btn-quitar-logo-${idx}`).onclick = function() {
                    logoImg.remove();
                    div.remove();
                    logos[idx] = null;
                }
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
}
document.getElementById('btn-agregar-logo').addEventListener('click', agregarLogoInput);
agregarLogoInput();

// --- TEXTOS ---
let textoCount = 0;
const textosContainer = document.getElementById('textos-container');
const textos = [];

function agregarTextoInput() {
    const idx = textoCount++;
    const div = document.createElement('div');
    div.className = 'box mb-3';
    div.innerHTML = `
        <div class="columns is-vcentered is-mobile">
            <div class="column is-5">
                <label class="label mb-1">Texto ${idx+1}</label>
                <input class="input mb-2" type="text" maxlength="30" id="input_texto_${idx}" placeholder="Escribe el texto a bordar">
            </div>
            <div class="column is-3">
                <label class="label mb-1">Fuente</label>
                <div class="select is-fullwidth mb-2">
                    <select id="fuente_texto_${idx}">
                        <option value="Arial">Arial</option>
                        <option value="Verdana">Verdana</option>
                        <option value="Times New Roman">Times New Roman</option>
                        <option value="Comic Sans MS">Comic Sans MS</option>
                        <option value="Courier New">Courier New</option>
                    </select>
                </div>
            </div>
            <div class="column is-2">
                <label class="label mb-1">Color</label>
                <input type="color" id="color_texto_${idx}" value="#000000" class="input mb-2" style="height:2.2em;">
            </div>
            <div class="column is-2 has-text-right">
                <div class="buttons are-small">
                    <button type="button" class="button is-info" id="btn-texto-chico-${idx}" title="Reducir tamaño"><span class="icon"><i class="fas fa-minus"></i></span></button>
                    <button type="button" class="button is-info" id="btn-texto-grande-${idx}" title="Aumentar tamaño"><span class="icon"><i class="fas fa-plus"></i></span></button>
                    <button type="button" class="button is-warning" id="btn-texto-negrita-${idx}" title="Negrita"><b>B</b></button>
                    <button type="button" class="button is-danger is-light" id="btn-quitar-texto-${idx}" title="Quitar texto"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        </div>
    `;
    textosContainer.appendChild(div);

    // Crear texto en preview
    const span = document.createElement('span');
    span.className = 'texto-preview';
    span.style.position = 'absolute';
    span.style.top = (300 + idx*40) + 'px';
    span.style.left = '120px';
    span.style.fontSize = '32px';
    span.style.fontFamily = 'Arial';
    span.style.color = '#000';
    span.style.cursor = 'move';
    span.style.zIndex = 3;
    span.style.fontWeight = 'normal';
    span.textContent = '';
    span.setAttribute('data-x', 120);
    span.setAttribute('data-y', 300 + idx*40);
    span.setAttribute('data-idx', idx);
    previewArea.appendChild(span);
    textos[idx] = {span, tamano:32, negrita:false};

    // Eventos para actualizar texto y formato
    div.querySelector(`#input_texto_${idx}`).addEventListener('input', function() {
        span.textContent = this.value;
        span.style.display = this.value.trim() ? 'block' : 'none';
    });
    div.querySelector(`#fuente_texto_${idx}`).addEventListener('change', function() {
        span.style.fontFamily = this.value;
    });
    div.querySelector(`#color_texto_${idx}`).addEventListener('input', function() {
        span.style.color = this.value;
    });
    div.querySelector(`#btn-texto-chico-${idx}`).addEventListener('click', function() {
        if(textos[idx].tamano > 10) {
            textos[idx].tamano -= 2;
            span.style.fontSize = textos[idx].tamano + 'px';
        }
    });
    div.querySelector(`#btn-texto-grande-${idx}`).addEventListener('click', function() {
        if(textos[idx].tamano < 80) {
            textos[idx].tamano += 2;
            span.style.fontSize = textos[idx].tamano + 'px';
        }
    });
    div.querySelector(`#btn-texto-negrita-${idx}`).addEventListener('click', function() {
        textos[idx].negrita = !textos[idx].negrita;
        span.style.fontWeight = textos[idx].negrita ? 'bold' : 'normal';
    });
    // Quitar texto
    div.querySelector(`#btn-quitar-texto-${idx}`).onclick = function() {
        span.remove();
        div.remove();
        textos[idx] = null;
    }

    // Drag & resize
    makeDraggableResizable(span);
}
document.getElementById('btn-agregar-texto').addEventListener('click', agregarTextoInput);
agregarTextoInput();

// --- DETALLES POR PRENDA ---
let detallePrendaCount = 0;
function agregarFilaDetallePrenda() {
    const tabla = document.getElementById('detalles-prenda-table').getElementsByTagName('tbody')[0];
    const idx = detallePrendaCount++;
    const fila = tabla.insertRow();

    // SKU
    let celdaSKU = fila.insertCell(0);
    celdaSKU.innerHTML = `<input class="input" type="text" name="detalles_prenda[${idx}][sku]" placeholder="SKU" required>`;

    // Talla
    let celdaTalla = fila.insertCell(1);
    celdaTalla.innerHTML = `<select class="input" name="detalles_prenda[${idx}][talla]" required>
        <option value="">Selecciona talla</option>
        <option value="XS">XS</option>
        <option value="S">S</option>
        <option value="M">M</option>
        <option value="L">L</option>
        <option value="XL">XL</option>
        <option value="XXL">XXL</option>
        <option value="3XL">3XL</option>
        <option value="4XL">4XL</option>
    </select>`;

    // Cantidad
    let celdaCantidad = fila.insertCell(2);
    celdaCantidad.innerHTML = `<input class="input" type="number" name="detalles_prenda[${idx}][cantidad]" placeholder="Cantidad" min="1" required>`;

    // Descripción/Nombre
    let celdaDescripcion = fila.insertCell(3);
    celdaDescripcion.innerHTML = `<input class="input" type="text" name="detalles_prenda[${idx}][descripcion]" placeholder="Nombre o descripción" required>`;

    // Tipografía
    let celdaTipografia = fila.insertCell(4);
    celdaTipografia.innerHTML = `<input class="input" type="text" name="detalles_prenda[${idx}][tipografia]" placeholder="Tipografía" required>`;

    // Código de hilo
    let celdaCodigoHilo = fila.insertCell(5);
    celdaCodigoHilo.innerHTML = `<input class="input" type="text" name="detalles_prenda[${idx}][codigo_hilo]" placeholder="Código de hilo" required>`;

    // Quitar
    let celdaQuitar = fila.insertCell(6);
    celdaQuitar.innerHTML = `<button type="button" class="button is-danger is-light" onclick="this.closest('tr').remove()">Quitar</button>`;
}
document.getElementById('btn-agregar-detalle-prenda').addEventListener('click', agregarFilaDetallePrenda);
// Inicializa con una fila
agregarFilaDetallePrenda();

// --- DRAG & RESIZE ---
function makeDraggableResizable(el) {
    let dragging = false, resizing = false, startX, startY, startW, startH;
    el.addEventListener('mousedown', function(e) {
        if (e.target.classList.contains('resize-handle')) {
            resizing = true;
            startX = e.clientX;
            startY = e.clientY;
            startW = parseInt(el.style.width) || el.offsetWidth;
            startH = parseInt(el.style.height) || el.offsetHeight;
        } else {
            dragging = true;
            startX = e.clientX - (parseInt(el.style.left) || 0);
            startY = e.clientY - (parseInt(el.style.top) || 0);
        }
        e.preventDefault();
    });
    document.addEventListener('mousemove', function(e) {
        if (dragging) {
            let x = e.clientX - startX;
            let y = e.clientY - startY;
            // Limita dentro del área
            x = Math.max(0, Math.min(x, previewArea.offsetWidth - el.offsetWidth));
            y = Math.max(0, Math.min(y, previewArea.offsetHeight - el.offsetHeight));
            el.style.left = x + 'px';
            el.style.top = y + 'px';
        }
        if (resizing) {
            let w = startW + (e.clientX - startX);
            let h = startH + (e.clientY - startY);
            w = Math.max(30, Math.min(w, 400));
            h = Math.max(30, Math.min(h, 400));
            el.style.width = w + 'px';
            el.style.height = h + 'px';
            if(el.tagName === 'SPAN') el.style.fontSize = w/3 + 'px';
        }
    });
    document.addEventListener('mouseup', function() {
        dragging = false;
        resizing = false;
    });
    // Agrega un "handle" para redimensionar solo a los logos
    if(el.tagName === 'IMG') {
        const handle = document.createElement('div');
        handle.className = 'resize-handle';
        handle.style.position = 'absolute';
        handle.style.right = '-8px';
        handle.style.bottom = '-8px';
        handle.style.width = '16px';
        handle.style.height = '16px';
        handle.style.background = '#3273dc';
        handle.style.borderRadius = '50%';
        handle.style.cursor = 'nwse-resize';
        handle.style.zIndex = 10;
        el.parentElement.appendChild(handle);
        handle.addEventListener('mousedown', function(e) {
            resizing = true;
            startX = e.clientX;
            startY = e.clientY;
            startW = parseInt(el.style.width) || el.offsetWidth;
            startH = parseInt(el.style.height) || el.offsetHeight;
            e.stopPropagation();
            e.preventDefault();
        });
    }
}

// --- GUARDAR ---
document.getElementById('btn-guardar').addEventListener('click', function() {
    const canvas = document.createElement('canvas');
    canvas.width = 1200; // el doble para mejor calidad
    canvas.height = 1920;
    const ctx = canvas.getContext('2d');
    const baseImg = document.getElementById('prenda_base');
    ctx.drawImage(baseImg, 0, 0, canvas.width, canvas.height);

    const previewW = previewArea.offsetWidth;
    const previewH = previewArea.offsetHeight;
    const canvasW = canvas.width;
    const canvasH = canvas.height;
    const scaleX = canvasW / previewW;
    const scaleY = canvasH / previewH;

    // Logos
    logos.forEach(function(logoImg) {
        if(logoImg && logoImg.src) {
            const x = (parseInt(logoImg.style.left) || 0) * scaleX;
            const y = (parseInt(logoImg.style.top) || 0) * scaleY;
            const w = (parseInt(logoImg.style.width) || 120) * scaleX;
            const h = (parseInt(logoImg.style.height) || 120) * scaleY;
            ctx.drawImage(logoImg, x, y, w, h);
        }
    });
    // Textos
    textos.forEach(function(txt) {
        if(txt && txt.span && txt.span.textContent.trim()) {
            ctx.font = `${txt.negrita ? 'bold ' : ''}${(parseInt(txt.span.style.fontSize)||32)*scaleY}px ${txt.span.style.fontFamily}`;
            ctx.fillStyle = txt.span.style.color;
            const tx = (parseInt(txt.span.style.left) || 0) * scaleX;
            const ty = (parseInt(txt.span.style.top) || 0) * scaleY + (parseInt(txt.span.style.fontSize)||32)*scaleY;
            ctx.fillText(txt.span.textContent, tx, ty);
        }
    });
    document.getElementById('logotipo_img_final').value = canvas.toDataURL("image/png");
    document.getElementById('form-bordado').submit();
});

// Cambiar prenda base
const prendaBaseImg = document.getElementById('prenda_base');
document.getElementById('select-prenda-base').addEventListener('change', function() {
    prendaBaseImg.src = this.value;
});

// Botones para cambiar tamaño del logo/texto seleccionado
let elementoSeleccionado = null;

// Selección de logo/texto al hacer click
previewArea.addEventListener('click', function(e) {
    if(e.target.classList.contains('logo-preview') || e.target.classList.contains('texto-preview')) {
        elementoSeleccionado = e.target;
        // Opcional: resaltar el seleccionado
        document.querySelectorAll('.logo-preview, .texto-preview').forEach(el => el.style.outline = '');
        elementoSeleccionado.style.outline = '2px solid #3273dc';
    }
});

// Botón más grande
document.getElementById('btn-mas-grande').addEventListener('click', function() {
    if(elementoSeleccionado) {
        let w = elementoSeleccionado.offsetWidth * 1.1;
        let h = elementoSeleccionado.offsetHeight * 1.1;
        elementoSeleccionado.style.width = w + "px";
        elementoSeleccionado.style.height = h + "px";
        if(elementoSeleccionado.tagName === 'SPAN') elementoSeleccionado.style.fontSize = w/3 + 'px';
    }
});

// Botón más chico
document.getElementById('btn-mas-chico').addEventListener('click', function() {
    if(elementoSeleccionado) {
        let w = elementoSeleccionado.offsetWidth * 0.9;
        let h = elementoSeleccionado.offsetHeight * 0.9;
        elementoSeleccionado.style.width = w + "px";
        elementoSeleccionado.style.height = h + "px";
        if(elementoSeleccionado.tagName === 'SPAN') elementoSeleccionado.style.fontSize = w/3 + 'px';
    }
});
</script>
<style>
/* Mejora visual de los handles y elementos */
.resize-handle {
    box-shadow: 0 1px 4px rgba(50,115,220,0.2);
}
.logo-preview, .texto-preview {
    box-shadow: 0 2px 8px rgba(50,115,220,0.08);
    user-select: none;
}
#preview-area {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    width: 600px;
    height: 960px;
    border: 2px solid #3273dc;
    margin-bottom: 10px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(50,115,220,0.08);
    overflow: hidden;
}

#prenda_base {
    position: relative;
    max-width: 80%;
    max-height: 80%;
    width: auto;
    height: auto;
    display: block;
    margin: auto;
    z-index: 1;
    border-radius: 10px;
}

/* Estilos para los botones de tamaño */
.button.is-small {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}
</style>