<?php 
    include_once "header-dashboard.php";
?>

<div class="contenedor-sm">

        <div class="contenedor-nueva-tarea">
            <button type="button" class="agregar-tarea" id="agregar-tarea">&#43;Nueva tarea</button>
            <button type="button" class="eliminar-proyecto" id="eliminar-proyecto">-Eliminar proyecto</button>
        </div>
        <div id="filtros" class="filtros">
            <div class="filtros-inputs">
                <h2>Filtros</h2>
                    <div class="campo">
                        <label for="todas">todas</label>
                        <input type="radio" name="filtro" id="todas" value=""  checked>
                    </div>
                    <div class="campo">
                        <label for="completadas">completadas</label>
                        <input type="radio" name="filtro" id="completadas" value="1">
                    </div>
                    <div class="campo">
                        <label for="pendientes">pendientes</label>
                        <input type="radio" name="filtro" id="pendientes" value="0">
                    </div>
            </div>

        </div>
        <ul id="listado-tareas" class="listado-tareas">

        </ul>
</div>



<?php 
    include_once  'footer-dashboard.php';
?>


<?php

$script .= '
<script src="build/js/tareas.js"></script>
';
?>