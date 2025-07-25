<div class="container is-fluid mb-6">
    <button class="button is-link mt-4" onclick="window.history.back();">Regresar</button>
    <h1 class="title has-text-centered">
        <span class="icon-text">
            <span class="icon">
                <i class="fas fa-laptop"></i>
            </span>
            <span>Tipos de equipo</span>
        </span>
    </h1>
    <h2 class="subtitle has-text-grey">Nuevo tipo de equipo</h2>
</div>

<div class="container pb-6 pt-6">

    <a href="index.php?vista=category_list" class="button is-light is-rounded mb-4">
        <span class="icon"><i class="fas fa-arrow-left"></i></span>
        <span>Regresar a la lista</span>
    </a>

    <div class="form-rest mb-6 mt-6"></div>
    <form action="./php/categoria_guardar.php" method="POST" class="FormularioAjax box" autocomplete="off">
        <div class="columns is-centered">
            <div class="column is-half">
                <div class="field">
                    <label class="label">Nombre</label>
                    <div class="control has-icons-left">
                        <input class="input is-rounded" type="text" name="categoria_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{2,100}" maxlength="100" required placeholder="Ejemplo: Laptop, Impresora, etc.">
                        <span class="icon is-small is-left">
                            <i class="fas fa-tag"></i>
                        </span>
                    </div>
                </div>
                <div class="field is-grouped is-grouped-centered mt-5">
                    <div class="control">
                        <button type="submit" class="button is-info is-rounded is-medium">
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