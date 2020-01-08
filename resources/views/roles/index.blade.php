@extends('layouts.app')

@section('content')



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-users"></i> Manage Roles
                    <div class="float-right">
                        @can('role-create')
                        <button class="btn btn-hitam btn-sm" data-toggle="modal" data-target="#role__modal">
                            <i class="fa fa-plus"></i> Create new role
                        </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_view" class="table table-striped m-table m-table--head-bg-brand">
                            <thead style="background-color: black; color: white">
                                <tr>
                                    <th width="10px">No</th>
                                    <th>Name</th>
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
@include('roles.create')
@endsection

@push('scripts')

<script type="text/javascript">

    $('document').ready(function(){
        $('#table_view').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url : '{!! route('roles.index') !!}',
                
            },
            columns: [
            { data: 'DT_RowIndex','orderable':false,'searchable':false},
            { data: 'name', name:'name' },
            { data: 'action', name: 'action' }
            ]
        });

        if ($("#form__action").length > 0) {
            $("#form__action").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 50
                    },
                },
                messages: {
                    name: {
                        required: "Nama wajib diisi",
                        maxlength: "Panjang maksimal karakter 50"
                    },
                },
                submitHandler: function(form) {
                    var btn     = $('#btn__store');
                    var actionType = btn.val();
                    btn.html('Mengirim..');
                    $.ajax({
                        data: $('#form__action').serialize(),
                        url: '{{route("roles.store")}}',
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
                            if (xhr.status == 422) {
                                toastr.warning('Permission wajib dipilih' ,'Error!');
                            }
                        }
                    });
                }
            })
        }

        $('body').on('click', '.btn-update', function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            $.get("{{ route('roles.index') }}" +'/' + id +'/edit', function (data) {
                $('#btn_store').val("update-role");
                $('#role__modal').modal('show');
                $('#id').val(data.id);
                $('#name').val(data.name);
            })
        });

        $('body').on('click', '#destroy', function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var result = confirm('Yakin ingin menghapus '+name+'?');
            if (result==true) {
                $.ajax({
                    type: "DELETE",
                    url:"roles/"+id,
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