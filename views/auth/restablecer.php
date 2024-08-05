<div class="contenedor restablecer">
<?php include_once __DIR__ . "/../templates/nombre-sitio.php"?>
<div class="contenedor-sm">
    <p class="descripcion-pagina">
        Coloca tu nuevo password
    </p>
    <?php include_once __DIR__ . "/../templates/alertas.php"?>
    <?php if($mostrar) :?>
        <form class="formulario" method="POST">
             
                <div class="campo">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Tu password">
                </div>
                <input type="submit" value="Guardar Password" class="boton">

        </form>
        <?php 
        
        endif;
        ?>

        <div class="acciones">
            <a href="/crear">Crea una cuenta</a>
            <a href="/olvide">olvidaste tu password</a>
        </div>
        
    </div>


</div>