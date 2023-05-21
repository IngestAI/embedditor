@extends('layouts.app')

@section('css')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Core Css Quill editor -->
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <style>
        .ql-editor {
            max-height: 50vh;
            overflow: auto;
        }
    </style>

@endsection

@section('content')

<a class="btn btn-primary" href="{{ route('web::library::index') }}" title="Back button">Back</a>

<div class="content pt-3 px-3 px-lg-6 d-flex flex-column-fluid">
    <div class="container-fluid px-0">
        <div class="row">
            <div class="col-12 mb-3 mb-lg-5">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Edit file by chunks</h5>
                    </div>

                    <div class="card-body">
                        <form id="chunks-form" method="POST" class="needs-validation" action="{{ route('web::file::chunks::update', ['library_file' => $libraryFile->id])  }}" novalidate>
                            @csrf
                            @method('put')

                            <div id="quill-area">

                                @foreach($chunks as $key => $chunk)

                                    <div class="row">

                                        <div class="col-11">

                                            <!--//Page content//-->
                                            <div class="content pt-3 px-3 px-lg-6 mb-4">
                                                <div class="container-fluid px-0" >
                                                    <!--Quill editor-->
                                                    <div data-quill='{"placeholder": "Quill WYSIWYG"}'>
                                                        <p>
                                                            {!! $chunk !!}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--//Page content End//-->

                                            <textarea name="chunks[{{$key}}]" style="display:none" id="hidden-chunk-{{$key}}"></textarea>
                                        </div>
                                        <div class="col-1">
                                            <br>
                                            <div class="form-check">
                                                <input name="chunked_list[{{$key}}]" class="form-check-input" type="checkbox" value="{{$key}}"
                                                    @if(!empty($libraryFile->chunked_list))
                                                        @if( isset($libraryFile->chunked_list[$key])) checked @endif
                                                    @else
                                                        checked
                                                    @endif
                                                       id="checkChunk-{{$key}}">
                                            </div>
                                        </div>
                                    </div>

                                @endforeach

                            </div>

                            <input class="btn btn-success" type="submit" value="Save" />

                        </form>

                    </div>

                    <div class="card-footer align-items-center d-flex justify-content-between"></div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('js')

    <!-- Include the Quill library -->
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
{{--    <script src="{{ asset('js/bootstrap.min.js') }}"></script>--}}

<script>
    var initQuill = document.querySelectorAll("[data-quill]");
    initQuill.forEach((qe) => {
        const qt = {
            ...(qe.dataset.quill ? JSON.parse(qe.dataset.quill) : {}),
            modules: {
                toolbar: [
                    [{ 'background': ['#E7E6E6', "#e60000", "#008a00"] }]
                ]
            },
            theme: "snow"
        };
        new Quill(qe, qt);
    });

    $("#chunks-form").on("submit",function(event) {
        $chunks = $('#quill-area .ql-editor');
        $.each($chunks, function (index, value) {
            $("#hidden-chunk-" + index).html($(value).html());
        });
    })
</script>

<script>
    @if (session('status') == 'file-updated-successfully')
    Swal.fire({
        title: 'Success!',
        text: 'Library file was successfully saved! {!! (!empty(session('message')) ? session('message') : '') !!}',
        icon: 'success',
        confirmButtonText: 'OK',
        timer: 2000
    });
    @elseif (session('status') == 'file-updated-error')
    Swal.fire({
        title: 'Error!',
        text: 'The library file was unable to be saved due to an error. {{ session('error') }}',
        icon: 'error',
        confirmButtonText: 'OK'
    });
    @endif
</script>

@endsection
