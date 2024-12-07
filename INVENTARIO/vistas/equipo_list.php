<div class="container is-fluid mb-6">
    <h1 class="title">Equipos</h1>
    <h2 class="subtitle">Lista de equipos</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";

        # Eliminar equipo #
        if(isset($_GET['equipo_id_del'])){
            require_once "./php/equipo_eliminar.php";
        }

        if(!isset($_GET['page'])){
            $pagina=1;
        }else{
            $pagina=(int) $_GET['page'];
            if($pagina<=1){
                $pagina=1;
            }
        }

        $departamento_id = (isset($_GET['departamento_id'])) ? $_GET['departamento_id'] : 0;

        $pagina=limpiar_cadena($pagina);
        $url="index.php?vista=equipo_list&page="; /* <== */
        $registros=15;
        $busqueda="";

        # Paginador equipo #
        require_once "./php/equipo_lista.php";
    ?>
</div>