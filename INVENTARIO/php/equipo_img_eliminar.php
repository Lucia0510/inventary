<?php
	require_once "main.php";

	/*== Almacenando datos ==*/
    $equipo_id=limpiar_cadena($_POST['img_del_id']);

    /*== Verificando equipo ==*/
    $check_equipo=conexion();
    $check_equipo=$check_equipo->query("SELECT * FROM equipo WHERE equipo_id='$equipo_id'");

    if($check_equipo->rowCount()==1){
    	$datos=$check_equipo->fetch();
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La imagen del equipo que intenta eliminar no existe
            </div>
        ';
        exit();
    }
    $check_equipo=null;


    /* Directorios de imagenes */
	$img_dir='../img/equipo/';

	/* Cambiando permisos al directorio */
	chmod($img_dir, 0777);


	/* Eliminando la imagen */
	if(is_file($img_dir.$datos['equipo_foto'])){

		chmod($img_dir.$datos['equipo_foto'], 0777);

		if(!unlink($img_dir.$datos['equipo_foto'])){
			echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                Error al intentar eliminar la imagen del equipo, por favor intente nuevamente
	            </div>
	        ';
	        exit();
		}
	}


	/*== Actualizando datos ==*/
    $actualizar_equipo=conexion();
    $actualizar_equipo=$actualizar_equipo->prepare("UPDATE equipo SET equipo_foto=:foto WHERE equipo_id=:id");

    $marcadores=[
        ":foto"=>"",
        ":id"=>$equipo_id
    ];

    if($actualizar_equipo->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡IMAGEN O FOTO ELIMINADA!</strong><br>
                La imagen del equipo ha sido eliminada exitosamente, pulse Aceptar para recargar los cambios.

                <p class="has-text-centered pt-5 pb-5">
                    <a href="index.php?vista=equipo_img&equipo_id_up='.$equipo_id.'" class="button is-link is-rounded">Aceptar</a>
                </p">
            </div>
        ';
    }else{
        echo '
            <div class="notification is-warning is-light">
                <strong>¡IMAGEN O FOTO ELIMINADA!</strong><br>
                Ocurrieron algunos inconvenientes, sin embargo la imagen del equipo ha sido eliminada, pulse Aceptar para recargar los cambios.

                <p class="has-text-centered pt-5 pb-5">
                    <a href="index.php?vista=equipo_img&equipo_id_up='.$equipo_id.'" class="button is-link is-rounded">Aceptar</a>
                </p">
            </div>
        ';
    }
    $actualizar_equipo=null;