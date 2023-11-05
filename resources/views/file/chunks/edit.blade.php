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

@section('button')
    <a class="btn btn-secondary" href="{{ route('web::library::index') }}" title="Back button">Back</a>
@endsection

@section('content')

<form id="chunks-form" enctype="multipart/form-data" method="POST" class="needs-validation" action="{{ route('web::file::chunks::update', ['library_file' => $libraryFile->id])  }}" novalidate>
    @csrf
    @method('put')
    <div class="mb-3">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Options</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="optimize" name="optimize" onclick="selectAllOptions(this)" value="1"@if ($libraryFile->isOptimize()) checked="checked"@endif>
                            <label class="form-check-label" for="optimize">Optimize content</label>
                        </div>
                        <p>{{ $libraryFile->total_embedded_words }} out of {{ $libraryFile->total_words }} words choosen for embedding. Storage optimized: ≈ {{ $libraryFile->getTotalPercentage() }}%</p>
                        <input class="btn btn-success" type="submit" value="Apply" />
                    </div>
                    <div class="col-12 col-md-6">
                        <span class="d-flex w-100 justify-content-end text-primary">
                            <button id="js_decrease-button" type="button" class="btn btn-link px-1 py-0" onclick="decreaseFontSize(this)" style="text-decoration: none;">a -</button>
                            /
                            <button id="js_increase-button" type="button" class="btn btn-link px-1 py-0" onclick="increaseFontSize(this)" style="text-decoration: none;">A +</button>
                        </span>
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
                                <div class="d-flex flex-column">
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
                                        <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-attachments-{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">↑ Attaches</button>
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
                                    <div class="collapse mb-3" id="collapse-attachments-{{$key}}">
                                        <div class="card card-body rounded-2">
                                            <div class="row js_chunk-item-attachments">
                                                <div class="col-12 col-md-6 mb-3 mb-md-0">
                                                    <label for="links0" class="form-label">Links:</label>
                                                    @if(!empty($chunks['attachments']) && !empty($chunks['attachments'][$key]) && !empty(!empty($chunks['attachments'][$key]['links'])))
                                                        @foreach($chunks['attachments'][$key]['links'] as $keyLink => $link)
                                                            <div class="mt-2 attachment-link-block" data-chunk="{{ $key }}" data-index="{{ $keyLink }}">
                                                                <input name="attachments[{{$key}}][links][{{$keyLink}}]" value="{{$link}}" type="text" class="form-control attachment-link" id="links{{ $key }}{{ $keyLink }}" data-index="{{ $keyLink }}">
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="mt-2 attachment-link-block" data-chunk="{{ $key }}" data-index="0">
                                                            <input name="attachments[{{$key}}][links][0]" value="" type="text" class="form-control attachment-link" id="links{{ $key }}0" data-index="0">
                                                        </div>
                                                    @endif
                                                    <div class="row mb-12 mt-2">
                                                        <div class="col-md-12">
                                                            <button class="btn btn-secondary add-link" type="button" data-index="{{ $key }}">
                                                                Add Link
                                                            </button>
                                                            <button class="btn btn-danger remove-link" type="button" data-index="{{ $key }}" @if (empty($chunks['attachments'][$key]['links']) || count($chunks['attachments'][$key]['links']) <= 1) style="display: none;"@endif>
                                                                Remove Link
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <label for="images0" class="form-label">Images:</label>
                                                    @if(!empty($chunks['attachments']) && !empty($chunks['attachments'][$key]) && !empty($chunks['attachments'][$key]['images']))
                                                        @foreach($chunks['attachments'][$key]['images'] as $imageKey => $imageUrl)
                                                            <div class="row mt-2 attachment-image-block" data-chunk="{{ $key }}" data-index="{{ $keyLink }}">
                                                                <div class="col-12 @if (!empty($image)) mb-2 mb-xl-0 col-xl-9 col-xxl-10 @endif">
                                                                    <input type="file" name="attachments[{{ $key }}][images][{{ $imageKey }}]" accept="image/*" class="form-control attachment-image" id="images{{ $key }}{{ $keyLink }}">
                                                                    <input type="hidden" name="attachments[{{ $key }}][imagesUrls][{{ $imageKey }}]" value="{{ $imageUrl }}">
                                                                </div>

                                                                @if (!empty($imageUrl))
                                                                    <div class="col-12 col-xl-3 col-xxl-2">
                                                                        <div style="max-width: 100px;">
                                                                            <img class="img-fluid" src="{{ $imageUrl }}">
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="mt-2">
                                                            <input type="file" name="attachments[{{$key}}][images][0]" accept="image/*" class="form-control attachment-link" id="images{{ $key }}0" data-index="0">
                                                            <input type="hidden" name="attachments[{{$key}}][imagesUrls][0]"  value="">
                                                        </div>
                                                    @endif

                                                    <div class="row mb-12 mt-2">
                                                        <div class="col-md-12">
                                                            <button class="btn btn-secondary add-image" type="button" data-index="{{ $key }}">
                                                                Add Image
                                                            </button>
                                                            <button class="btn btn-danger remove-image" type="button" data-index="{{ $key }}" @if (empty($chunks['attachments'][$key]['images']) || count($chunks['attachments'][$key]['images']) <= 1) style="display: none;"@endif>
                                                                Remove Image
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--                                    </div>--}}

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

    function decreaseFontSize(target) {
        const targetTextareas = document.querySelectorAll('.ql-container')
        let newTextareasFontValue = parseInt(getComputedStyle(targetTextareas[0]).fontSize) - fontValueChange

        document.getElementById('js_increase-button').removeAttribute('disabled')
        targetTextareas.forEach(function (el) {
            el.style.fontSize = newTextareasFontValue + 'px';
        });

        if (newTextareasFontValue <= minFontValue) {
            target.setAttribute('disabled', 'disabled');
        }
    }

    function increaseFontSize(target) {
        const targetTextareas = document.querySelectorAll('.ql-container')
        let newTextareasFontValue = parseInt(getComputedStyle(targetTextareas[0]).fontSize) + fontValueChange

        document.getElementById('js_decrease-button').removeAttribute('disabled')
        targetTextareas.forEach(function (el) {
            el.style.fontSize = newTextareasFontValue + 'px';
        });

        if (newTextareasFontValue >= maxFontValue) {
            target.setAttribute('disabled', 'disabled');
        }
    }

    function selectAllOptions(targetEl) {
        const targetCheckboxes = document.getElementById('advOptions').querySelectorAll('.form-check-input')

        if (targetEl.checked) {
            targetCheckboxes.forEach(function (el) {
                if (!el.disabled) {
                    el.setAttribute('checked', 'checked');
                }
            });
        } else {
            targetCheckboxes.forEach(function (el) {
                el.removeAttribute('checked');
            });
        }
    }

    $('.add-link').on('click', function() {
        const chunk = $(this).data('index')
        let lastBlock = $(`.attachment-link-block[data-chunk="${chunk}"]`).last()
        const index = lastBlock.data('index') || 0
        const appendBlock = `<div class="mt-2">
            <input name="attachments[${chunk}][links][${index + 1}]" value="" type="text" class="form-control attachment-link" id="links${chunk}${index + 1}" data-index="${index + 1}">
        </div>`
        $(`.remove-link[data-index="${chunk}"]`).show()
        lastBlock.after(appendBlock)
    })

    $('.remove-link').on('click', function() {
        const chunk = $(this).data('index')
        let lastBlock = $(`.attachment-link-block[data-chunk="${chunk}"]`).last()
        const index = lastBlock.data('index') || 0
        if (!index) return
        if (index == 1) $(`.remove-link[data-index="${chunk}"]`).hide()
        lastBlock.remove()
    })

    $('.add-image').on('click', function() {
        const chunk = $(this).data('index')
        let lastBlock = $(`.attachment-image-block[data-chunk="${chunk}"]`).last()
        const index = lastBlock.data('index') || 0
        const appendBlock = `<div class="row mt-2" data-chunk="${chunk}" data-index="${index + 1}">
            <div class="mt-2">
                <input type="file" name="attachments[${chunk}][images][${index + 1}]" accept="image/*" class="form-control" id="images${chunk}${index + 1}">
                <input type="hidden" name="attachments[${chunk}][imagesUrls][${index + 1}]" value="">
            </div>
        </div>`
        $(`.remove-image[data-index="${chunk}"]`).show()
        lastBlock.after(appendBlock)
    })

    $('.remove-image').on('click', function() {
        const chunk = $(this).data('index')
        let lastBlock = $(`.attachment-image-block[data-chunk="${chunk}"]`).last()
        const index = lastBlock.data('index') || 0
        if (!index) return
        if (index == 1) $(`.remove-image[data-index="${chunk}"]`).hide()
        lastBlock.remove()
    })
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
