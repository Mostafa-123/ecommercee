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
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">


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
                    <input type="hidden" name="category_id" id="category_id">
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
            <div class="table-responsive" >
                <table class="table table-hover w-100" id="categories">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{--  @foreach ($categories as $key =>$category)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                             <td>
                                <a href="javascript:void(0)" class="btn btn btn-info edit_btn" data-id="{{ $category->id }}">Edit</a>
                                <a href="javascript:void(0)" class="btn btn btn-danger delete_btn" data-id="{{ $category->id }}">Delete</a>
                            </td>
                        </tr>
                        @endforeach  --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
 <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
 <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function(){
        new DataTable('#categories');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#categories').DataTable({
            processing:true,
            ServerSide:true,
            ajax:"{{ route('categories') }}",
            columns:[
                {data:'id'},
                {data:'name'},
                {data:'actions' ,name:'actions',orderable:false,searchable:false},

            ]

    });
        $('.add-category-btn').click(function(){
            $('#modeltitle').html('Create Category');
            $('#add').html('Save');
        })
        $('#modeltitle').html('Create Category');
        $('#add').html('Save');
        var formData = $('#form')[0];
        $('#add').click(function(){
            $('.error_message').html('');
            var form = new FormData(formData);
            $.ajax({
                url: '{{ route('categories_store') }}',
                method: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('#modal').modal('hide');
                    $('#name').html('');
                    if(data){
                        swal("Success!",data.message,"success")
                        dataTable.destroy();
                    loadDataTable();
                    }
                },
                error: function(error) {
                    if (error.responseJSON && error.responseJSON.errors && error.responseJSON.errors.name) {
                        $('#nameError').html(error.responseJSON.errors.name);
                    } else {
                        // Handle other types of errors as needed
                        console.error(error);
                    }
                }
            });
        });
        $('body').on('click','.edit_btn',function(){
            var id = $(this).data('id');
            $.ajax({
                url: '{{ url('/category/edit','') }}' + '/' + id,
                method: 'GET',
                success: function(response) {
                    $('#modal').modal('show');
                    $('#modeltitle').html('Update Category');
                    $('#add').html('Update');
                    $('#category_id').val(response.id);

                    $('#name').val(response.name);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
        {{--  $('.edit_btn').click(function(){
            $.ajax({
                url: '{{ url('/category/edit','') }}'+'/'+id,
                method: 'GET',
                data: form,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('#modal').modal('show');


                },
                error: function(error) {
                    console.log(error);
                }
            });
        })  --}}
        $('.delete_btn').click(function(){
            console.log('delete');
        });
        function loadDataTable() {
        dataTable = new DataTable('#categories');
    }

    });
</script>
@endsection
