@extends('admin.layouts.app')
@section('css')
<style type="text/css">
    .dev_center {
        margin: 0 auto;
        max-width: 6000px;
        max-height: 6000px;
        /* Adjust the max-width based on your requirements */
        padding-top: 40px;
    }

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"><link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
</style>

@endsection
@section('content')


<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id='form'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="modeltitle">Modal title</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="category_id" name="category_id" id="category_id">
                    <div class="input-group flex-nowrap">
                        <input type="text" class="form-control name" placeholder="Name" aria-label="name" name="name"
                            id="name" aria-describedby="addon-wrapping">
                    </div>
                    <span id='nameError' class="text-danger error_message"></span>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="add">Add Category</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="col-lg-6 grid-margin stretch-card dev_center">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Categories
                <a href="#" class="btn btn-success float-right add-category-btn" data-bs-toggle="modal"
                    data-bs-target="#modal">Add Category</a>

            </h4>

            </p>
            <div class="table-responsive">
                {{ $dataTable->table(['class' => 'table table-bordered table-striped mb-0','style'=>'width:100%'])
                }}
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap4-editable/js/bootstrap-editable.min.js') }}"></script>
<script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
<script>
    $(document).ready(function(){
        $('#modal').on('hidden.bs.modal', function () {
            $('#form')[0].reset();
            $('.error_message').html('');
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.add-category-btn').click(function(){
            $('#modeltitle').html('Create Category');
            $('#add').html('Save');
            $('.name').val('');
            $('.category_id').val('');
        })
        $('#modeltitle').html('Create Category');
        $('#add').html('Save');
        var formData = $('#form')[0];
        $('#add').click(function(){
            $('.error_message').html('');

            $('#add').html('Saving...');
            $('#add').attr('disabled',true);

            var form = new FormData(formData);
            $.ajax({
                url: '{{ route('categories_store') }}',
                method: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data) {
                    window.LaravelDataTables["categories"].draw();
                    $('#add').attr('disabled',false);
                    $('#add').html('Save Category');

                    $('#modal').modal('hide');

                    if(data){
                        Swal.fire('Success!',data.message, data.status?'success':'error');

                    }
                },
                error: function(error) {
                    $('#add').attr('disabled',false);
                    $('#add').html('Save Category');
                    if (error.responseJSON && error.responseJSON.errors && error.responseJSON.errors.name) {
                        $('#nameError').html(error.responseJSON.errors.name);
                    } else {
                        // Handle other types of errors as needed
                        console.error(error);
                    }
                }
            });
        });


        $('body').on('click','.edit-this',function(e){
            e.preventDefault();
            let el=$(this);
            let url=el.attr('data-url');
            let id=el.attr('data-id');
            $.ajax({
                method: "get",
                url: url,
                data: {"_token": "{{ csrf_token() }}"},
                success: function (msg) {
                    $('#modal').modal('show');
                    $('#modeltitle').html('Update Category');
                    $('#add').html('Update');
                    $('#category_id').val(msg.id);
                    $('#name').val(msg.name);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

    });
    $(document).on('click','.delete-this',function(e){
        e.preventDefault();
        let el=$(this);
        let url=el.attr('data-url');
        let id=el.attr('data-id');
        Swal.fire({
            title: '{{ __('Do you really want to delete this?') }}',
            showCancelButton: true,
            confirmButtonText: '{{ __('Yes') }}',
            cancelButtonText: '{{ __('No') }}',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    method: "delete",
                    url: url,
                    data: {
                "_token": "{{ csrf_token() }}"},
                    success: function (msg) {
                        window.LaravelDataTables["categories"].draw();
                        Swal.fire('Success!',msg.message, msg.status?'success':'error');
                    }
                });

            }
        });
    });

</script>
@endsection
