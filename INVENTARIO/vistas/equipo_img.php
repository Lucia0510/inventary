<div class="container is-fluid mb-6">
	<h1 class="title">equipos</h1>
	<h2 class="subtitle">Actualizar imagen de equipo</h2>
</div>

<div class="container pb-6 pt-6">
	<?php
		include "./inc/btn_back.php";

		require_once "./php/main.php";

		$id = (isset($_GET['equipo_id_up'])) ? $_GET['equipo_id_up'] : 0;

		/*== Verificando equipo ==*/
    	$check_equipo=conexion();
    	$check_equipo=$check_equipo->query("SELECT * FROM equipo WHERE equipo_id='$id'");

        if($check_equipo->rowCount()>0){
        	$datos=$check_equipo->fetch();
	?>

	<div class="form-rest mb-6 mt-6"></div>

	<div class="columns">
		<div class="column is-two-fifths">
			<?php if(is_file("./img/equipo/".$datos['equipo_foto'])){ ?>
			<figure class="image mb-6">
			  	<img src="./img/equipo/<?php echo $datos['equipo_foto']; ?>">
			</figure>
			<form class="FormularioAjax" action="./php/equipo_img_eliminar.php" method="POST" autocomplete="off" >

				<input type="hidden" name="img_del_id" value="<?php echo $datos['equipo_id']; ?>">

				<p class="has-text-centered">
					<button type="submit" class="button is-danger is-rounded">Eliminar imagen</button>
				</p>
			</form>
			<?php }else{ ?>
			<figure class="image mb-6">
			  	<img src="./img/equipo.png">
			</figure>
			<?php } ?>
		</div>
		<div class="column">
			<form class="mb-6 has-text-centered FormularioAjax" action="./php/equipo_img_actualizar.php" method="POST" enctype="multipart/form-data" autocomplete="off" >

				<h4 class="title is-4 mb-6"><?php echo $datos['equipo_nombre']; ?></h4>
				
				<label>Foto o imagen del equipo</label><br>

				<input type="hidden" name="img_up_id" value="<?php echo $datos['equipo_id']; ?>">

				<div class="file has-name is-horizontal is-justify-content-center mb-6">
				  	<label class="file-label">
				    	<input class="file-input" type="file" name="equipo_foto" accept=".jpg, .png, .jpeg" >
				    	<span class="file-cta">
				      		<span class="file-label">Imagen</span>
				    	</span>
				    	<span class="file-name">JPG, JPEG, PNG. (MAX 3MB)</span>
				  	</label>
				</div>
				<p class="has-text-centered">
					<button type="submit" class="button is-success is-rounded">Actualizar</button>
				</p>
			</form>
		</div>
	</div>
	<?php 
		}else{
			include "./inc/error_alert.php";
		}
		$check_equipo=null;
	?>
</div>