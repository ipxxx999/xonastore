<?php include(__DIR__ . '/header.php'); ?>
				<div class="container-fluid">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Edit Servers</h3>
						</div>
						<form method="post" action="<?php echo $mvctemplate['url']; ?>/?do=editservers&id=<?php echo $mvctemplate['stack']['servers']['id']; ?>">
							<div class="panel-body">
								<div class="row">
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label class="control-label">Nombre Servidor:</label>
												<input class="form-control" name="nombre_servidor" value="<?php echo htmlentities($mvctemplate['stack']['servers']['nombre']); ?>" placeholder="Nombre Servidor" required>
											</div>
										</div>
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label class="control-label">IP or Domain:</label>
												<input class="form-control" name="ip_ftp" value="<?php echo htmlentities($mvctemplate['stack']['servers']['ip_ftp']); ?>" placeholder="IP Domain" required>
											</div>
										</div>
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label class="control-label">Usuario:</label>
												<input class="form-control" name="usuario_ftp" value="<?php echo htmlentities($mvctemplate['stack']['servers']['usuario_ftp']); ?>" placeholder="Usuario FTP" required>
											</div>
										</div>
										
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label class="control-label">Password:</label>
												<input class="form-control" name="password_ftp" value="<?php echo htmlentities($mvctemplate['stack']['servers']['password_ftp']); ?>" placeholder="Password" required>
											</div>
										</div>
										
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label class="control-label">Puerto:</label>
												<input class="form-control" name="puerto_ftp" value="<?php echo htmlentities($mvctemplate['stack']['servers']['puerto_ftp']); ?>" placeholder="Puerto FTP" required>
											</div>
										</div>
										
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label class="control-label">Ruta:</label>
												<input class="form-control" name="ruta" value="<?php echo htmlentities($mvctemplate['stack']['servers']['ruta']); ?>" placeholder="Ruta FTP" required>
											</div>
										</div>
										
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label class="control-label">Tipo Server:</label>
												<select class="form-control" name="tipo_servidor" required>
												<option value="onlyread" <?php if($mvctemplate['stack']['servers']['tipo_servidor'] == 'onlyread') { echo 'selected'; } ?>>Solo Lectura</option>
												<option value="read-write" <?php if($mvctemplate['stack']['servers']['tipo_servidor'] == 'read-write') { echo 'selected'; } ?>>Lectura y Escritura</option>
												</select>
												
											</div>
										</div>
										
										
										
								</div>
								<hr>
								
								
								
								<hr>
								
								
								
							</div>
							
							<div class="panel-footer">
								<button type="submit" class="btn btn-info">EDIT SERVER</button>
							</div>
						</form>
							
					</div>
<?php include(__DIR__  . '/footer.php'); ?>