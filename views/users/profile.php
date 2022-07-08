<style>
	.profilepic:hover {opacity:0.8}
</style>

<?php if ($b == 'Edit') { ?>
<div class="modal-header">
	<h5 class="modal-title">Edit User</b></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
<?php } ?>

<?php if ($b != 'Edit') { ?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark"><?php echo $lang['Profile'] ?></h1>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content" >
    <div class="container-fluid">
	<?php } ?>

		<div class="row">
			<div class="col-lg-12">
				<?php require_once 'new.php' ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-<?php echo ($user->role == 2) ? '6' : '12' ?>">
				<div class="card">
					<div class="card-body">
						<div class="d-flex flex-column">
							<div class="mt-3">
								<h3>Permissions</h3>
							</div>
						</div>

						<form id="userPermissions_form">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
									<label>Role:</label>
									<div class="input-group">
										<select class="form-control form-control-sm roleId" type="number" name="roleId" required>
										<option></option>
										<?php foreach($this->users->RolesList() as $r) { ?>
											<option <?php echo ($user->role == $r->id) ? 'selected' : '' ?> value="<?php echo $r->id ?>"><?php echo $r->rolename ?></option>
										<?php } ?>                    
										</select>
										<input type="hidden" name="userId" value="<?php echo $user->id ?>">
									</div>
									</div>
								</div>
								<div class="col-sm-12 permissions">
								<?php foreach ($this->users->PermissionsTitleList() as $t) { ?>
									<div class="mt-3">
										<h5><?php echo $t->category ?></h5>
										<hr>
									</div>

									<?php 
									$userPermissions = json_decode($this->users->permissionsGet($user->id)->permissions);
									foreach ($this->users->PermissionsList($t->category) as $p) { ?>
									<label class="btn <?php echo (in_array($p->id, $userPermissions)) ? 'btn-primary' : 'btn-secondary'; ?> permission active" data-id="<?php echo $p->id ?>" style="cursor:pointer">
										<?php echo $p->name ?>
										<?php echo (in_array($p->id, $userPermissions)) ? "<input type='hidden' name='permissions[]' value='$p->id'>" : ""; ?>
										
									</label>
									<?php } ?>
						
								<?php } ?>
								</div>
							</div>
							<div class="row mt-3">
							<?php  if (in_array(6, $permissions)) { ?>
								<div class="col-12 text-right">
									<button type="submit" class="btn btn-primary">Update</button>
								</div>
								<?php  } ?>
							</div>
						</form>

					</div>
				</div>
			</div>
			<?php if($user->role == 2) { ?>
			<div class="col-sm-6">
				<div class="card">
					<div class="card-body">
						<div class="d-flex flex-column">
							<div class="mt-3">
							<?php  if (in_array(6, $permissions)) { ?>
								<button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#userPermissions_modal">
									<i class="fas fa-edit"></i> Edit
								</button>
							<?php } ?>
								<h3>Machines</h3>
							</div>
						</div>
						<ul class="list-group list-group-flush mt-3">
							<?php foreach($this->users->userMachinesList($user->id) as $r) { ?>
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0"><?php echo $r->title ?></h6>
							</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>



<script>

$(document).on('click','.permission', function() {
	id = $(this).data('id');
	div = `<input type='hidden' name='permissions[]' value='${id}'>`;
    $(this).toggleClass('btn-primary btn-secondary active');
	if ($(this).hasClass("btn-secondary")) {
		$(this).find('input').remove();
    } else {
		$(this).append(div).val(id);
    }
});

$(document).on('submit','#userPermissions_form', function(e) {
    e.preventDefault();
	$("#loading").show();
	$.post( "?c=Users&a=UserPermissionsSave", $("#userPermissions_form").serialize()).done(function( res ) {
		location.reload();   
	});
});


$(document).on('change','.roleId', function() {
	roleId = $(this).val();
	$.post( "?c=Users&a=RolePermissions", {roleId}).done(function( res ) {
		$(".permissions").html(res);
	});
});
</script>