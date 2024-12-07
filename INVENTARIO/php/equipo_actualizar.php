<?php
	require_once "main.php";

	/*== Almacenando id ==*/
    $id=limpiar_cadena($_POST['equipo_id']);


    /*== Verificando equipo ==*/
	$check_equipo=conexion();
	$check_equipo=$check_equipo->query("SELECT * FROM equipo WHERE equipo_id='$id'");

    if($check_equipo->rowCount()<=0){
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El equipo no existe en el sistema
            </div>
        ';
        exit();
    }else{
    	$datos=$check_equipo->fetch();
    }
    $check_equipo=null;


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
                El Numero de serie no coincide con el formato solicitado
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
                La solucion  no coincide con el formato solicitado
            </div>
        ';
        exit();
    }


    /*== Verificando serie ==*/
    if($serie!=$datos['equipo_serie']){
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
    }


    /*== Verificando nombre ==*/
    if($nombre!=$datos['equipo_nombre']){
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
    }


    /*== Verificando departamento ==*/
    if($departamento!=$datos['departamento_id']){
	    $check_departamento=conexion();
	    $check_departamento=$check_departamento->query("SELECT departamento_id FROM departamento WHERE departamento_id='$departamento'");
	    if($check_departamento->rowCount()<=0){
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                El departamento seleccionado  no existe
	            </div>
	        ';
	        exit();
	    }
	    $check_departamento=null;
    }


    /*== Actualizando datos ==*/
    $actualizar_equipo=conexion();
    $actualizar_equipo=$actualizar_equipo->prepare("UPDATE equipo SET equipo_serie=:serie,equipo_nombre=:nombre,equipo_problema=:problema,equipo_solucion=:solucion,departamento_id=:departamento WHERE equipo_id=:id");

    $marcadores=[
        ":serie"=>$serie,
        ":nombre"=>$nombre,
        ":problema"=>$problema,
        ":solucion"=>$solucion,
        ":departamento"=>$departamento,
        ":id"=>$id
    ];


    if($actualizar_equipo->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡Equipo ACTUALIZADO!</strong><br>
                El equipo se actualizo con exito
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar el equipo, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_equipo=null;