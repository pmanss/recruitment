<div class="modal fade" id="todo__modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" >User Form</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form__action" name="form__action">
				<div id="todo__form" class="modal-body">
					<div class="modal-body">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<input type="hidden" name="id" id="id">
							<div class="form-group">
								<strong>Judul Aktifitas:</strong>
								{!! Form::text('activity', null, array('placeholder' => '','class' => 'form-control','id' => 'activity')) !!}
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<strong>Aktifitas:</strong>
								{!! Form::textarea('activity_detail', null, array('placeholder' => 'Ceritakan kegiatanmu','class' => 'form-control','id' => 'activity_detail')) !!}
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<strong>Status:</strong>
								<select name="status" id="status" class="form-control" required>
									<option value="Wacana">Wacana</option>
									<option value="Sedang Dikerjakan">Sedang Dikerjakan</option>
									<option value="Selesai">Selesai</option>
								</select>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<strong>Pengeluaran:</strong>
								{!! Form::text('income', null, array('placeholder' => 'Rp.','class' => 'form-control','id' => 'income')) !!}
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<strong>Pemasukan:</strong>
								{!! Form::text('outcome', null, array('placeholder' => 'Rp.','class' => 'form-control','id' => 'outcome')) !!}
							</div>
						</div>
						<input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }} ">
					</div>
				</div>
				<div class="modal-footer">
					<button id="btn_close" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button id="btn_store" value="todo_store" type="submit" class="btn btn-black"><i class="fa fa-save"></i> Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>