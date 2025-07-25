<style>
    .navbar {
        background-color: #00308F !important;
        min-height: 70px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .navbar .navbar-item,
    .navbar .navbar-link,
    .navbar .navbar-dropdown .navbar-item {
        color: #fff !important;
        font-size: 1.15rem;
        padding-top: 14px !important;
        padding-bottom: 14px !important;
        padding-left: 22px !important;
        padding-right: 22px !important;
    }
    .navbar .navbar-link:hover,
    .navbar .navbar-dropdown .navbar-item:hover {
        background-color: #002060 !important;
        color: #fff !important;
    }
    .navbar .button.is-primary,
    .navbar .button.is-link {
        background-color: #fff !important;
        color: #00308F !important;
        border: none;
        font-size: 1rem;
        padding: 10px 22px;
        margin-left: 8px;
    }
    .navbar .button.is-primary:hover,
    .navbar .button.is-link:hover {
        background-color: #00308F !important;
        color: #fff !important;
        border: 1px solid #fff;
    }
    .navbar-burger span {
        background: #fff !important;
    }
    .navbar .navbar-dropdown {
        background-color: #00308F !important;
        border-radius: 0 0 8px 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .navbar .navbar-dropdown .navbar-item {
        color: #fff !important;
    }
    .navbar .navbar-dropdown .navbar-item:hover {
        background-color: #002060 !important;
        color: #fff !important;
    }
    .navbar .navbar-link {
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .navbar .navbar-end .buttons {
        display: flex;
        align-items: center;
    }
    /* Responsive fix for mobile */
    @media (max-width: 1023px) {
        .navbar .navbar-end .buttons {
            flex-direction: column;
            align-items: flex-start;
        }
        .navbar .button.is-primary,
        .navbar .button.is-link {
            margin-left: 0;
            margin-bottom: 8px;
        }
    }
</style>

<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="http://192.168.50.246/RADIODISNEY/index.html">
            <span style="
                font-size: 2.5rem;
                font-weight: bold;
                color: #fff;
                letter-spacing: 2px;
                font-family: 'Montserrat', Arial, sans-serif;
                line-height: 1;
                display: flex;
                align-items: center;
                height: 60px;
            ">
                G
            </span>
        </a>
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link is-arrowless">
                    Usuarios
                </a>
                <div class="navbar-dropdown">
                    <a href="index.php?vista=user_new" class="navbar-item">Nuevo</a>
                    <a href="index.php?vista=user_list" class="navbar-item">Lista</a>
                    <a href="index.php?vista=user_search" class="navbar-item">Buscar</a>
                </div>
            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Inventario</a>
                <div class="navbar-dropdown">
                    <a href="index.php?vista=category_list" class="navbar-item">Tipos de Equipo</a>
                    <a href="index.php?vista=product_list" class="navbar-item">Lista de Productos</a>
                    <a href="index.php?vista=equipo_lista" class="navbar-item">Lista de Equipos</a>
                    <a href="index.php?vista=lugar_lista" class="navbar-item">Lista de Lugares</a>
                    <a href="index.php?vista=area_lista" class="navbar-item">Lista de Áreas</a>
                    <a href="index.php?vista=material_lista" class="navbar-item">Lista de Materiales</a>
                    <a href="index.php?vista=vendedor_lista" class="navbar-item">Lista de Vendedores</a>
                </div>
            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Asignaciones</a>
                <div class="navbar-dropdown">
                    <a href="index.php?vista=asignacion_equipo_nueva" class="navbar-item">Nueva Asignación</a>
                    <a href="index.php?vista=asignacion_equipo_lista" class="navbar-item">Lista Asignaciones</a>
                </div>
            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Eventos</a>
                <div class="navbar-dropdown">
                    <a href="index.php?vista=evento_nuevo" class="navbar-item">Nuevo Evento</a>
                    <a href="index.php?vista=evento_lista" class="navbar-item">Lista de Eventos</a>
                </div>
            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Tareas</a>
                <div class="navbar-dropdown">
                    <a href="index.php?vista=tarea_lista" class="navbar-item">Lista de Tareas</a>
                    <a href="index.php?vista=tarea_nueva" class="navbar-item">Nueva Tarea</a>
                </div>
            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Bordados</a>
                <div class="navbar-dropdown">
                    <a href="index.php?vista=bordado_nuevo" class="navbar-item">Nuevo Bordado</a>
                    <a href="index.php?vista=bordado_lista" class="navbar-item">Lista de Bordados</a>
                </div>
            </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <a href="index.php?vista=user_update&user_id_up=<?php echo $_SESSION['id']; ?>" class="button is-primary is-rounded">
                        Mi cuenta
                    </a>
                    <a href="index.php?vista=logout" class="button is-link is-rounded">
                        Salir
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
// Bulma burger menu for mobile
document.addEventListener('DOMContentLoaded', () => {
    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
    if ($navbarBurgers.length > 0) {
        $navbarBurgers.forEach( el => {
            el.addEventListener('click', () => {
                const target = el.dataset.target;
                const $target = document.getElementById(target);
                el.classList.toggle('is-active');
                $target.classList.toggle('is-active');
            });
        });
    }
});
</script>