<div class="container is-fluid mb-6">
    <button class="button is-link mt-4" onclick="window.history.back();">Regresar</button>
    <h1 class="title has-text-centered">
        <span class="icon-text">
            <span class="icon">
                <i class="fas fa-desktop"></i>
            </span>
            <span>Equipos</span>
        </span>
    </h1>
    <h2 class="subtitle has-text-grey">Registrar nuevo equipo</h2>
</div>

<div class="container pb-3 pt-3">

    <a href="index.php?vista=equipo_lista" class="button is-light is-rounded mb-4">
        <span class="icon"><i class="fas fa-arrow-left"></i></span>
        <span>Regresar a la lista</span>
    </a>

    <form action="./php/equipo_guardar.php" method="POST" class="box" autocomplete="off">
        <div class="columns is-centered">
            <div class="column is-half">
                <div class="field">
                    <label class="label">Descripción</label>
                    <div class="control has-icons-left">
                        <div class="select is-fullwidth is-rounded">
                            <select name="id_descripcion_equipo" required>
                                <option value="">Seleccione una descripción</option>
                                <?php
                                require_once "./php/main.php";
                                $descripciones = conexion()->query("SELECT id_descripcion_equipo, nombre FROM descripcion_equipo");
                                foreach($descripciones as $desc){
                                    echo "<option value='{$desc['id_descripcion_equipo']}'>{$desc['nombre']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <span class="icon is-small is-left">
                            <i class="fas fa-list"></i>
                        </span>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Número de Serie</label>
                    <div class="control has-icons-left">
                        <input class="input is-rounded" type="text" name="numero_serie" required placeholder="Ejemplo: SN123456">
                        <span class="icon is-small is-left">
                            <i class="fas fa-barcode"></i>
                        </span>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Fecha de Adquisición</label>
                    <div class="control has-icons-left">
                        <input class="input is-rounded" type="date" name="fecha_adquisicion" required>
                        <span class="icon is-small is-left">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                    </div>
                </div>
                <div class="field">
                    <label class="label">SKU</label>
                    <div class="control has-icons-left">
                        <input class="input is-rounded" type="text" name="sku" maxlength="50" required placeholder="Ejemplo: LAP-001">
                        <span class="icon is-small is-left">
                            <i class="fas fa-barcode"></i>
                        </span>
                    </div>
                </div>
                <div class="field is-grouped is-grouped-centered mt-5">
                    <div class="control">
                        <button class="button is-success is-rounded is-medium" type="submit">
                            <span class="icon">
                                <i class="fas fa-save"></i>
                            </span>
                            <span>Guardar</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>