<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema de Inventario</title>
    <style>
        body{
            margin:0;
            color:#6a6f8c;
            background:#c8c8c8;
            font:600 16px/18px 'Open Sans',sans-serif;
        }
        *,:after,:before{box-sizing:border-box}
        .clearfix:after,.clearfix:before{content:'';display:table}
        .clearfix:after{clear:both;display:block}
        a{color:inherit;text-decoration:none}

        .login-wrap{
            width:100%;
            margin:auto;
            max-width:525px;
            min-height:670px;
            position:relative;
            background:url(https://raw.githubusercontent.com/khadkamhn/day-01-login-form/master/img/bg.jpg) no-repeat center;
            box-shadow:0 12px 15px 0 rgba(0,0,0,.24),0 17px 50px 0 rgba(0,0,0,.19);
        }
        .login-html{
            width:100%;
            height:100%;
            position:absolute;
            padding:90px 70px 50px 70px;
            background:rgba(40,57,101,.9);
        }
        .login-html .sign-in-htm{
            top:0;
            left:0;
            right:0;
            bottom:0;
            position:absolute;
            transition:all .4s linear;
        }
        .login-html .tab,
        .login-form .group .label,
        .login-form .group .button{
            text-transform:uppercase;
        }
        .login-html .tab{
            font-size:22px;
            margin-right:15px;
            padding-bottom:5px;
            margin:0 15px 10px 0;
            display:inline-block;
            border-bottom:2px solid transparent;
            color:#fff;
            border-color:#1161ee;
        }
        .login-form{
            min-height:345px;
            position:relative;
            perspective:1000px;
            transform-style:preserve-3d;
        }
        .login-form .group{
            margin-bottom:15px;
        }
        .login-form .group .label,
        .login-form .group .input,
        .login-form .group .button{
            width:100%;
            color:#fff;
            display:block;
        }
        .login-form .group .input,
        .login-form .group .button{
            border:none;
            padding:15px 20px;
            border-radius:25px;
            background:rgba(255,255,255,.1);
        }
        .login-form .group input[data-type="password"]{
            text-security:circle;
            -webkit-text-security:circle;
        }
        .login-form .group .label{
            color:#aaa;
            font-size:12px;
        }
        .login-form .group .button{
            background:#1161ee;
        }
        .login-form .group label .icon{
            width:15px;
            height:15px;
            border-radius:2px;
            position:relative;
            display:inline-block;
            background:rgba(255,255,255,.1);
        }
        .login-form .group label .icon:before,
        .login-form .group label .icon:after{
            content:'';
            width:10px;
            height:2px;
            background:#fff;
            position:absolute;
            transition:all .2s ease-in-out 0s;
        }
        .login-form .group label .icon:before{
            left:3px;
            width:5px;
            bottom:6px;
            transform:scale(0) rotate(0);
        }
        .login-form .group label .icon:after{
            top:6px;
            right:0;
            transform:scale(0) rotate(0);
        }
        .login-form .group .check:checked + label{
            color:#fff;
        }
        .login-form .group .check:checked + label .icon{
            background:#1161ee;
        }
        .login-form .group .check:checked + label .icon:before{
            transform:scale(1) rotate(45deg);
        }
        .login-form .group .check:checked + label .icon:after{
            transform:scale(1) rotate(-45deg);
        }
        .hr{
            height:2px;
            margin:60px 0 50px 0;
            background:rgba(255,255,255,.2);
        }
        .foot-lnk{
            text-align:center;
        }
    </style>
</head>
<body>
<div class="login-wrap">
    <div class="login-html">
        <label class="tab">Iniciar Sesión</label>
        <div class="login-form">
            <div class="sign-in-htm">
                <form action="" method="POST" autocomplete="off">
                    <div class="group">
                        <label for="login_usuario" class="label">Usuario</label>
                        <input id="login_usuario" name="login_usuario" type="text" class="input" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
                    </div>
                    <div class="group">
                        <label for="login_clave" class="label">Clave</label>
                        <input id="login_clave" name="login_clave" type="password" class="input" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required data-type="password">
                    </div>
                    <div class="group">
                        <input id="check" type="checkbox" class="check" checked>
                        <label for="check"><span class="icon"></span> Mantener sesión iniciada</label>
                    </div>
                    <div class="group">
                        <input type="submit" class="button" value="Iniciar sesión">
                    </div>
                    <?php
                        $usuario_valido = false;
                        $usuario = [];
                        if(isset($_POST['login_usuario']) && isset($_POST['login_clave'])){
                            require_once "./php/main.php";
                            require "./php/iniciar_sesion.php";
                            if ($usuario_valido) {
                                $_SESSION['id'] = $usuario['usuario_id'];
                                $_SESSION['usuario_area_id'] = $usuario['usuario_area_id'];
                                // ...otras variables de sesión...
                                header("Location: index.php");
                                exit;
                            }
                        }
                    ?>
                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <a href="#forgot">¿Olvidaste tu contraseña?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>