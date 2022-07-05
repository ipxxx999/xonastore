<?php include(__DIR__ . '/header.php'); ?>
				<div class="container-fluid">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">List Servers</h3>
							<div class="right"><a class="btn btn-primary btn-sm" href="<?php echo $mvctemplate['url']; ?>/?do=addservers">Add Server</a></div>
						</div>
						<div style="padding: 10px;">
							<div class="table-responsive">
								<table class="table table-striped no-margins">
									<thead>
										<tr>
											<th width="10px">#</th>
											<th>Nombre</th>
											<th>IP</th>
											<th>Tipo</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
									<?php 
									
										if(!empty($mvctemplate['stack']['servers']["servidores"])){ 
											foreach($mvctemplate['stack']['servers']["servidores"] as $link){												
									?>
										<tr>
											<td><?php echo $link['id']; ?></td>
											<td><?php echo $link['nombre']; ?></td>
											<td><?php echo $link['ip_ftp']; ?></td>
											<td><?php echo $link['tipo_servidor']; ?></td>
											<td>
												<?php if(user::canEditPost($link['id'])){ ?>
												<a href="<?php echo $mvctemplate['url']; ?>/?do=editservers&id=<?php echo $link['id']; ?>" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> EDIT</a>
												<a href="<?php echo $mvctemplate['url']; ?>/?do=servers&sa=delete&id=<?php echo $link['id']; ?>" onclick="return jc_confirm(this);" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> DELETE</a> 
												<a href="<?php echo $mvctemplate['url']; ?>/?do=servers&sa=verify&id=<?php echo $link['id']; ?>" onclick="return jc_confirm(this);" class="btn btn-xs btn-primary btn-sm"><i class="fa fa-updates"></i> VERIFY</a> 
												<?php } ?>
											</td>
										</tr>
									<?php }} ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="panel-footer">
                            <div class="row">
                                <div class="col-md-3">
                                    
                                </div>
                                <div class="col-md-9 text-right">
								<?php
									$nextLink = '#';
									$prevLink = '#';
									if(!empty($mvctemplate['stack']['servers']['next_page'])) $nextLink = $mvctemplate['url'] . '/?do=links&search=' . $mvctemplate['stack']['servers']['search'] . '&page=' . $mvctemplate['stack']['servers']['next_page'];
									if(!empty($mvctemplate['stack']['servers']['prev_page'])) $prevLink = $mvctemplate['url'] . '/?do=links&search=' . $mvctemplate['stack']['servers']['search'] . '&page=' . $mvctemplate['stack']['servers']['prev_page'];
										
								?>
                                    <ul class="pagination no-margins">
                                        <li class="<?php if(empty($mvctemplate['stack']['servers']['prev_page'])) echo 'disabled'; ?>"><a href="<?php echo$prevLink; ?>">Prev</a></li>
                                        <li class="active"><a href="#"><?php echo $mvctemplate['stack']['servers']['current_page']; ?> de <?php echo $mvctemplate['stack']['servers']['total_pages']; ?></a></li>
                                        <li class="<?php if(empty($mvctemplate['stack']['servers']['next_page'])) echo 'disabled'; ?>"><a href="<?php echo$nextLink; ?>">Next</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
<!-- Modal -->
<div id="embedCodeModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Embed Codes</h4>
      </div>
      <div class="modal-body">
		<div class="row">
										<div class="col-xs-12">
											<div class="form-group">
												<label class="control-label">Code Embed:</label>
												<textarea id="codeembed" class="form-control" rows="5" ></textarea>
											</div>
										</div>
										<div class="col-xs-12">
											<div class="form-group">
												<label class="control-label">Link Embed:</label>
												<input id="linkembed" class="form-control" value="">
											</div>
										</div>
								</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script>
$(document).on("click", ".open-AddBookDialog", function () {
	 var linkid = $(this).data('linkid');
     var codembed = '<?php echo str_replace("'","\'",htmlentities(get_embed_code('LINKID'))); ?>';
     var linkcode = '<?php echo htmlentities(get_link_embed('LINKID')); ?>';
     $(".modal-body #codeembed").html( codembed.replace("LINKID", linkid) );
     $(".modal-body #linkembed").val( linkcode.replace("LINKID", linkid) );
});
</script>
<?php include(__DIR__  . '/footer.php'); ?>