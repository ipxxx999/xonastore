<?php include(__DIR__ . '/header.php'); ?>
				<div class="container-fluid">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Settings</h3>
						</div>
						<form method="post" action="<?php echo $mvctemplate['url']; ?>/?do=settings">
							<div class="panel-body">
								<div class="row">
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label class="control-label">Player:</label>
												<select class="form-control" name="player">
												<?php foreach($mvctemplate['stack']['players'] as $player){ ?>
													<option value="<?php echo $player; ?>" <?php if($player == $mvctemplate['stack']['options']['player']) echo 'selected'; ?>><?php echo $player; ?></option>
												<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label class="control-label">Permit null referer:</label>
												<select class="form-control" name="null_referer">
													<option value="1" <?php if(!empty($mvctemplate['stack']['options']['allowed_referer_null'])) echo 'selected'; ?>>True</option>
													<option value="0" <?php if(empty($mvctemplate['stack']['options']['allowed_referer_null'])) echo 'selected'; ?>>False</option>
												</select>
											</div>
										</div>
										
										
										
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label class="control-label">Allow Domains Referer:</label>
												<textarea class="form-control" rows="20" name="domains_allowed_referer"><?php echo implode("\n",$mvctemplate['stack']['options']['allowed_referer']); ?></textarea><br><small>One per line. Format: domain1.com</small>
											</div>
										</div>
										
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label class="control-label">Api Key Google Drive:</label>
												<input type="text" class="form-control" name="api_key_google_drive" value="<?php echo $mvctemplate['stack']['options']['api_key_google_drive']; ?>"><br>
											</div>
										</div>																				
										
									  
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label class="control-label">Estado del Bot: <?php if($mvctemplate['stack']['bot']['status_run'] == 1) { echo '<font style="color:green;">Ejecutandose</font>'; } else { echo '<font style="color:red;">Sin Ejecutar</font>'; } ?></label><br>
												<label class="control-label">Ultima Ejecucion: <?php echo date('d-m-Y H:i:s', strtotime($mvctemplate['stack']['bot']['last_run'])); ?></label><br>
												<label class="control-label">Ultima Revision (Comienzo): <?php echo date('d-m-Y H:i:s', strtotime($mvctemplate['stack']['bot']['last_check'])); ?></label><br>
												<label class="control-label">Tiempo Transcurrido: <?php echo $mvctemplate['stack']['bot']['tiempo_transcurrido']; ?></label><br>
												
												<?php if($mvctemplate['stack']['bot']['status_run'] == 1) { ?>
												<button type="submit" name="reiniciar_bot" class="btn btn-danger"><i class="fa fa-refresh"></i> Reiniciar Bot</button><br>
												<?php } ?>
												
											</div>
										</div>
										
										
										
								</div>
							</div>
							<div class="panel-footer">
								<button type="submit" name="edit_settings" class="btn btn-info">EDIT SETTINGS</button>
							</div>
						</form>
					</div>
<?php include(__DIR__  . '/footer.php'); ?>