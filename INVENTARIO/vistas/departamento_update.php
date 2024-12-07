<div class="container is-fluid mb-6">
	<h1 class="title">Departamentos</h1>
	<h2 class="subtitle">Actualizar Departamento</h2>
</div>

<div class="container pb-6 pt-6">
	<?php
		include "./inc/btn_back.php";

		require_once "./php/main.php";

		$id = (isset($_GET['departamento_id_up'])) ? $_GET['departamento_id_up'] : 0;
		$id=limpiar_cadena($id);

		/*== Verificando departamento ==*/
    	$check_departamento=conexion();
    	$check_departamento=$check_departamento->query("SELECT * FROM departamento WHERE departamento_id='$id'");

        if($check_departamento->rowCount()>0){
        	$datos=$check_departamento->fetch();
	?>

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/departamento_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

		<input type="hidden" name="departamento_id" value="<?php echo $datos['departamento_id']; ?>" required >

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" name="departamento_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}" maxlength="50" required value="<?php echo $datos['departamento_nombre']; ?>" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Jefe Directo</label>
				  	<input class="input" type="text" name="departamento_jefe" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" value="<?php echo $datos['departamento_jefe']; ?>" >
				</div>
		  	</div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>
	</form>
	<?php 
		}else{
			include "./inc/error_alert.php";
		}
		$check_departamento=null;
	?>
</div>