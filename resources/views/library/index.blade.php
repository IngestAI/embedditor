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
                        <label for="name">Library Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="{{ $library->name ?? 'Library #01' }}" required="required" value="{{ $library->name ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="temperature">Creativity</label>
                        <input type="range" class="form-range" min="0.05" max="1" step="0.05" id="temperature" name="temperature" value="{{ $library->temperature ?? '0.01' }}">
                    </div>
                    <div class="form-group">
                        <label for="chunk-size">Detalization</label>
                        <input type="range" class="form-range" min="1000" max="2000" step="100" id="chunk-size" name="chunk_size" value="{{ $library->chunk_size ?? '1000' }}" @if (!empty($library->chunk_size))disabled="disabled"@endif>
                        @if (!empty($library->chunk_size))
                            <input type="hidden" name="chunk_size" value="{{ $library->chunk_size }}">
                            <p class="text-muted">This parameter can not be changed once saved.</p>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
            <div class="card-footer align-items-center d-flex justify-content-between"></div>
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
                <form id="file-form" action="{{ route('web::file::upload') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="">
                    @csrf
                    <input type="hidden" name="library_id" value="{{ $library->id ?? '' }}">
                    <div class="form-group">
                        <label for="file" class="form-label">Choose file</label>
                        <input class="form-control" type="file" id="file" name="file">
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
            <div class="card-footer align-items-center d-flex justify-content-between"></div>
        </div>
    </div>

    @if (!empty($library->files))
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
                            <td class="text-center"><a href="{{ route('web::file::download', ['id' => $file->file_key]) }}"><span class="material-symbols-rounded"><span>download_for_offline</span></span></a></td>
                            <td class="text-center"><span class="material-symbols-rounded text-success"><span>check_circle</span></span></td>
                            <td class="text-center"><span class="material-symbols-rounded text-success"><span>check_circle</span></span></td>
                            <td class="text-center"><span class="material-symbols-rounded text-success"><span>check_circle</span></span></td>

                            <td>
                                <div class="d-flex justify-content-end align-items-center">
                                    <a href="javascript:void(0);" class="file-show-raw" data-id="" data-tippy-content="Show Raw Content" data-bs-toggle="modal" data-bs-target="#examplescrolling"><span class="material-symbols-rounded align-middle fs-5 text-body">manage_search</span></a>
                                    <span class="border-start mx-2 d-block height-20"></span>
                                    <a href="javascript:void(0);" class="file-delete" data-id="" data-tippy-content="Delete File"><span class="material-symbols-rounded align-middle fs-5 text-body">delete</span></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer align-items-center d-flex justify-content-between"></div>
        </div>
    </div>
    @endif

{{--        <div class="col-12 mb-3 mb-lg-5">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header d-flex align-items-center justify-content-between">--}}
{{--                    <h5 class="mb-0">Files</h5>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="table-responsive table-card table-nowrap">--}}
{{--                        <table class="table align-middle table-hover mb-0">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th>File</th>--}}
{{--                                <th class="text-center">Download</th>--}}
{{--                                <th class="text-center">Uploaded</th>--}}
{{--                                <th class="text-center">Readed</th>--}}
{{--                                <th class="text-center">Analyzed</th>--}}

{{--                                <th class="text-end">Options</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            <tr>--}}
{{--                                <td style="white-space: normal;"></td>--}}
{{--                                <td class="text-center"><a href="{{ route('web::file::download', ['id' => 1]) }}"><span class="material-symbols-rounded"><span>download_for_offline</span></span></a></td>--}}
{{--                                <td class="text-center"><span class="material-symbols-rounded text-success"><span>check_circle</span></span></td>--}}
{{--                                <td class="text-center"><span class="material-symbols-rounded text-success"><span>check_circle</span></span></td>--}}
{{--                                <td class="text-center"><span class="material-symbols-rounded text-success"><span>check_circle</span></span></td>--}}

{{--                                <td>--}}
{{--                                    <div class="d-flex justify-content-end align-items-center">--}}
{{--                                        <a href="javascript:void(0);" class="file-show-raw" data-id="" data-tippy-content="Show Raw Content" data-bs-toggle="modal" data-bs-target="#examplescrolling"><span class="material-symbols-rounded align-middle fs-5 text-body">manage_search</span></a>--}}
{{--                                        <span class="border-start mx-2 d-block height-20"></span>--}}
{{--                                        <a href="javascript:void(0);" class="file-delete" data-id="" data-tippy-content="Delete File"><span class="material-symbols-rounded align-middle fs-5 text-body">delete</span></a>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="card-footer align-items-center d-flex justify-content-between"></div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
