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

<form id="chunks-form" method="POST" class="needs-validation" action="{{ route('web::file::chunks::update', ['library_file' => $libraryFile->id])  }}" novalidate>
    @csrf
    @method('put')

    <a class="btn btn-primary mb-4" href="{{ route('web::library::index') }}" title="Back button">Back</a>

    <div class="mb-3">
        <div class="card-body">
            <div class="form-group row form-check">
                <input type="checkbox" class="form-check-input" id="strip_tag" name="strip_tag" value="1"@if ($libraryFile->strip_tags) checked="checked"@endif>
                <label class="form-check-label" for="strip_tag">Strip tags</label>
            </div>
            <div class="form-group row form-check">
                <input type="checkbox" class="form-check-input" id="strip_punctuation" name="strip_punctuation" value="1"@if ($libraryFile->strip_punctuation) checked="checked"@endif>
                <label class="form-check-label" for="strip_punctuation">Strip punctuation</label>
            </div>
            <div class="form-group row form-check">
                <input type="checkbox" class="form-check-input" id="strip_special_char" name="strip_special_char" value="1"@if ($libraryFile->strip_special_chars) checked="checked"@endif>
                <label class="form-check-label" for="strip_special_char">Strip special_chars</label>
            </div>
            <div class="form-group row form-check">
                <input type="checkbox" class="form-check-input" id="lowercase" name="lowercase"@if ($libraryFile->lowercase) checked="checked"@endif>
                <label class="form-check-label" for="lowercase">Apply lowercase</label>
            </div>
            <div class="form-group row form-check">
                <input type="checkbox" class="form-check-input" id="stop_word" name="stop_word" value="1"@if ($libraryFile->stop_word) checked="checked"@endif>
                <label class="form-check-label" for="lowercase">Use stop words</label>
            </div>
        </div>
    </div>

    <div class="mb-3 mb-lg-5">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Edit file by chunks</h5>
            </div>
            <div class="card-body">
                <div id="quill-area">
                    @foreach($chunks['html'] as $key => $chunk)
                        <div class="d-flex js_chunk-item">
                            <div class="d-flex flex-column w-100">
                                <div class="d-flex flex-column position-relative js_text-holder" id="textHolder{{$key}}">
                                    <span class="d-flex ml-auto text-primary position-absolute" style="top: 8px; right: 8px;">
                                        <button type="button" class="btn btn-link px-1 py-0 js_decrease-button" onclick="decreaseFontSize(this, 'textHolder{{$key}}')" style="text-decoration: none;">a -</button>
                                        /
                                        <button type="button" class="btn btn-link px-1 py-0 js_increase-button" onclick="increaseFontSize(this, 'textHolder{{$key}}')" style="text-decoration: none;">A +</button>
                                    </span>
                                    <!--Quill editor-->
                                    <div data-quill='{"placeholder": "Quill WYSIWYG"}'>
                                        <p>
                                            {!! $chunk !!}
                                        </p>
                                    </div>
                                    <textarea name="chunks[{{$key}}]" style="display:none"></textarea>
                                </div>
                                <div class="mb-3 js_action-buttons">
                                    <div class="w-100 text-center">
                                        @if(empty($libraryFile->chunked_list) || (!empty($libraryFile->chunked_list) && isset($libraryFile->chunked_list[$key])))
                                            <button class="btn btn-link js_show-more" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                                                Show more
                                            </button>
                                        @else
                                        @endif

                                        @if($key < count($chunks['html']) - 1)
                                            <button type="button" class="btn btn-link js_join-chunks" data-chunk-key="{{$key}}">Join chunks</button>
                                        @endif
                                    </div>
                                    <div class="collapse" id="collapse{{$key}}">
                                        <div class="card card-body rounded-0">

                                            <div class="js_chunk-item-text">
                                                @if(empty($libraryFile->chunked_list) || (!empty($libraryFile->chunked_list) && isset($libraryFile->chunked_list[$key])))
                                                    {!! $chunks['texts'][$key] !!}
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-start pt-3 pl-3">
                                <input class="js_checkbox" name="chunked_list[{{$key}}]" type="checkbox" value="{{$key}}"
                                   @if(!empty($libraryFile->chunked_list))
                                       @if( isset($libraryFile->chunked_list[$key])) checked @endif
                                   @else
                                       checked
                                   @endif
                                >
                            </div>
                        </div>
                    @endforeach
                </div>
                <input class="btn btn-success" type="submit" value="Save" />
            </div>
        </div>
    </div>
