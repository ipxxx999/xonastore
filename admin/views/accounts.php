<?php include(__DIR__ . '/header.php'); ?>
				<div class="container-fluid">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">New User</h3>
						</div>
						<form method="post" action="<?php echo $mvctemplate['url']; ?>/?do=accounts">
							<input type="hidden" name="action" value="createUser" />
							<div class="panel-body">
								<div class="row">
										<div class="col-lg-4 col-md-6 float-left">
											<div class="form-group">
												<label class="control-label">Username:</label>
												<input type="text" class="form-control" name="username" >
											</div>
										</div>
										<div class="col-lg-4 col-md-6 float-left">
											<div class="form-group">
												<label class="control-label">Password:</label>
												<input type="password" class="form-control" name="password" >
											</div>
										</div>
										<div class="col-lg-4 col-md-6 float-left">
											<div class="form-group">
												<label class="control-label">Rol:</label>
												<select class="form-control" name="rol">
													<option value="4">Collaborator</option>
													<option value="3">Autor</option>
													<option value="2">Editor</option>
													<option value="1">Administrador</option>
												</select>
											</div>
										</div>
								</div>
							</div>
							<div class="panel-footer">
								<button type="submit" class="btn btn-info">CREATE USER</button>
							</div>
						</form>
					</div>
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">List Users</h3>
						</div>
						<div style="padding: 10px;">
							<div class="table-responsive">
								<table class="table table-striped no-margins">
									<thead>
										<tr>
											<th width="10px">#</th>
											<th>Username</th>
											<th>Rol</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
									<?php 
									
										if(!empty($mvctemplate['stack']['users'])){ 
											foreach($mvctemplate['stack']['users'] as $user){
									?>
										<tr>
											<td><?php echo $user['id']; ?></td>
											<td><?php echo $user['username']; ?></td>
											<td><?php echo translate_rol($user['rol']); ?></td>
											<td><a data-toggle="modal" data-username="<?php echo $user['username']; ?>" data-userid="<?php echo $user['id']; ?>" data-target="#editUserModal" class="btn btn-xs btn-info open-AddBookDialog"><i class="fa fa-pencil"></i> EDIT</a>
												<a href="<?php echo $mvctemplate['url']; ?>/?do=accounts&sa=delete&id=<?php echo $user['id']; ?>" onclick="return jc_confirm(this);" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> DELETE</a> 
											</td>
										</tr>
									<?php }} ?>
									</tbody>
								</table>
						</div>
					</div>
				</div>
<!-- Modal -->
<div id="editUserModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">User Edit</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $mvctemplate['url']; ?>/?do=accounts">
			<input type="hidden" name="action" value="editUser" />
			<input type="hidden" name="userid" id="userid" value="0" />
			<div class="row">
				<div class="col-lg-4 col-md-6 float-left">
					<div class="form-group">
						<label class="control-label">Username:</label>
						<div id="username"></div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 float-left">
					<div class="form-group">
						<label class="control-label">Password:</label>
						<input type="password" class="form-control" name="password" >
					</div>
				</div>
				<div class="col-lg-4 col-md-6 float-left">
					<div class="form-group">
						<label class="control-label">Rol:</label>
						<select class="form-control" name="rol">
						<option value="0">No change</option>
						<option value="4">Collaborator</option>
						<option value="3">Autor</option>
						<option value="2">Editor</option>
						<option value="1">Administrador</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col" style="margin-left: 10px;">
					<button type="submit" class="btn btn-info">EDIT USER</button>
				</div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script>
$(document).on("click", ".open-AddBookDialog", function () {
     var uid = $(this).data('userid');
     var username = $(this).data('username');
     $(".modal-body #userid").val( uid );
     $(".modal-body #username").text( username );
});
</script>
<?php include(__DIR__  . '/footer.php'); ?>