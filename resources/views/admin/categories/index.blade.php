@extends('admin.layouts.app')
@section('css')
<style type="text/css">
    .dev_center {
        margin: 0 auto;
        max-width: 6000px;
        max-height: 6000px; /* Adjust the max-width based on your requirements */
        padding-top: 40px;
    }

</style>
@endsection
@section('content')

  {{--  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>  --}}
<div class="col-lg-6 grid-margin stretch-card dev_center">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Categories
            <form method="POST" action="{{ route('categories_create') }}">
                @csrf
                <button type="submit" class="btn btn-success float-right add-category-btn">Add Category</button>
            </form>

        </h4>

        </p>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>User</th>
                <th>Product</th>
                <th>Sale</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Jacob</td>
                <td>Photoshop</td>
                <td class="text-danger"> 28.76% <i class="mdi mdi-arrow-down"></i></td>
                <td><label class="badge badge-danger">Pending</label></td>
              </tr>
              <tr>
                <td>Messsy</td>
                <td>Flash</td>
                <td class="text-danger"> 21.06% <i class="mdi mdi-arrow-down"></i></td>
                <td><label class="badge badge-warning">In progress</label></td>
              </tr>
              <tr>
                <td>John</td>
                <td>Premier</td>
                <td class="text-danger"> 35.00% <i class="mdi mdi-arrow-down"></i></td>
                <td><label class="badge badge-info">Fixed</label></td>
              </tr>
              <tr>
                <td>Peter</td>
                <td>After effects</td>
                <td class="text-success"> 82.00% <i class="mdi mdi-arrow-up"></i></td>
                <td><label class="badge badge-success">Completed</label></td>
              </tr>
              <tr>
                <td>Dave</td>
                <td>53275535</td>
                <td class="text-success"> 98.05% <i class="mdi mdi-arrow-up"></i></td>
                <td><label class="badge badge-warning">In progress</label></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
