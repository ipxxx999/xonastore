<?php require(__DIR__ . '/header.php'); ?>
				<div class="container-fluid">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title"><?=$mvctemplate['extra']['titulo']?></h3>
						</div>
						<div style="padding: 30px;">
							<?=$mvctemplate['extra']['mensaje']?>
							<hr>
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