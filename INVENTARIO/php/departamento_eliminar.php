<?php
	/*== Almacenando datos ==*/
    $departamento_id_del=limpiar_cadena($_GET['departamento_id_del']);

    /*== Verificando usuario ==*/
    $check_departamento=conexion();
    $check_departamento=$check_departamento->query("SELECT departamento_id FROM departamento WHERE departamento_id='$departamento_id_del'");
    
    if($check_departamento->rowCount()==1){

    	$check_equipos=conexion();
    	$check_equipos=$check_equipos->query("SELECT departamento_id FROM equipo WHERE departamento_id='$departamento_id_del' LIMIT 1");

    	if($check_equipos->rowCount()<=0){

    		$eliminar_departamento=conexion();
	    	$eliminar_departamento=$eliminar_departamento->prepare("DELETE FROM departamento WHERE departamento_id=:id");

	    	$eliminar_departamento->execute([":id"=>$departamento_id_del]);

	    	if($eliminar_departamento->rowCount()==1){
		        echo '
		            <div class="notification is-info is-light">
		                <strong>¡Departamento ELIMINADO!</strong><br>
		                Los datos de el departamento se eliminaron con exito
		            </div>
		        ';
		    }else{
		        echo '
		            <div class="notification is-danger is-light">
		                <strong>¡Ocurrio un error inesperado!</strong><br>
		                No se pudo eliminar el departamento, por favor intente nuevamente
		            </div>
		        ';
		    }
		    $eliminar_departamento=null;
    	}else{
    		echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                No podemos eliminar el departamento ya que tiene equipos asociados
	            </div>
	        ';
    	}
    	$check_equipos=null;
    }else{
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La departamento que intenta eliminar no existe
            </div>
        ';
    }
    $check_departamento=null;