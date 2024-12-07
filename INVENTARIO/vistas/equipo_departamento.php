<div class="container is-fluid mb-6">
    <h1 class="title">Equipos</h1>
    <h2 class="subtitle">Lista de equipos por Departamento</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";
    ?>
    <div class="columns">
        <div class="column is-one-third">
            <h2 class="title has-text-centered">Departamentos</h2>
            <?php
                $departamentos=conexion();
                $departamentos=$departamentos->query("SELECT * FROM departamento");
                if($departamentos->rowCount()>0){
                    $departamentos=$departamentos->fetchAll();
                    foreach($departamentos as $row){
                        echo '<a href="index.php?vista=equipo_departament&departamento_id='.$row['departamento_id'].'" class="button is-link is-inverted is-fullwidth">'.$row['departamento_nombre'].'</a>';
                    }
                }else{
                    echo '<p class="has-text-centered" >No hay Departamentos registradas</p>';
                }
                $departamentos=null;
            ?>
        </div>
        <div class="column">
            <?php
                $departamento_id = (isset($_GET['departamento_id'])) ? $_GET['departamento_id'] : 0;

                /*== Verificando departamento ==*/
                $check_departamento=conexion();
                $check_departamento=$check_departamento->query("SELECT * FROM departamento WHERE departamento_id='$departamento_id'");

                if($check_departamento->rowCount()>0){

                    $check_departamento=$check_departamento->fetch();

                    echo '
                        <h2 class="title has-text-centered">'.$check_departamento['departamento_nombre'].'</h2>
                        <p class="has-text-centered pb-6" >'.$check_departamento['departamento_jefe'].'</p>
                    ';

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

                    $pagina=limpiar_cadena($pagina);
                    $url="index.php?vista=equipo_departamento&departamento_id=$departamento_id&page="; /* <== */
                    $registros=15;
                    $busqueda="";

                    # Paginador equipo #
                    require_once "./php/equipo_lista.php";

                }else{
                    echo '<h2 class="has-text-centered title" >Seleccione una Departamento para empezar</h2>';
                }
                $check_departamento=null;
            ?>
        </div>
    </div>
</div>