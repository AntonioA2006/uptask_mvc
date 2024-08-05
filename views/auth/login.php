<div class="contenedor login">
<?php include_once __DIR__ . "/../templates/nombre-sitio.php"?>
<div class="contenedor-sm">
    <p class="descripcion-pagina">
        Iniciar Sesion
    </p>
    <?php include_once __DIR__ . "/../templates/alertas.php"?>
        <form class="formulario" method="POST" action="/">
                <div class="campo">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" placeholder="Tu E-mail"> 
                </div>
                <div class="campo">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Tu password">
                </div>
                <input type="submit" value="Iniciar Sesion" class="boton">

        </form>
        <div class="acciones">
            <a href="/crear">Crea una cuenta</a>
            <a href="/olvide">olvidaste tu password</a>
        </div>
    </div>


</div>