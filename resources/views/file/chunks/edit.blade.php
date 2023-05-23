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

    <a class="btn btn-secondary mb-4" href="{{ route('web::library::index') }}" title="Back button">Back</a>

    <div class="mb-3">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Options</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="optimize" name="optimize" value="1"@if ($libraryFile->isOptimize()) checked="checked"@endif>
                            <label class="form-check-label" for="optimize">Optimize content</label>
                        </div>
                        <p>{{ $libraryFile->total_embedded_words }} out of {{ $libraryFile->total_words }} words choosen for embedding. Storage optimized: ≈ {{ $libraryFile->getTotalPercentage() }}%</p>
                        <input class="btn btn-success" type="submit" value="Apply" />
                    </div>
                </div>
                <div id="advOptions" class="row" style="display: none;">
                    <div class="col-12 col-md-4">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="strip_tag" name="strip_tag" value="1"@if ($libraryFile->strip_tag) checked="checked"@endif>
                            <label class="form-check-label" for="strip_tag">Remove HTML Tags</label>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="strip_punctuation" name="strip_punctuation" value="1"@if ($libraryFile->strip_punctuation) checked="checked"@endif>
                            <label class="form-check-label" for="strip_punctuation">Remove punctuations</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="strip_special_char" name="strip_special_char" value="1"@if ($libraryFile->strip_special_char) checked="checked"@endif>
                            <label class="form-check-label" for="strip_special_char">Remove special chars</label>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="lowercase" name="lowercase"@if ($libraryFile->lowercase) checked="checked"@endif>
                            <label class="form-check-label" for="lowercase">Apply lowercase</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="stop_word" name="stop_word" value="1"@if ($libraryFile->stop_word) checked="checked"@endif>
                            <label class="form-check-label" for="stop_word">Remove stop words</label>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" disabled="disabled">
                            <label class="form-check-label text-secondary">TF-IDF <span class="badge bg-success text-white">Soon</span></label>
                        </div>
                    </div>
                </div>
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
                                            <button class="btn btn-link js_show-more" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">↓ See Embedding Tokens</button>
                                        @else
                                        @endif
                                        @if($key < count($chunks['html']) - 1)
                                            <button type="button" class="btn btn-link js_join-chunks" data-chunk-key="{{$key}}">↕ Join Chunks</button>
                                        @endif
                                    </div>
                                    <div class="collapse" id="collapse{{$key}}">
                                        <div class="card card-body rounded-0">
                                            <div class="js_chunk-item-text">
                                                @if(empty($libraryFile->chunked_list) || (!empty($libraryFile->chunked_list) && isset($libraryFile->chunked_list[$key])))
                                                    <p class="text-secondary">These words will be sent for embedding:</p>
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
    $('#advOptions').hide();
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
