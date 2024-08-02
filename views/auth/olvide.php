<div class="contenedor olvide">
 <?php include_once __DIR__ . "/../templates/nombre-sitio.php"?>
 <div class="contenedor-sm">
     <p class="descripcion-pagina">
         Crea tu cuenta en UpTask
        </p>
        <?php include_once __DIR__ . "/../templates/alertas.php"?>
        <form class="formulario" method="POST" action="/olvide">
              
                <div class="campo">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" placeholder="Tu E-mail"> 
                </div>
               
                <input type="submit" value="Recupera tu password" class="boton">

        </form>
        <div class="acciones">
            <a href="/">Inicia Sesion</a>
            <a href="/crear">olvidaste tu password</a>
        </div>
    </div>


</div>