@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header"><i class="fa fa-users"></i> Tell me your activities
					<div class="float-right">
						<button class="btn btn-black btn-sm" data-toggle="modal" data-target="#user__modal">
							<i class="fa fa-plus"></i> Create new user
						</button>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table id="table_view" class="table table-striped m-table m-table--head-bg-brand">
							<thead style="background-color: black; color: white">
								<tr>
									<th width="10px">No</th>
									<th>Name</th>
									<th>Email</th>
									<th>Roles</th>
									<th>Action</th>
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
@endpush