<div class="container">
    <button class="button is-link mt-4" onclick="window.history.back();">Regresar</button>
    <h1 class="title has-text-centered">Nueva Asignación de Equipo</h1>
    <form action="./php/asignacion_equipo_guardar.php" method="POST" class="box">
        <div class="field">
            <label class="label">Usuario</label>
            <div class="control">
                <div class="select is-fullwidth">
                    <select name="id_usuario" required>
                        <?php
                        require_once "./php/main.php";
                        $usuarios = conexion()->query("SELECT usuario_id, usuario_nombre FROM usuario");
                        foreach($usuarios as $usuario){
                            echo "<option value='{$usuario['usuario_id']}'>{$usuario['usuario_nombre']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="field">
            <label class="label">Equipo</label>
            <div class="control">
                <div class="select is-fullwidth">
                    <select name="id_equipo" required>
                        <option value="">Seleccione un equipo</option>
                        <?php
                        $equipos = conexion()->query("SELECT id_equipo, sku, numero_serie FROM equipo");
                        foreach($equipos as $equipo){
                            echo "<option value='{$equipo['id_equipo']}'>{$equipo['sku']} - {$equipo['numero_serie']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="field">
            <label class="label">Fecha de Asignación</label>
            <div class="control">
                <input class="input" type="date" name="fecha_asignacion" required>
            </div>
        </div>
        <div class="field">
            <label class="label">Fecha de Regreso</label>
            <div class="control">
                <input class="input" type="date" name="fecha_regreso">
            </div>
        </div>
        <div class="field">
            <label class="label">Motivo</label>
            <div class="control">
                <input class="input" type="text" name="motivo">
            </div>
        </div>
        <div class="field">
            <button class="button is-primary" type="submit">Asignar</button>
        </div>
    </form>
</div>