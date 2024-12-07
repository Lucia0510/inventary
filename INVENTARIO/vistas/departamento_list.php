<div class="container is-fluid mb-6">
    <h1 class="title">Departamentos</h1>
    <h2 class="subtitle">Lista de departamentos</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";

        # Eliminar departamento #
        if(isset($_GET['departamento_id_del'])){
            require_once "./php/departamento_eliminar.php";
        }

        if(!isset($_GET['page'])){
            $pagina=1;
        }else{
            $pagina=(int) $_GET['page'];
            if($pagina<=1){
                $pagina=1;
            }
        }

        $pagina=limpiar_cadena($pagina);
        $url="index.php?vista=departamento_list&page="; /* <== */
        $registros=15;
        $busqueda="";

        # Paginador departamento #
        require_once "./php/departamento_lista.php";
    ?>
</div>