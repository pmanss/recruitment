<div class="modal fade" id="user__modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" >User Form</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form__action" name="form__action">
				<div id="user__form" class="modal-body">
					<div class="modal-body">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<input type="hidden" name="id" id="id">
							<div class="form-group">
								<strong>Name:</strong>
								{!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control','id' => 'name')) !!}
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<strong>Email:</strong>
								{!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control','id' => 'email')) !!}
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<strong>Password:</strong>
								{!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control','id' => 'password')) !!}
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<strong>Confirm Password:</strong>
								{!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<strong>Role:</strong>
								<select name="roles" id="roles" class="form-control" required>
									<option value="">Select Role</option>
									@foreach($roles as $role)
									<option value="{{$role->name}}">{{$role->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button id="btn_close" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button id="btn_store" value="user_store" type="submit" class="btn btn-black"><i class="fa fa-save"></i> Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>