@extends('admin.master')
@section('title')
    Work Experience Manage | {{env('APP_NAME')}}
@endsection

@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <form class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-light" id="dash-daterange">
                            <span class="input-group-text bg-primary border-primary text-white">
                                                    <i class="mdi mdi-calendar-range font-13"></i>
                                                </span>
                        </div>
                        <a href="javascript: void(0);" class="btn btn-primary ms-2">
                            <i class="mdi mdi-autorenew"></i>
                        </a>
                        <a href="javascript: void(0);" class="btn btn-primary ms-1">
                            <i class="mdi mdi-filter-variant"></i>
                        </a>
                    </form>
                </div>
                <h4 class="page-title">Work Experience Manage</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="alt-pagination-preview">
                            <table id="alternative-page-datatable" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Working Year</th>
                                    <th>Icon</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($experiences as $experience)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$experience->name}}</td>
                                        <td>{{$experience->position}}</td>
                                        <td>{{$experience->working_year}}</td>
                                        <td>
                                            <img src="{{asset($experience->icon)}}" alt="" style="height: 80px">
                                        </td>
                                        <td>
                                            @if($experience->status == 1)
                                                <span class="badge badge-success-lighten">Active</span>
                                            @else
                                                <span class="badge badge-danger-lighten">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('experience.edit', ['id' => $experience->id])}}" class="btn btn-success" title="Edit"><i class="uil-edit-alt"></i></a>
                                            <button type="button" onclick="confirmDelete({{$experience->id}});" class="btn btn-danger btn-sm" title="Delete">
                                                <i class="ri-chat-delete-fill"></i>
                                            </button>

                                            <form action="{{route('experience.delete', ['id' => $experience->id])}}" method="POST" id="experienceDeleteForm{{$experience->id}}">
                                                @csrf
                                            </form>
                                            <script>
                                                function confirmDelete(experienceId) {
                                                    var confirmDelete = confirm('Are you sure you want to delete this?');
                                                    if (confirmDelete) {
                                                        document.getElementById('experienceDeleteForm' + experienceId).submit();
                                                    } else {
                                                        return false;
                                                    }
                                                }
                                            </script>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                    </div> <!-- end tab-content-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->
@endsection


