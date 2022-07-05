<?php include(__DIR__ . '/header.php'); ?>
				<div class="container-fluid">
				
				<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Opciones</h3>
						</div>
						<div style="padding: 30px;">
					
                        Ultima version del script: 2.3 <?php echo $mvctemplate['stack']['version_remota']; ?> <br>
                        Version de tu Sistema: <?php echo $mvctemplate['stack']['version_local']; ?>





 <br>
                        Changelog: <br><?php echo $mvctemplate['stack']['version_remota_changelog']; ?> <br><br>
						
						<?php if($mvctemplate['stack']['version_remota'] > $mvctemplate['stack']['version_local']) { ?>
						<form action="" method="post">
						<button type="submit" name="actualizar_script" class="btn btn-primary">Actualizar</button>
						</form>
						<?php } ?>
						
						</div>
						
						
						
					</div>
				
				
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Dashboard</h3>
						</div>
						<div style="padding: 30px;">
						
						Bienvenido al Panel de Control X-Toria, este es un gestionador de enlaces de google drive, el cual transforma tu archivo descargable [MP4 - MKV] en un player, es decir, que pueden ver las peliculas almacenados en la misma. Seguimos en estapa de testeos. <br><br>
							• Protector HotLink: No te pueden robar los links y utilizarlos en sus paginas. <br><br>
							• Selector de Player: Puedes seleccionar el diseño del Reproductor, tanto como Plyr.io o Jwplayer. <br><br>
							• Multiples Rangos: <br>
							        Admin: Puede hacer Todo. <br>
							        Editor: Puede Agregar, Editar links de Todos. <br>
							        Autor: Puede Agregar y Editar sus links. <br>
							        Colaborador: Solo puede Agregar links.
						</div>
						
						
						
					</div>
				</div>
<?php include(__DIR__  . '/footer.php'); ?>