<?php include(__DIR__ . '/header.php'); ?>
				<div class="container-fluid">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Quality</h3>
						</div>
						<form method="post" action="<?php echo $mvctemplate['url']; ?>/?do=quality">
							<div class="panel-body">
								<div class="row">					
										
										<?php 
										$calidad = $mvctemplate['stack']['options']['calidades'];
										if(empty($calidad)) {
										$calidad = array();	
										}
										?>
										
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label class="control-label">Calidades:</label>
												<input type="checkbox" name="calidades[]" value="360p" <?php if (in_array("360p", $calidad)) echo 'checked'; ?>> 360p 
												<input type="checkbox" name="calidades[]" value="480p" <?php if (in_array("480p", $calidad)) echo 'checked'; ?>> 480p 
												<input type="checkbox" name="calidades[]" value="720p" <?php if (in_array("720p", $calidad)) echo 'checked'; ?>> 720p 
												<input type="checkbox" name="calidades[]" value="1080p" <?php if (in_array("1080p", $calidad)) echo 'checked'; ?>> 1080p<br>
											</div>
										</div>
										
										
										
								</div>
							</div>
							<div class="panel-footer">
								<button type="submit" name="edit_settings" class="btn btn-info">EDIT QUALITY</button>
							</div>
						</form>
					</div>
<?php include(__DIR__  . '/footer.php'); ?>