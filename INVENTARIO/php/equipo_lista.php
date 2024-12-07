<?php
	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	$tabla="";

	$campos="equipo.equipo_id,equipo.equipo_serie,equipo.equipo_nombre,equipo.equipo_problema,equipo.equipo_solucion,equipo.equipo_foto,equipo.departamento_id,equipo.usuario_id,departamento.departamento_id,departamento.departamento_nombre,usuario.usuario_id,usuario.usuario_nombre,usuario.usuario_apellido";

	if(isset($busqueda) && $busqueda!=""){

		$consulta_datos="SELECT $campos FROM equipo INNER JOIN departamento ON equipo.departamento_id=departamento.departamento_id INNER JOIN usuario ON equipo.usuario_id=usuario.usuario_id WHERE equipo.equipo_serie LIKE '%$busqueda%' OR equipo.equipo_nombre LIKE '%$busqueda%' ORDER BY equipo.equipo_nombre ASC LIMIT $inicio,$registros";

		$consulta_total="SELECT COUNT(equipo_id) FROM equipo WHERE equipo_serie LIKE '%$busqueda%' OR equipo_nombre LIKE '%$busqueda%'";

	}elseif($departamento_id>0){

		$consulta_datos="SELECT $campos FROM equipo INNER JOIN departamento ON equipo.departamento_id=departamento.departamento_id INNER JOIN usuario ON equipo.usuario_id=usuario.usuario_id WHERE equipo.departamento_id='$departamento_id' ORDER BY equipo.equipo_nombre ASC LIMIT $inicio,$registros";

		$consulta_total="SELECT COUNT(equipo_id) FROM equipo WHERE departamento_id='$departamento_id'";

	}else{

		$consulta_datos="SELECT $campos FROM equipo INNER JOIN departamento ON equipo.departamento_id=departamento.departamento_id INNER JOIN usuario ON equipo.usuario_id=usuario.usuario_id ORDER BY equipo.equipo_nombre ASC LIMIT $inicio,$registros";

		$consulta_total="SELECT COUNT(equipo_id) FROM equipo";

	}

	$conexion=conexion();

	$datos = $conexion->query($consulta_datos);
	$datos = $datos->fetchAll();

	$total = $conexion->query($consulta_total);
	$total = (int) $total->fetchColumn();

	$Npaginas =ceil($total/$registros);

	if($total>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;
		foreach($datos as $rows){
			$tabla.='
				<article class="media">
			        <figure class="media-left">
			            <p class="image is-64x64">';
			            if(is_file("./img/equipo/".$rows['equipo_foto'])){
			            	$tabla.='<img src="./img/equipo/'.$rows['equipo_foto'].'">';
			            }else{
			            	$tabla.='<img src="./img/equipo.png">';
			            }
			   $tabla.='</p>
			        </figure>
			        <div class="media-content">
			            <div class="content">
			              <p>
			                <strong>'.$contador.' - '.$rows['equipo_nombre'].'</strong><br>
			                <strong>serie:</strong> '.$rows['equipo_serie'].', <strong>problema:</strong> $'.$rows['equipo_problema'].', <strong>solucion:</strong> '.$rows['equipo_solucion'].', <strong>departamento:</strong> '.$rows['departamento_nombre'].', <strong>REGISTRADO POR:</strong> '.$rows['usuario_nombre'].' '.$rows['usuario_apellido'].'
			              </p>
			            </div>
			            <div class="has-text-right">
			                <a href="index.php?vista=equipo_img&equipo_id_up='.$rows['equipo_id'].'" class="button is-link is-rounded is-small">Imagen</a>
			                <a href="index.php?vista=equipo_update&equipo_id_up='.$rows['equipo_id'].'" class="button is-success is-rounded is-small">Actualizar</a>
			                <a href="'.$url.$pagina.'&equipo_id_del='.$rows['equipo_id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
			            </div>
			        </div>
			    </article>

			    <hr>
            ';
            $contador++;
		}
		$pag_final=$contador-1;
	}else{
		if($total>=1){
			$tabla.='
				<p class="has-text-centered" >
					<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
						Haga clic acá para recargar el listado
					</a>
				</p>
			';
		}else{
			$tabla.='
				<p class="has-text-centered" >No hay registros en el sistema</p>
			';
		}
	}

	if($total>0 && $pagina<=$Npaginas){
		$tabla.='<p class="has-text-right">Mostrando equipos <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
	}

	$conexion=null;
	echo $tabla;

	if($total>=1 && $pagina<=$Npaginas){
		echo paginador_tablas($pagina,$Npaginas,$url,7);
	}