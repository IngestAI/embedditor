@extends('layouts.app')


@section('content')

    <div class="mb-3 mb-lg-5">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                Edit Options
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="library-form" action="{{ route('web::library::save') }}" method="POST" class="needs-validation" novalidate="">
                    @csrf
                    <div class="form-group">
                        <label for="temperature">Creativity</label>
                        <input type="range" class="form-range" min="0.05" max="1" step="0.05" id="temperature" name="temperature" value="{{ $library->temperature ?? '0.5' }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>

    <div class="mb-3 mb-lg-5">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                Upload file
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="file-form" class="dropzone" action="{{ route('web::file::upload') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="">
                    @csrf
                    <input type="hidden" name="library_id" value="{{ $library->id ?? '' }}">
                </form>
            </div>
        </div>
    </div>

    @if (!empty($library->files) && count($library->files))
    <div class="mb-3 mb-lg-5">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                Files
            </div>
            <div class="card-body">
                <div class="table-responsive table-card table-nowrap">
                    <table class="table align-middle table-hover mb-0">
                        <thead>
                        <tr>
                            <th>File</th>
                            <th class="text-center">Download</th>
                            <th class="text-center">Uploaded</th>
                            <th class="text-center">Readed</th>
                            <th class="text-center">Analyzed</th>

                            <th class="text-end">Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($library->files as $file)
                        <tr>
                            <td style="white-space: normal;">{{ $file->original_name }}</td>
                            <td class="text-center"><a href="{{ route('web::file::download', ['key' => $file->file_key]) }}"><i class="bi bi-arrow-down-circle h5 text-primary"></i></a></td>
                            <td class="text-center">
                                @if ($file->uploaded)
                                    <i class="bi bi-check-circle h5 text-success"></i>
                                @else
                                    <i class="bi bi-exclamation-circle h5 text-danger"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($file->formatted)
                                    <i class="bi bi-check-circle h5 text-success"></i>
                                @else
                                    <i class="bi bi-exclamation-circle h5 text-danger"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($file->embedded)
                                    <i class="bi bi-check-circle h5 text-success"></i>
                                @else
                                    <i class="bi bi-exclamation-circle h5 text-danger"></i>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0);" class="file-show-raw" data-id="" data-tippy-content="Show Raw Content" data-bs-toggle="modal" data-bs-target="#examplescrolling"><i class="bi bi-pencil h5 text-dark"></i></a>
                                    <span class="border-start mx-2 d-block height-20"></span>
                                    <a href="" class="file-delete" data-id="" data-tippy-content="Delete File"><i class="bi bi-search h5 text-dark"></i></a>
                                    <span class="border-start mx-2 d-block height-20"></span>
                                    <a href="{{ route('web::file::delete', ['library_file' => $file->id]) }}" class="file-delete" data-id="" data-tippy-content="Delete File">
                                        <i class="bi bi-trash h5 text-dark"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

@section('js')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;

        Dropzone.options.uiDZResume = {
            success: function(file, response){
                alert(response);
            }
        };

        $(document).ready(function () {
            $("#file-form").dropzone({
                url: '{{ route('web::file::upload') }}',
                maxFiles: 1,
                acceptedFiles: '.txt,.csv,.pdf',
                maxFilesize: 3,
                init: function () {
                    this.on("success", function (file, response) {
                        setTimeout(() => location.reload(), 1000);
                    });
                }
            });
        });
    </script>
@endsection
