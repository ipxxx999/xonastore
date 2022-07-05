<?php include(__DIR__ . '/header.php'); ?>
				<div class="container-fluid">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Add Links</h3>
						</div>
						<form method="post" action="<?php echo $mvctemplate['url']; ?>/?do=addlink" enctype="multipart/form-data">
							<div class="panel-body">
								<div class="row">
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label class="control-label">Title:</label>
												<input class="form-control" name="title" required>
											</div>
										</div>									
										
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label class="control-label">URL del Video:</label>
												<input class="form-control" autocomplete="off" name="link" required>
											</div>
										</div>
										
										
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label class="control-label">Poster URL:</label>
												<input class="form-control" name="posterlink" placeholder="Example: https://image.tmdb.org/t/p/original/3UnUxeEAGoZhjIW8X1HpEuDPngV.jpg (optional)">
											</div>
										</div>
								</div>
								<hr>
								<div class="row">
										<div class="col-xs-8">
											<div class="form-group">
												<label class="control-label">Subtitle URL:</label>
											</div>
										</div>
										<div class="col-xs-4">
											<div class="form-group">
												<label class="control-label">Subtitle Title:</label>
											</div>
										</div>
								</div>
								<?php if(isset($mvctemplate['stack']['subtitles']) and !empty($mvctemplate['stack']['subtitles']) and is_array($mvctemplate['stack']['subtitles'])) { 
									foreach($mvctemplate['stack']['subtitles'] as $key => $value){ 
								?>
								<div class="row">
										<div class="col-xs-8">
											<div class="form-group">
												<input class="form-control" name="subtitles[<?php echo $key; ?>]">
											</div>
										</div>
										<div class="col-xs-4">
											<div class="form-group">
												<input class="form-control" value="<?php echo $value; ?>" disabled>
											</div>
										</div>
								</div>
								<?php }} ?>
							</div>
							<div class="panel-footer">
								<button type="submit" class="btn btn-info">ADD LINK</button>
							</div>
						</form>
					</div>
<?php include(__DIR__  . '/footer.php'); ?>