<?php
	/*== Almacenando datos ==*/
    $equipo_id_del=limpiar_cadena($_GET['equipo_id_del']);

    /*== Verificando equipo ==*/
    $check_equipo=conexion();
    $check_equipo=$check_equipo->query("SELECT * FROM equipo WHERE equipo_id='$equipo_id_del'");

    if($check_equipo->rowCount()==1){

    	$datos=$check_equipo->fetch();

    	$eliminar_equipo=conexion();
    	$eliminar_equipo=$eliminar_equipo->prepare("DELETE FROM equipo WHERE equipo_id=:id");

    	$eliminar_equipo->execute([":id"=>$equipo_id_del]);

    	if($eliminar_equipo->rowCount()==1){

    		if(is_file("./img/equipo/".$datos['equipo_foto'])){
    			chmod("./img/equipo/".$datos['equipo_foto'], 0777);
				unlink("./img/equipo/".$datos['equipo_foto']);
    		}

	        echo '
	            <div class="notification is-info is-light">
	                <strong>¡equipo ELIMINADO!</strong><br>
	                Los datos del equipo se eliminaron con exito
	            </div>
	        ';
	    }else{
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                No se pudo eliminar el equipo, por favor intente nuevamente
	            </div>
	        ';
	    }
	    $eliminar_equipo=null;
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El equipo que intenta eliminar no existe
            </div>
        ';
    }
    $check_equipo=null;