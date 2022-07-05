<?php include(__DIR__ . '/header.php'); ?>
				<div class="container-fluid">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Edit Links</h3>
						</div>
						<?php if(user::canEditPost($mvctemplate['stack']['data_links']['user_id'])){ ?><form method="post" action="<?php echo $mvctemplate['url']; ?>/?do=editlink&id=<?php echo $mvctemplate['stack']['data_links']['id']; ?>"><?php } ?>
							<div class="panel-body">
								<div class="row">
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label class="control-label">Title:</label>
												<input class="form-control" name="title" value="<?php echo htmlentities($mvctemplate['stack']['data_links']['title']); ?>" required>
											</div>
										</div>
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label class="control-label">URL del Video:</label>
												<input class="form-control" name="link" value="<?php echo htmlentities($mvctemplate['stack']['data_links']['data']['link']); ?>" placeholder="Example: http://www.mediafire.com/file/oenmo6qadvqlztb/The.Babysitter.Killer.Queen.2020.720.Latino.mp4.mp4/file" required>
											</div>
										</div>
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label class="control-label">Poster URL:</label>
												<input class="form-control" name="posterlink" value="<?php echo htmlentities($mvctemplate['stack']['data_links']['data']['poster_link']); ?>" placeholder="Example: https://image.tmdb.org/t/p/original/3UnUxeEAGoZhjIW8X1HpEuDPngV.jpg (optional)">
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
										if(!isset($mvctemplate['stack']['data_links']['data']['subtitles'][$key])) $mvctemplate['stack']['data_links']['data']['subtitles'][$key] = '';
								?>
								<div class="row">
										<div class="col-xs-8">
											<div class="form-group">
												<input class="form-control" value="<?php echo htmlentities($mvctemplate['stack']['data_links']['data']['subtitles'][$key]); ?>" name="subtitles[<?php echo $key; ?>]">
											</div>
										</div>
										<div class="col-xs-4">
											<div class="form-group">
												<input class="form-control" value="<?php echo $value; ?>" disabled>
											</div>
										</div>
								</div>
								<?php }} ?>
								
								<hr>
								<div class="row">
										<div class="col-xs-12">
											<div class="form-group">
												<label class="control-label">Code Embed:</label>
												<textarea class="form-control" rows="5" ><?php echo htmlentities(get_embed_code($mvctemplate['stack']['data_links']['id'])); ?></textarea>
											</div>
										</div>
										<div class="col-xs-12">
											<div class="form-group">
												<label class="control-label">Link Embed:</label>
												<input class="form-control" value="<?php echo htmlentities(get_link_embed($mvctemplate['stack']['data_links']['id'])); ?>">
											</div>
										</div>
								</div>
								
								
							</div>
							<?php if(user::canEditPost($mvctemplate['stack']['data_links']['user_id'])){ ?>
							<div class="panel-footer">
								<button type="submit" class="btn btn-info">EDIT LINK</button>
							</div>
						</form>
							<?php } ?>
					</div>
<?php include(__DIR__  . '/footer.php'); ?>