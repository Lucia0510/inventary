<div class="container is-fluid mb-6">
	<h1 class="title">Equipos</h1>
	<h2 class="subtitle">Nuevo equipo</h2>
</div>

<div class="container pb-6 pt-6">
	<?php
		require_once "./php/main.php";
	?>

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/equipo_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" >
		<div class="columns">
		<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" name="equipo_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Numero de serie</label>
				  	<input class="input" type="text" name="equipo_serie" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70" required >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Problema</label>
				  	<input class="input" type="text" name="equipo_problema" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Solucion</label>
				  	<input class="input" type="text" name="equipo_solucion" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required >
				</div>
		  	</div>
		  	<div class="column">
				<label>Departamento</label><br>
		    	<div class="select is-rounded">
				  	<select name="equipo_departamento" >
				    	<option value="" selected="" >Seleccione una opción</option>
				    	<?php
    						$departamentos=conexion();
    						$departamentos=$departamentos->query("SELECT * FROM departamento");
    						if($departamentos->rowCount()>0){
    							$departamentos=$departamentos->fetchAll();
    							foreach($departamentos as $row){
    								echo '<option value="'.$row['departamento_id'].'" >'.$row['departamento_nombre'].'</option>';
				    			}
				   			}
				   			$departamentos=null;
				    	?>
				  	</select>
				</div>
		  	</div>
		</div>
		<div class="columns">
			<div class="column">
				<label>Foto o imagen del equipo</label><br>
				<div class="file is-small has-name">
				  	<label class="file-label">
				    	<input class="file-input" type="file" name="equipo_foto" accept=".jpg, .png, .jpeg" >
				    	<span class="file-cta">
				      		<span class="file-label">Imagen</span>
				    	</span>
				    	<span class="file-name">JPG, JPEG, PNG. (MAX 3MB)</span>
				  	</label>
				</div>
			</div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-info is-rounded">Guardar</button>
		</p>
	</form>
</div>