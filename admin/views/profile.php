<?php include(__DIR__ . '/header.php'); ?>
				<div class="container-fluid">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">EDIT USER</h3>
						</div>
						<?php if(isset($mvctemplate['stack']['msg'])) : ?><div class="alert alert-<?php echo $mvctemplate['stack']['color']; ?> text-left" style="margin-top: 10px;" role="alert"><?php echo $mvctemplate['stack']['msg']; ?></div><?php endif; ?>
						<form method="post" action="<?php echo $mvctemplate['url']; ?>/?do=profile">
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-4 col-md-6">
										<div class="form-group">
											<label for="jc_name" class="control-label">New Password:</label> <i class="fa fa-info-circle text-muted" data-toggle="tooltip" title="New Password"></i>
											<input type="password" class="form-control" name="newpassword" placeholder="New Password">
										</div>
										<div class="form-group">
											<label for="jc_name" class="control-label">Re write New Password:</label> <i class="fa fa-info-circle text-muted" data-toggle="tooltip" title="Re write New Password"></i>
											<input type="password" class="form-control" name="newpassword2" placeholder="Re write New Password">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-2 col-md-3">
										<div class="form-group">
											<label for="jc_name" class="control-label">Current Password:</label> <i class="fa fa-info-circle text-muted" data-toggle="tooltip" title="Current Password"></i>
											<input type="password" class="form-control" name="oldpassword" placeholder="Current Password">
										</div>
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<button type="submit" class="btn btn-info">EDIT USER</button>
							</div>
						</form>
					</div>
				</div>
<?php include(__DIR__  . '/footer.php'); ?>