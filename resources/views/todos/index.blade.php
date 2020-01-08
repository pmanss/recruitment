@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header"><i class="fa fa-users"></i> Tell me your activities
					<div class="float-right">
						@can('todo-create')
						<button class="btn btn-hitam btn-sm" data-toggle="modal" data-target="#todo__modal">
							<i class="fa fa-plus"></i> Create new to do
						</button>
						@endcan
					</div>
				</div>
				<div class="card-body">
					<label>Status:</label>
					<select name="status" id="filter_status" class="form-control col-md-3">
						<option value="">Semua</option>
						<option value="Wacana">Wacana</option>
						<option value="Sedang Dikerjakan">Sedang dikerjakan</option>
						<option value="Selesai">Selesai</option>
					</select> 
					<br>
					<button class="btn btn-primary" id="m_search">
						<i class="fa fa-search"></i>
						<span>Cari</span>
					</button>
					<p>

						<div class="table-responsive">
							<table id="table_view" class="table table-striped m-table m-table--head-bg-brand">
								<thead style="background-color: black; color: white">
									<tr>
										<th width="10px">No</th>
										<th>Dibuat</th>
										<th>Judul aktifitas</th>
										<th>Detail aktifitas</th>
										<th>Status</th>
										<th>Pengeluaran</th>
										<th>Pemasukan</th>
										<th>Diupdate</th>
										<th>Action</th>
									</tr>
								</thead>
								<tfoot>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th>Total</th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@include('todos.create')
	@endsection
	@push('scripts')

	<script type="text/javascript">
		function rupiah(angka){
			var reverse = angka.toString().split('').reverse().join(''),
			ribuan = reverse.match(/\d{1,3}/g);
			ribuan = ribuan.join('.').split('').reverse().join('');
			return ribuan;
		}

		$('document').ready(function(){

			var getFilter = function(){
				return {
					'status': $('#filter_status').val(),
				}
			}
			var btnSearch = $('#m_search')
			btnSearch.on('click', function(){
				dataTodo.draw()
			})

			window.dataTodo = $('#table_view')
			.DataTable({
				processing: true,
				serverSide: true,
				dom: 'Bfrltip',
				buttons: [ { extend: 'excelHtml5', text: 'Export ke Excel'}, ],
				columnDefs: [ 
				{
					targets: 4,
					render: function ( data, type, row ) {
						if (data == "Wacana" ) {
							return '<center><span class="btn btn-danger btn-sm">Wacana</span></center>';
						}
						if (data == "Sedang Dikerjakan" ) {
							return '<center><span class="btn btn-primary btn-sm">Sedang Dikerjakan</span></center>';
						}
						else {
							return '<center><span class="btn btn-success btn-sm">Selesai</span></center>';
						}
					},
				},
				{
					targets: 5,
					render: function ( data, type, row ) {
						return  'Rp.'+ rupiah(data) 
					},
				},
				{
					targets: 6,
					render: function ( data, type, row ) {
						return  'Rp.'+ rupiah(data) 
					},
				},
				],
				ajax: {
					url: '{!! route('todos.index') !!}',
					data: function(data){
						data.filters = getFilter()
					}
				},
				columns: [
				{ data: 'DT_RowIndex','orderable':false,'searchable':false},
				{ data: 'created_at', name:'created_at' },
				{ data: 'activity', name:'activity' },
				{ data: 'activity_detail', name: 'activity_detail' },
				{ data: 'status', name: 'status' },
				{ data: 'outcome', name: 'outcome' },
				{ data: 'income', name: 'income' },
				{ data: 'updated_at', name: 'updated_at' },
				{ data: 'action', name: 'action' }
				],
				"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;
		        // Remove the formatting to get integer data for summation
		        var intVal = function ( i ) {
		        	return typeof i === 'string' ?
		        	i.replace(/[\$,]/g, '')*1 :
		        	typeof i === 'number' ?
		        	i : 0;
		        };

		        pengeluaran = api
		        .column( 5, { page: 'current'} )
		        .data()
		        .reduce( function (a, b) {
		        	return intVal(a) + intVal(b);
		        }, 0 );

		        // Update footer
		        $( api.column( 5 ).footer() ).html(
		        	'Rp.'+ rupiah(pengeluaran)
		        	);

		        pemasukan = api
		        .column( 6, { page: 'current'} )
		        .data()
		        .reduce( function (a, b) {
		        	return intVal(a) + intVal(b);
		        }, 0 );

		        // Update footer
		        $( api.column( 6 ).footer() ).html(
		        	'Rp.'+ rupiah(pemasukan)
		        	);
		    }

			});

			if ($("#form__action").length > 0) {
				$("#form__action").validate({
					rules: {
						activity: {
							required: true,
							maxlength: 50
						},

						activity_detail: {
							required: true,
						},
						income: {
							required: true,
							digits:true,
						},
						outcome: {
							required: true,
							digits:true,
						},
					},
					messages: {
						activity: {
							required: "Judul wajib diisi",
							maxlength: "Panjang maksimal karakter 50."
						},
						activity_detail: {
							required: "Kegiatanmu wajib diisi",
						},
						income: {
							required: "Pemasukan wajib diisi",
							digits: "Hanya boleh angka",
						},
						outcome: {
							digits: "Hanya boleh angka",
						},
					},
					submitHandler: function(form) {
						var btn     = $('#btn__store');
						var actionType = btn.val();
						btn.html('Mengirim..');
						$.ajax({
							data: $('#form__action').serialize(),
							url: '{{route("todos.store")}}',
							type: "POST",
							dataType: 'json',
							success: function (data) {
								$('#form__action').trigger("reset");
								btn.html('<i class="fa fa-save" id="icon"></i> Simpan');
								var oTable = $('#table_view').dataTable();
								oTable.fnDraw(false);
								toastr.success('Data berhasil disimpan.','Sukses!');
								if ($('#btn_store').click()) {
									$('#btn_close').click();
								}
							},
							error: function (xhr, statusText, errorThrown) {
								if (xhr.status == 500) {
									toastr.warning('Email tidak boleh sama' ,'Error!');
								}
								if (xhr.status == 422) {
									toastr.warning('Password harus sama' ,'Error!');
								}
							}
						});
					}
				})
			}

			$('body').on('click', '.btn-update', function () {
				var id = $(this).data('id');
				var name = $(this).data('name');
				$.get("{{ route('todos.index') }}" +'/' + id +'/edit', function (data) {
					$('#btn_store').val("update-todo");
					$('#todo__modal').modal('show');
					$('#id').val(data.id);
					$('#activity').val(data.activity);
					$('#activity_detail').val(data.activity_detail);
					$('#user_id').val(data.user_id);
					$('#income').val(data.income);
					$('#outcome').val(data.outcome);
					$('#status').val(data.status).trigger('change');
				})
			});

			$('body').on('click', '#destroy', function () {
				var id = $(this).data('id');
				var name = $(this).data('name');
				var result = confirm('Yakin ingin menghapus '+name+'?');
				if (result==true) {
					$.ajax({
						type: "DELETE",
						url:"users/"+id,
						success: function (data) {
							var oTable = $('#table_view').dataTable(); 
							oTable.fnDraw(false);
						},
					}).done(function(data){
						var oTable = $('#table_view').dataTable(); 
						oTable.fnDraw(false);
						toastr.error(''+name+' berhasil dihapus.','Sukses!');
					});
				} else {
					return false;
				}
			});

		});

	</script>

	@endpush