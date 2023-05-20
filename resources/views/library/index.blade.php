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
                <div class="row">
                    <div class="col-xl-4 col-md-6 mb-3 mb-lg-4">
                        <div class="card overflow-hidden">
                            <div class="card-body p-3 bg-primary border-primary text-white rounded d-flex align-items-center" style="cursor: pointer;">
                                <div class="flex-shrink-0 position-relative bg-white text-primary rounded-circle mr-3 d-flex align-items-center justify-content-center">
                                    <svg class="bd-placeholder-img rounded-circle" width="60" height="60" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 60x60" preserveAspectRatio="xMidYMid slice" focusable="false">
                                        <rect width="100%" height="100%" fill="#fff"></rect>
                                    </svg>
                                    <i class="position-absolute h2 bi bi-file-earmark-arrow-up"></i>
                                </div>
                                <div class="flex-grow-1 text-start">
                                    <h5 class="h3 d-block fw-bold mb-1">Files</h5>
                                    <h6 class="mb-0 fw-normal">Upload files to Library</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 mb-3 mb-lg-4">
                        <div class="card overflow-hidden">
                            <div class="card-body p-3 rounded d-flex align-items-center" style="cursor: pointer;">
                                <div class="flex-shrink-0 position-relative bg-white text-primary rounded-circle mr-3 d-flex align-items-center justify-content-center">
                                    <svg class="bd-placeholder-img rounded-circle" width="60" height="60" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 60x60" preserveAspectRatio="xMidYMid slice" focusable="false">
                                        <rect width="100%" height="100%" fill="#f6f5fe"></rect>
                                    </svg>
                                    <i class="position-absolute h3 bi bi-search"></i>
                                </div>
                                <div class="flex-grow-1 text-start">
                                    <h5 class="h3 d-block fw-bold mb-1">Links Crawler</h5>
                                    <h6 class="mb-0 fw-normal">Get content from web links</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form id="file-form" class="dropzone" action="{{ route('web::file::upload') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="">
                    @csrf
                    <input type="hidden" name="library_id" value="{{ $library->id ?? '' }}">
{{--                    <div class="form-group">--}}
{{--                        <label for="file" class="form-label">Choose file</label>--}}
{{--                        <input class="form-control" type="file" id="file" name="file">--}}
{{--                    </div>--}}
{{--                    <button type="submit" class="btn btn-primary">Upload</button>--}}
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
                            <td class="text-center"><i class="bi bi-check-circle h5 text-success"></i></td>
                            <td class="text-center"><i class="bi bi-check-circle h5 text-success"></i></td>
                            <td class="text-center"><i class="bi bi-check-circle h5 text-success"></i></td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0);" class="file-show-raw" data-id="" data-tippy-content="Show Raw Content" data-bs-toggle="modal" data-bs-target="#examplescrolling"><i class="bi bi-pencil h5 text-dark"></i></a>
                                    <span class="border-start mx-2 d-block height-20"></span>
                                    <a href="" class="file-delete" data-id="" data-tippy-content="Delete File"><i class="bi bi-search h5 text-dark"></i></a>
                                    <span class="border-start mx-2 d-block height-20"></span>
                                    <a href="{{ route('web::file::delete', ['id' => $file->id]) }}" class="file-delete" data-id="" data-tippy-content="Delete File">
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
        $(document).ready(function () {
            $("#file-form").dropzone({
                url: '{{ route('web::file::upload') }}',
                maxFiles: 1,
                acceptedFiles: '.txt,.csv,.doc,.docx,.abw,.djvu,.docm,.dot,.dotx,.html,.hwp,.lwp,.md,.odt,.pages,.pdf,.rst,.rtf,.tex,.wpd,.wps,.zabw,.azw,.azw3,.azw4,.cbc,.cbr,.cbz,.chm,.epub,.fb2,.htm,.htmlz,.lit,.lrf,.mobi,.pdb,.pml,.prc,.rb,.snb,.tcr,.txtz,.dps,.key,.odp,.pot,.potx,.pps,.ppsx,.ppt,.pptm,.pptx,.et,.numbers,.ods,.xlr,.xls,.xlsm,.xlsx',
                maxFilesize: 3
            });
        });
    </script>
@endsection