</form>

@endsection

@section('js')

    <!-- Include the Quill library -->
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
    var initQuill = document.querySelectorAll("[data-quill]");
    initQuill.forEach((qe) => {
        const qt = {
            ...(qe.dataset.quill ? JSON.parse(qe.dataset.quill) : {}),
            modules: {
                toolbar: [
                    [{ 'background': ["transparent", "#e60000", "#008a00"] }]
                ]
            },
            theme: "snow"
        };
        new Quill(qe, qt);
    });

    $("#chunks-form").on("submit",function(event) {
        $chunks = $('#quill-area .ql-editor');
        $.each($chunks, function (index, value) {
            $(value).parent().parent().find('textarea').html($(value).html());
        });
    })

    const minFontValue = 10;
    const maxFontValue = 24;
    const fontValueChange = 1;

    function decreaseFontSize(target, parentEl) {
        const targetTextarea = document.getElementById(parentEl).getElementsByClassName('ql-container')
        let newTextareaFontValue = parseInt(getComputedStyle(targetTextarea[0]).fontSize) - fontValueChange

        document.getElementById(parentEl).getElementsByClassName('js_increase-button')[0].removeAttribute('disabled')
        targetTextarea[0].style.fontSize = newTextareaFontValue + 'px';

        if (newTextareaFontValue <= minFontValue) {
            target.setAttribute('disabled', 'disabled');
        }
    }

    function increaseFontSize(target, parentEl) {
        const targetTextarea = document.getElementById(parentEl).getElementsByClassName('ql-container')
        let newTextareaFontValue = parseInt(getComputedStyle(targetTextarea[0]).fontSize) + fontValueChange

        document.getElementById(parentEl).getElementsByClassName('js_decrease-button')[0].removeAttribute('disabled')
        targetTextarea[0].style.fontSize = newTextareaFontValue + 'px';

        if (newTextareaFontValue >= maxFontValue) {
            target.setAttribute('disabled', 'disabled');
        }
    }
</script>

<script>
    $(".js_join-chunks").on("click",function(event) {

        Swal.fire({
            title: "Join chunks",
            text: "Do you really want to join chunks?",
            showDenyButton: true,
            // showCancelButton: true,
            confirmButtonText: 'Join',
            denyButtonText: `Cancel`,

        }).then(function(result) {

            if (!result.isConfirmed) return;

            // chunk
            var clickedChunkIdToJoin = $(event.currentTarget).data('chunk-key')
            $chunk = $(event.currentTarget).parents('.js_chunk-item');

            // chunk data
            $chunkEditor = $chunk.find('.ql-editor');
            $chunkData = $chunkEditor.html();
            $chunkEditorShowMore = $chunk.find('.js_chunk-item-text');
            $chunkText = $chunkEditorShowMore.text();

            // next chunk
            $nextChunk = $chunk.next();

            // next chunk data
            $nextChunkData = $nextChunk.find('.ql-editor').html();
            $nextChunkText = $nextChunk.find('.js_chunk-item-text').text();

            if ($nextChunkData == undefined) {
                return;
            }

            // merge data
            mergedData = $chunkData + '<br>' + $nextChunkData;
            mergedText = $chunkText + ' ' + $nextChunkText;

            // insert data
            $chunkEditor.html(mergedData);
            $chunkEditorShowMore.text(mergedText);

            // delete next chunk
            $nextChunk.remove();

            $('.js_chunk-item').last().find('.js_join-chunks').hide();
        })
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
