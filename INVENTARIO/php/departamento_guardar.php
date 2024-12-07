<?php
	require_once "main.php";

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


    /*== Guardando datos ==*/
    $guardar_departamento=conexion();
    $guardar_departamento=$guardar_departamento->prepare("INSERT INTO departamento(departamento_nombre,departamento_jefe) VALUES(:nombre,:jefe)");

    $marcadores=[
        ":nombre"=>$nombre,
        ":jefe"=>$jefe
    ];

    $guardar_departamento->execute($marcadores);

    if($guardar_departamento->rowCount()==1){
        echo '
            <div class="notification is-info is-light">
                <strong>¡Departamento REGISTRADO!</strong><br>
                El departamento se registro con exito
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar El departamento, por favor intente nuevamente
            </div>
        ';
    }
    $guardar_departamento=null;