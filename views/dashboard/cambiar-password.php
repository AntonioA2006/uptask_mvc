<?php 
    include_once "header-dashboard.php";
?>

        <div class="contenedor-sm">

        <?php
            include_once __DIR__ . "/../templates/alertas.php";
        ?>          
                <a href="/perfil" class="enlace">volver a perfil</a>
                <form action="/cambiar-password" class="formulario" method="POST">
                        <div class="campo">
                            <label for="password">password actual</label>
                            <input type="password" name="password_actual" id="password" placeholder="tu password actual">
                        </div>
                        <div class="campo">
                            <label for="password_nuevo">password nuevo</label>
                            <input type="password" name="password_nuevo" id="password_nuevo"  placeholder="tu nuevo password">
                        </div>
                            <input type="submit" value="guardar cambios">
                </form>
        </div>





<?php 
    include_once "footer-dashboard.php"
?>