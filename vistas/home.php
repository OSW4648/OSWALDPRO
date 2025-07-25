<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Home - Sistema de Inventario</title>
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Open Sans', sans-serif;
            background: url('./img/logo1.png') no-repeat center center fixed;
            background-size: cover;
        }
        .overlay {
            background: rgba(34, 58, 125, 0.75);
            min-height: 100vh;
            width: 100vw;
            position: fixed;
            top: 0; left: 0;
            z-index: 1;
        }
        .container-pro {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .title {
            color: #fff;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5em;
            text-shadow: 0 4px 24px rgba(0,0,0,0.4);
            letter-spacing: 2px;
        }
        .subtitle {
            color: #e0e0e0;
            font-size: 1.5rem;
            font-weight: 400;
            margin-bottom: 2em;
            text-shadow: 0 2px 12px rgba(0,0,0,0.3);
        }
        .welcome-card {
            background: rgba(255,255,255,0.12);
            border-radius: 18px;
            padding: 2em 3em;
            box-shadow: 0 8px 32px 0 rgba(31,38,135,0.25);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255,255,255,0.18);
            text-align: center;
        }
        .mobile-version-btn {
            display: none;
            position: fixed;
            top: 18px;
            right: 18px;
            z-index: 10;
            background: #00308F;
            color: #fff;
            padding: 0.7em 1.2em;
            border-radius: 8px;
            font-size: 1rem;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.18);
            transition: background 0.2s;
        }
        .mobile-version-btn:hover {
            background: #002060;
        }
        @media (max-width: 600px) {
            .title { font-size: 2rem; }
            .subtitle { font-size: 1.1rem; }
            .welcome-card { padding: 1em 0.5em; }
            .mobile-version-btn {
                display: block;
            }
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <a href="?movil=1" class="mobile-version-btn">Versión Móvil</a>
    <div class="container-pro">
        <div class="welcome-card">
            <h1 class="title">Home</h1>
            <h2 class="subtitle">¡Bienvenido <?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?>!</h2>
        </div>
    </div>
</body>
</html>