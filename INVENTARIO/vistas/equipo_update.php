<div class="container is-fluid mb-6">
	<h1 class="title">equipos</h1>
	<h2 class="subtitle">Actualizar equipo</h2>
</div>

<div class="container pb-6 pt-6">
	<?php
		include "./inc/btn_back.php";

		require_once "./php/main.php";

		$id = (isset($_GET['equipo_id_up'])) ? $_GET['equipo_id_up'] : 0;
		$id=limpiar_cadena($id);

		/*== Verificando equipo ==*/
    	$check_equipo=conexion();
    	$check_equipo=$check_equipo->query("SELECT * FROM equipo WHERE equipo_id='$id'");

        if($check_equipo->rowCount()>0){
        	$datos=$check_equipo->fetch();
	?>

	<div class="form-rest mb-6 mt-6"></div>
	
	<h2 class="title has-text-centered"><?php echo $datos['equipo_nombre']; ?></h2>

	<form action="./php/equipo_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

		<input type="hidden" name="equipo_id" value="<?php echo $datos['equipo_id']; ?>" required >

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Numero de serie</label>
				  	<input class="input" type="text" name="equipo_serie" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70" required value="<?php echo $datos['equipo_serie']; ?>" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" name="equipo_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required value="<?php echo $datos['equipo_nombre']; ?>" >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Problema</label>
				  	<input class="input" type="text" name="equipo_problema" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required value="<?php echo $datos['equipo_problema']; ?>" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Solucion</label>
				  	<input class="input" type="text" name="equipo_solucion" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required value="<?php echo $datos['equipo_solucion']; ?>" >
				</div>
		  	</div>
		  	<div class="column">
				<label>Departamento</label><br>
		    	<div class="select is-rounded">
				  	<select name="equipo_departamento" >
				    	<?php
    						$departamentos=conexion();
    						$departamentos=$departamentos->query("SELECT * FROM departamento");
    						if($departamentos->rowCount()>0){
    							$departamentos=$departamentos->fetchAll();
    							foreach($departamentos as $row){
    								if($datos['departamento_id']==$row['departamento_id']){
    									echo '<option value="'.$row['departamento_id'].'" selected="" >'.$row['departamento_nombre'].' (Actual)</option>';
    								}else{
    									echo '<option value="'.$row['departamento_id'].'" >'.$row['departamento_nombre'].'</option>';
    								}
				    			}
				   			}
				   			$departamentos=null;
				    	?>
				  	</select>
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
		$check_equipo=null;
	?>
</div>