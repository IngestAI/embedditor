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
                    <div class="form-group">
                        <label for="temperature">Chunk Separator (optional value: e.g. ===)</label>
                        <input type="range" class="form-range" min="0.05" max="1" step="0.05" id="temperature" name="temperature" value="{{ $library->temperature ?? '0.5' }}">
                        <input type="text" class="form-control" id="chunk-separator" name="chunk_separator" placeholder="" value="{!!old('chunk_separator', $library->chunk_separator ?? '')!!}">
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
                            <th class="text-center">Read</th>
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
                                    <a href="{{ route('web::file::chunks::edit', ['library_file' => $file->id]) }}" class="file-chunk" data-id="" data-tippy-content="Chunks"><i class="bi bi-pencil h5 text-dark"></i></a>
                                    <span class="border-start mx-2 d-block height-20"></span>
{{--                                    <a href="javascript:void(0);" class="file-show" data-id="{{ $file->id }}" data-tippy-content="Show Raw Content" data-toggle="modal" data-target="#viewModal"><i class="bi bi-search h5 text-dark"></i></a>--}}
{{--                                    <span class="border-start mx-2 d-block height-20"></span>--}}
                                    <a href="javascript:void(0);" class="file-delete" data-id="{{ $file->id }}" data-tippy-content="Delete File" data-toggle="modal" data-target="#deleteModal">
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

    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title" id="viewLabel">View Content</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="viewContentLoader" class="text-center"><div class="spinner-border text-muted" role="status"><span class="visually-hidden">Loading...</span></div></div>
                    <div id="viewContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title" id="deleteLabel">Delete File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="deleteContent">Are you sure to delete the file?</div>
                </div>
                <div class="modal-footer">
                    <button id="confirm-delete" type="button" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

            // $('.file-show').click(function() {
            //     $('#viewModal').modal('show');
            //     $('#viewContentLoader').show();
            //     $('#viewContent').html('');
            //     $('#viewLabel').html('');
            //     const id = $(this).data('id');
            //     $.getJSON(`/file/view/${id}`, function(j) {
            //         if (j.result === 1) {
            //             $('#viewContentLoader').hide();
            //             $('#viewContent').html(j.content);
            //             $('#viewLabel').html(j.name);
            //         } else {
            //             alert('An error occured while loading the file!');
            //         }
            //     });
            // });

            $('.file-delete').click(function (event) {
                const id = $(this).data('id');
                $('#confirm-delete').unbind('click').click(function() {
                    $.getJSON(`/file/delete/${id}`, function(j) {
                        if (j.result === 1) {
                            $('#deleteModal').modal('hide');
                            location.reload();
                        } else {
                            alert('An error occured while deleting the file!');
                        }
                    });
                });
            })
        });

    </script>
@endsection
