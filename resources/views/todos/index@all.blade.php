@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header"><i class="fa fa-users"></i> Tell me your activities
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>User:</label>

								<select name="user_id" id="filter_user" class="form-control">
									<option value="">Semua</option>
									@foreach ($user as $get)
									<option value="{{$get->id}}">{{$get->name}}</option>
									@endforeach
								</select> 
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Status:</label>

								<select name="status" id="filter_status" class="form-control">
									<option value="">Semua</option>
									<option value="Wacana">Wacana</option>
									<option value="Sedang Dikerjakan">Sedang dikerjakan</option>
									<option value="Selesai">Selesai</option>
								</select> 
							</div>
						</div>
						<div class="form-group">
							<label>&nbsp;</label>
							<button class="btn btn-primary form-control" id="m_search">
								<i class="fa fa-search"></i>
								<span>Cari</span>
							</button>
						</div>
					</div>

					<div class="table-responsive">
						<table id="table_view" class="table table-striped m-table m-table--head-bg-brand">
							<thead style="background-color: black; color: white">
								<tr>
									<th width="10px">No</th>
									<th>User</th>
									<th>Dibuat</th>
									<th>Judul aktifitas</th>
									<th>Detail aktifitas</th>
									<th>Status</th>
									<th>Diupdate</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('scripts')

<script type="text/javascript">

	$('document').ready(function(){

		var getFilter = function(){
			return {
				'status': $('#filter_status').val(),
				'user_id': $('#filter_user').val(),

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
				targets: 5,
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
			],
			ajax: {
				url: '{!! route('index_all') !!}',
				data: function(data){
					data.filters = getFilter()
				}
			},
			columns: [
			{ data: 'DT_RowIndex','orderable':false,'searchable':false},
			{ data: 'name', name:'users.name' },
			{ data: 'created_at', name:'created_at' },
			{ data: 'activity', name:'activity' },
			{ data: 'activity_detail', name: 'activity_detail' },
			{ data: 'status', name: 'status' },
			{ data: 'updated_at', name: 'updated_at' },
			]
		});
	});

</script>

@endpush