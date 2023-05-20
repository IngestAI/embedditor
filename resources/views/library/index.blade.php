@extends('layouts.app')


@section('content')

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            Edit Options
        </div>
        <div class="card-body">
            <form id="libraryForm" action="{{ route('web::library::save') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="">
                <div class="form-group">
                    <label for="name">Library Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Library #01" required="required">
                </div>
                <div class="form-group">
                    <label for="temperature">Creativity</label>
                    <input type="range" class="form-range" min="0.05" max="1" step="0.05" id="temperature" name="temperature" value="">
                </div>
                <div class="form-group">
                    <label for="chunk-size">Detalization</label>
                    <input type="range" class="form-range" min="1000" max="2000" step="100" id="chunk-size" name="chunk_size" value="1500">
                    {{--                                <p class="text-muted">This parameter can not be changed once saved.</p>--}}
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>


{{--    <div class="row">--}}
{{--        <div class="col-12 mb-3 mb-lg-5">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header d-flex align-items-center justify-content-between">--}}
{{--                    <h5 class="mb-0">Edit options</h5>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <form id="libraryForm" action="{{ route('web::library::save') }}" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate="">--}}
{{--                        @csrf--}}
{{--                        <div class="row g-3">--}}
{{--                            <div class="col-md-12">--}}
{{--                                <label for="name" class="form-label">Library Name</label>--}}
{{--                                <input type="text" class="form-control" id="name" name="name" placeholder="Library #01" required="required" value="">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row g-3">--}}
{{--                            <div class="col-md-6">--}}
{{--                                <h6>Creativity</h6>--}}
{{--                                <input type="range" class="form-range" min="0.05" max="1" step="0.05" id="temperature" name="temperature" value="">--}}
{{--                            </div>--}}
{{--                            <div class="col-md-6">--}}
{{--                                <h6>Library Detalization</h6>--}}
{{--                                <input type="range" class="form-range" min="1000" max="2000" step="100" id="chunk_size" name="chunk_size" value="1500">--}}
{{--                                <p class="text-muted">This parameter can not be changed once saved.</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-12"><button class="btn btn-primary" type="submit">Save</button></div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--                <div class="card-footer align-items-center d-flex justify-content-between"></div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-12 mb-3 mb-lg-5">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header d-flex align-items-center justify-content-between">--}}
{{--                    <h5 class="mb-0">Upload</h5>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div id="libFileBlock">--}}
{{--                        <div class="row g-3">--}}
{{--                            <div class="col-md-12">--}}
{{--                                <form method="post" action="{{ route('web::file::upload') }}" enctype="multipart/form-data" class="dropzone dz-clickable" id="dropzone">--}}
{{--                                    <input type="hidden" name="_token" value="smfR7G0nI47RnhwFTCibYAS03de24EhCNzKAWPRU">                                                <input type="file" name="file" style="display: none;">--}}
{{--                                    <div class="dz-default dz-message"><button class="dz-button" type="button">Drop files here to upload</button></div>--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="card-footer align-items-center d-flex justify-content-between"></div>--}}
{{--            </div>--}}
{{--        </div>--}}
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
