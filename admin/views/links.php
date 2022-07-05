<?php include(__DIR__ . '/header.php'); ?>

<div class="col-md-3">
                                    <form method="get" action="<?php echo $mvctemplate['url']; ?>/">
										<input type="hidden" name="do" value="links" />
                                        <div class="input-group"><input type="text" class="form-control input-sm" name="search" placeholder="Search Links By Title"><span class="input-group-btn"><button type="submit" class="btn btn-info btn-sm">Search</button></span></div>
                                    </form>
                                </div><br>

<style>
.swal2-popup {
	font-size:15px;
}
</style>


<script>
function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
}
function ConfirmarReinicio(id) {

Swal.fire({
  title: 'Estas seguro?',
  text: "Estas seguro de reiniciar este enlace",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Reiniciar'
}).then((result) => {
  if (result.isConfirmed) {
	  
$.post( "inc/ajax.php", {id: id}, function( data ) {
  if(data) {
  location.reload();
  }
});
	  
	  
    
  }
})
	
}
</script>

	
	
				<div class="container-fluid">
				
				
				
					<div class="panel">
					
					
					
						<div class="panel-heading">
						
						
						
							<h3 class="panel-title">List Links</h3>
								
								
							<div class="right">
							<a class="btn btn-primary btn-sm" href="<?php echo $mvctemplate['url']; ?>/?do=addlink">Add Link</a>
							
							
							
							
							</div>
							
							
						
							
								
					
							
						</div>
						
						
						
						
						<div style="padding: 10px;">
							<div class="table-responsive">
								<table class="table table-striped no-margins">
									<thead>
										<tr>
											<th width="10px">#</th>
											<th>Title</th>
											<th>Users</th>
											<th>Views</th>
											<th>Embeds</th>
											<th>Actions</th>
											<th>Quality</th>
											<th>Copy</th>
											<?php if(user::isAdmin()){ ?>
											<th>Opciones</th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
									<?php 
										if(!empty($mvctemplate['stack']['data_links']["links"])){ 
											$i = 1;
											$contar = $mvctemplate['stack']['data_links']['total_rows'];
											$current_page = $mvctemplate['stack']['data_links']['current_page'];
											$per_page = $mvctemplate['stack']['data_links']['per_page'];
											$resultado = $contar;
											if($current_page > 1) {
											$re = $current_page - 1;	
											$resultado = $contar - ($per_page * $re);	
											}
											
											
											foreach($mvctemplate['stack']['data_links']["links"] as $link){									
												if(empty($link['username'])) $link['username'] = '-';
												$ubicacion = $link['ubicacion'];
												$enlace = $mvctemplate['stack']['data_links'];
												
												$check_enlace = false;	
												$enlace = json_decode($link['data'])->link;	
												if(strpos($enlace, 'http') !== FALSE) $check_enlace = true;																																															
									?>
										<tr>
											<td><?php echo $resultado; ?></td>
											<td><?php echo $link['title']; ?></td>
											<td><?php echo $link['username']; ?></td>
											<td><?php echo $link['views']; ?></td>
											<td><a data-toggle="modal" data-linkid="<?php echo $link['id']; ?>" data-target="#embedCodeModal" class="btn btn-xs btn-info open-AddBookDialog"><i class="fa fa-pencil"></i> Embed</a></td>
											<td>
												<?php if(user::canEditPost($link['user_id'])){ ?>
												<a href="<?php echo $mvctemplate['url']; ?>/?do=editlink&id=<?php echo $link['id']; ?>" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> EDIT</a>
												<a href="<?php echo $mvctemplate['url']; ?>/?do=links&sa=delete&id=<?php echo $link['id']; ?>" onclick="return jc_confirm(this);" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> DELETE</a> 
												<?php } ?>
											</td>
											<td><?php echo obtener_calidades($link['id']); ?></td>
											<td><a href="#" onclick="copyToClipboard('#p<?php echo $i; ?>')">Copy M3U8<p id="p<?php echo $i; ?>" style="display:none;"><?php echo PROXYDOMAIN; ?>/<?php echo $ubicacion; ?></p></a></td>
										    <?php if(user::isAdmin()){ if($check_enlace) { ?>
											<td><button class="btn btn-xs btn-info" onclick="ConfirmarReinicio(<?php echo $link['id']; ?>);"><i class="fa fa-refresh"></i> Reiniciar Link</button></td>
											<?php } else { echo '<td></td>'; } } ?>
										</tr>
									<?php $i++; $resultado--; }} ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="panel-footer">
                            <div class="row">
                                
								
								
								
                                <div class="col-md-12 text-right">
								<?php
									$nextLink = '#';
									$prevLink = '#';
									
									if(!empty($mvctemplate['stack']['data_links']['next_page'])) $nextLink = $mvctemplate['url'] . '/?do=links&search=' . $mvctemplate['stack']['data_links']['search'] . '&page=' . $mvctemplate['stack']['data_links']['next_page'];
									if(!empty($mvctemplate['stack']['data_links']['prev_page'])) $prevLink = $mvctemplate['url'] . '/?do=links&search=' . $mvctemplate['stack']['data_links']['search'] . '&page=' . $mvctemplate['stack']['data_links']['prev_page'];
										
								?>
                                    <ul class="pagination no-margins">
                                        <li class="<?php if(empty($mvctemplate['stack']['data_links']['prev_page'])) echo 'disabled'; ?>"><a href="<?php echo$prevLink; ?>">Prev</a></li>
                                        <li class="active"><a href="#"><?php echo $mvctemplate['stack']['data_links']['current_page']; ?> de <?php echo $mvctemplate['stack']['data_links']['total_pages']; ?></a></li>
                                        <li class="<?php if(empty($mvctemplate['stack']['data_links']['next_page'])) echo 'disabled'; ?>"><a href="<?php echo$nextLink; ?>">Next</a></li>
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
											<div class="form-group" id="iframe_embed">
												
											</div>
										</div>
		
		
		
		
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
	 var codembed2 = '<?php echo str_replace('height="100%"', 'height="315"', get_embed_code('LINKID')); ?>';
     var linkcode = '<?php echo htmlentities(get_link_embed('LINKID')); ?>';
     $(".modal-body #codeembed").html( codembed.replace("LINKID", linkid) );
	 document.getElementById("iframe_embed").innerHTML = codembed2.replace("LINKID", linkid);
     $(".modal-body #linkembed").val( linkcode.replace("LINKID", linkid) );
});
</script>
<?php include(__DIR__  . '/footer.php'); ?>