<?php
	require_once "../inc/session_start.php";

	require_once "main.php";

	/*== Almacenando datos ==*/
	$serie=limpiar_cadena($_POST['equipo_serie']);
	$nombre=limpiar_cadena($_POST['equipo_nombre']);

	$problema=limpiar_cadena($_POST['equipo_problema']);
	$solucion=limpiar_cadena($_POST['equipo_solucion']);
	$departamento=limpiar_cadena($_POST['equipo_departamento']);


	/*== Verificando campos obligatorios ==*/
    if($serie=="" || $nombre=="" || $problema=="" || $solucion=="" || $departamento==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    /*== Verificando integridad de los datos ==*/
    if(verificar_datos("[a-zA-Z0-9- ]{1,70}",$serie)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El numero de serie no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}",$problema)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El problema no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}",$solucion)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La solucion no coincide con el formato solicitado
            </div>
        ';
        exit();
    }


    /*== Verificando serie ==*/
    $check_serie=conexion();
    $check_serie=$check_serie->query("SELECT equipo_serie FROM equipo WHERE equipo_serie='$serie'");
    if($check_serie->rowCount()>0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La serie ingresada ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();
    }
    $check_serie=null;


    /*== Verificando nombre ==*/
    $check_nombre=conexion();
    $check_nombre=$check_nombre->query("SELECT equipo_nombre FROM equipo WHERE equipo_nombre='$nombre'");
    if($check_nombre->rowCount()>0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();
    }
    $check_nombre=null;


    /*== Verificando departamento ==*/
    $check_departamento=conexion();
    $check_departamento=$check_departamento->query("SELECT departamento_id FROM departamento WHERE departamento_id='$departamento'");
    if($check_departamento->rowCount()<=0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El departamento seleccionado no existe
            </div>
        ';
        exit();
    }
    $check_departamento=null;


    /* Directorios de imagenes */
	$img_dir='../img/equipo/';


	/*== Comprobando si se ha seleccionado una imagen ==*/
	if($_FILES['equipo_foto']['name']!="" && $_FILES['equipo_foto']['size']>0){

        /* Creando directorio de imagenes */
        if(!file_exists($img_dir)){
            if(!mkdir($img_dir,0777)){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        Error al crear el directorio de imagenes
                    </div>
                ';
                exit();
            }
        }

		/* Comprobando formato de las imagenes */
		if(mime_content_type($_FILES['equipo_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['equipo_foto']['tmp_name'])!="image/png"){
			echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                La imagen que ha seleccionado es de un formato que no está permitido
	            </div>
	        ';
	        exit();
		}


		/* Comprobando que la imagen no supere el peso permitido */
		if(($_FILES['equipo_foto']['size']/1024)>3072){
			echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                La imagen que ha seleccionado supera el límite de peso permitido
	            </div>
	        ';
			exit();
		}


		/* extencion de las imagenes */
		switch(mime_content_type($_FILES['equipo_foto']['tmp_name'])){
			case 'image/jpeg':
			  $img_ext=".jpg";
			break;
			case 'image/png':
			  $img_ext=".png";
			break;
		}

		/* Cambiando permisos al directorio */
		chmod($img_dir, 0777);

		/* Nombre de la imagen */
		$img_nombre=renombrar_fotos($nombre);

		/* Nombre final de la imagen */
		$foto=$img_nombre.$img_ext;

		/* Moviendo imagen al directorio */
		if(!move_uploaded_file($_FILES['equipo_foto']['tmp_name'], $img_dir.$foto)){
			echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                No podemos subir la imagen al sistema en este momento, por favor intente nuevamente
	            </div>
	        ';
			exit();
		}

	}else{
		$foto="";
	}


	/*== Guardando datos ==*/
    $guardar_equipo=conexion();
    $guardar_equipo=$guardar_equipo->prepare("INSERT INTO equipo(equipo_serie,equipo_nombre,equipo_problema,equipo_solucion,equipo_foto,departamento_id,usuario_id) VALUES(:serie,:nombre,:problema,:solucion,:foto,:departamento,:usuario)");

    $marcadores=[
        ":serie"=>$serie,
        ":nombre"=>$nombre,
        ":problema"=>$problema,
        ":solucion"=>$solucion,
        ":foto"=>$foto,
        ":departamento"=>$departamento,
        ":usuario"=>$_SESSION['id']
    ];

    $guardar_equipo->execute($marcadores);

    if($guardar_equipo->rowCount()==1){
        echo '
            <div class="notification is-info is-light">
                <strong>¡Equipo REGISTRADO!</strong><br>
                El equipo se registro con exito
            </div>
        ';
    }else{

    	if(is_file($img_dir.$foto)){
			chmod($img_dir.$foto, 0777);
			unlink($img_dir.$foto);
        }

        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar el equipo, por favor intente nuevamente
            </div>
        ';
    }
    $guardar_equipo=null;