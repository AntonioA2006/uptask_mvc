<?php 
    include_once "header-dashboard.php";
?>

        <div class="contenedor-sm">

        <?php
            include_once __DIR__ . "/../templates/alertas.php";
        ?>
        <a href="/cambiar-password" class="enlace">cambiar password</a>


                <form action="/perfil" class="formulario" method="POST">
                        <div class="campo">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" value="<?php echo $usuario->nombre?>" placeholder="tu nombre">
                        </div>
                        <div class="campo">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" id="email" value="<?php echo $usuario->email ?>"  placeholder="tu e-mail">
                        </div>
                            <input type="submit" value="guardar cambios">
                </form>
        </div>





<?php 
    include_once "footer-dashboard.php"
?>