<?php require(__DIR__ . '/header.php'); ?>
				<div class="container-fluid">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title"><?=$mvctemplate['extra']['titulo']?></h3>
						</div>
						<div style="padding: 30px;">
							<div class="row">
										<div class="col-xs-12">
											<div class="form-group">
												<label class="control-label">Code Embed:</label>
												<textarea class="form-control" rows="5" ><?php echo htmlentities(get_embed_code($mvctemplate['extra']['mensaje'])); ?></textarea>
											</div>
										</div>
										<div class="col-xs-12">
											<div class="form-group">
												<label class="control-label">Link Embed:</label>
												<input class="form-control" value="<?php echo htmlentities(get_link_embed($mvctemplate['extra']['mensaje'])); ?>">
											</div>
										</div>
								</div>
                        <div>
							<center>
								<?php if(isset($mvctemplate['extra']['botones']) and !empty($mvctemplate['extra']['botones'])){ ?>
									<?php foreach($mvctemplate['extra']['botones'] as $texto => $link){ ?>
										<a href="<?=$link?>" class="btn btn-primary"><?=$texto?></a>
									<?php } ?>
								<?php } ?>
							</center>
						</div>
						</div>
					</div>
				</div>
<?php require(__DIR__ . '/footer.php'); ?>