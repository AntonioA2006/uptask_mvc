<?php 
    include_once "header-dashboard.php";
?>

<?php if(count($proyectos) == 0 ) { ?>
<p class="no-proyectos">
    no Hay Proyectos Aun 
</p>
<a href="/proyecto">comienza creando uno</a>
<?php } else{ ?>

        <ul class="listado-proyectos">
                <?php foreach($proyectos as $proyecto): ?>

                    <li class="proyecto">

                        <a href="/proyecto?id=<?php echo $proyecto->url ?>"
                                ><?php echo $proyecto->proyecto ?></a>


                    </li>


                <?php endforeach; ?>
        </ul>



<?php }; ?>
<?php 
    include_once "footer-dashboard.php"
?>