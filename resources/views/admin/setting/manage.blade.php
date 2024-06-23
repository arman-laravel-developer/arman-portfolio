@extends('admin.master')
@section('title')
    Setting Module | {{env('APP_NAME')}}
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
                <h4 class="page-title">Setting Module</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('setting.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{$settingManage->id ?? ''}}" name="setting_id">
                        <div class="row mb-3">
                            <label class="col-form-label">Light Logo</label>
                            <div class="">
                                <input type="file" name="light_logo" class="form-control @error('light_logo') is-invalid @enderror" id="imageInput">
                                <img id="imagePreview" class="mt-1" src="{{asset($settingManage->light_logo ?? '')}}" alt="Preview" style="max-width: 200px; max-height: 200px;">
                                @error('light_logo')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class=" col-form-label">Dark Logo</label>
                            <div class="">
                                <input type="file" name="dark_logo" class="form-control @error('dark_logo') is-invalid @enderror" id="imageInputDark">
                                <img id="imagePreviewDark" class="mt-1" src="{{asset($settingManage->dark_logo ?? '')}}" alt="Preview" style="max-width: 200px; max-height: 200px;">
                                @error('dark_logo')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class=" col-form-label">Favicon</label>
                            <div class="">
                                <input type="file" name="favicon" class="form-control @error('favicon') is-invalid @enderror" id="imageIconInput">
                                <img id="imageIconPreview" class="mt-1" src="{{asset($settingManage->favicon ?? '')}}" alt="Preview" style="max-width: 200px; max-height: 200px;">
                                @error('favicon')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputEmail3" class=" col-form-label"></label>
                            <div class="">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('appName')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class=" col-form-label">APP_NAME</label>
                            <div class="">
                                <input type="text" name="APP_NAME" value="{{env('APP_NAME')}}" class="form-control @error('APP_NAME') is-invalid @enderror">
                                @error('APP_NAME')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class=" col-form-label">APP_URL</label>
                            <div class="">
                                <input type="text" name="APP_URL" value="{{env('APP_URL')}}" class="form-control @error('APP_URL') is-invalid @enderror">
                                @error('APP_URL')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class=" col-form-label">APP_DEBUG</label>
                            <div class="">
                                <select name="APP_DEBUG" id="APP_DEBUG" class="form-control @error('APP_DEBUG') is-invalid @enderror">
                                    <option value="" selected disabled>Select App Debug</option>
                                    <option value="true" {{ env('APP_DEBUG') == '1' ? 'selected' : '' }}>True</option>
                                    <option value="false" {{ env('APP_DEBUG') == '0' ? 'selected' : '' }}>False</option>
                                </select>
                                @error('APP_DEBUG')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputEmail3" class=" col-form-label"></label>
                            <div class="">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('setting.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{$settingManage->id ?? ''}}" name="setting_id">
                        <div class="row mb-3">
                            <label for="inputEmail3" class=" col-form-label">Maintainace Mode</label>
                            <div class="">
                                {{--<input type="checkbox" id="switch1" name="status" @if($notice->status == 1) checked @endif data-switch="bool"/>--}}
                                <input type="checkbox" id="switch1" value="1" @if($settingManage->maintaince_mode == 1) checked @endif class="form-control" name="maintaince_mode" data-switch="bool"/>
                                <label for="switch1" data-on-label="On" data-off-label="Off"></label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class=" col-form-label">Maintainace Message</label>
                            <div class="">
                                <textarea name="maintainace_message" class="form-control @error('maintainace_message') is-invalid @enderror">{{$settingManage->maintainace_message ?? ''}}</textarea>
                                @error('maintainace_message')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputEmail3" class=" col-form-label"></label>
                            <div class="">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

    <script>
        function selectRadio(radioId) {
            $('#' + radioId).prop('checked', true);
        }
    </script>
    <script>
        function previewImage(event) {
            var input = event.target;
            var reader = new FileReader();

            reader.onload = function(){
                var imagePreview = document.getElementById('imagePreview');
                imagePreview.src = reader.result;
                imagePreview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        }

        var imageInput = document.getElementById('imageInput');
        imageInput.addEventListener('change', previewImage);
    </script>
    <script>
        function previewDarkImage(event) {
            var input = event.target;
            var reader = new FileReader();

            reader.onload = function(){
                var imagePreview = document.getElementById('imagePreviewDark');
                imagePreview.src = reader.result;
                imagePreview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        }

        var imageInput = document.getElementById('imageInputDark');
        imageInput.addEventListener('change', previewDarkImage);
    </script>
    <script>
        function previewIconImage(event) {
            var input = event.target;
            var reader = new FileReader();

            reader.onload = function(){
                var imagePreview = document.getElementById('imageIconPreview');
                imagePreview.src = reader.result;
                imagePreview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        }

        var imageInput = document.getElementById('imageIconInput');
        imageInput.addEventListener('change', previewIconImage);
    </script>

@endsection




