@extends('admin.master')
@section('title')
    Visitor Info | {{env('APP_NAME')}}
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
                <h4 class="page-title">Visitor Info Manage</h4>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="alternative-page-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                        <tr>
                            <th>S.N</th>
                            <th>IP</th>
                            <th>PORT</th>
                            <th>ISP NAME</th>
                            <th>MAC</th>
                            <th>CLICK TIME</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($visitors as $visitor)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$visitor->ip}}</td>
                            <td>{{$visitor->port}}</td>
                            <td>{{$visitor->isp}}</td>
                            <td>{{$visitor->mac}}</td>
                            <td>{{$visitor->created_at->format('Y-m-d H:m:s A')}}</td>

                            <td>
                                <a href="javascript:void(0)" class="btn btn-success btn-sm" title="Edit">
                                    <i class="ri-edit-box-fill"></i>
                                </a>
                                <button type="button" onclick="confirmDelete({{$visitor->id}});" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="ri-chat-delete-fill"></i>
                                </button>

                                <form action="javascript:void(0)" method="POST" id="privacyDeleteForm{{$visitor->id}}">
                                    @csrf
                                </form>
                                <script>
                                    function confirmDelete(dataId) {
                                        var confirmDelete = confirm('Are you sure you want to delete this?');
                                        if (confirmDelete) {
                                            document.getElementById('privacyDeleteForm' + dataId).submit();
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
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

@endsection



