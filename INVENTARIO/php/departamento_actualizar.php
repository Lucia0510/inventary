<?php
	require_once "main.php";

	/*== Almacenando id ==*/
    $id=limpiar_cadena($_POST['departamento_id']);


    /*== Verificando departamento ==*/
	$check_departamento=conexion();
	$check_departamento=$check_departamento->query("SELECT * FROM departamento WHERE departamento_id='$id'");

    if($check_departamento->rowCount()<=0){
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El departamento no existe en el sistema
            </div>
        ';
        exit();
    }else{
    	$datos=$check_departamento->fetch();
    }
    $check_departamento=null;

    /*== Almacenando datos ==*/
    $nombre=limpiar_cadena($_POST['departamento_nombre']);
    $jefe=limpiar_cadena($_POST['departamento_jefe']);


    /*== Verificando campos obligatorios ==*/
    if($nombre==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    /*== Verificando integridad de los datos ==*/
    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if($jefe!=""){
    	if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}",$jefe)){
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                El NOMBRE DE JEFE no coincide con el formato solicitado
	            </div>
	        ';
	        exit();
	    }
    }


    /*== Verificando nombre ==*/
    if($nombre!=$datos['departamento_nombre']){
	    $check_nombre=conexion();
	    $check_nombre=$check_nombre->query("SELECT departamento_nombre FROM departamento WHERE departamento_nombre='$nombre'");
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


    /*== Actualizar datos ==*/
    $actualizar_departamento=conexion();
    $actualizar_departamento=$actualizar_departamento->prepare("UPDATE departamento SET departamento_nombre=:nombre,departamento_jefe=:jefe WHERE departamento_id=:id");

    $marcadores=[
        ":nombre"=>$nombre,
        ":jefe"=>$jefe,
        ":id"=>$id
    ];

    if($actualizar_departamento->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡Departamento ACTUALIZADO!</strong><br>
                El departamento se actualizo con exito
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar El departamento, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_departamento=null;