@extends('layouts.app')


@section('content')

    <div class="container-fluid mb-3 mb-lg-5">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a class="btn btn-primary btn-lg" href="{{ route('web::library::index') }}" role="button">Vector Storage</a>
            </div>
        </div>
    </div>

    <div class="mb-3 mb-lg-5">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                Playground
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
                <form id="playground-form" method="POST" class="needs-validation" novalidate="">
                    <div class="form-group">
                        <label for="model">Model</label>
                        <select class="form-control" id="model">
                            @foreach ($providerModels as $id => $title)
                                <option value="{{ $id }}" selected="selected">{!! $title !!}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="query">Your Query</label>
                        <textarea class="form-control" id="query" rows="3" placeholder="Your query or any phrase"></textarea>
                    </div>
                    <button id="run" type="submit" class="btn btn-primary">Run</button>

                    <div id="request-loader" class="text-center mb-4 mt-4">
                        <svg class="anim-spinner text-success me-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M24 12C24 14.3734 23.2962 16.6935 21.9776 18.6668C20.6591 20.6402 18.7849 22.1783 16.5922 23.0866C14.3995 23.9948 11.9867 24.2324 9.65892 23.7694C7.33114 23.3064 5.19295 22.1635 3.51472 20.4853C1.83649 18.8071 0.693599 16.6689 0.230577 14.3411C-0.232446 12.0133 0.00519403 9.60051 0.913446 7.4078C1.8217 5.21509 3.35977 3.34094 5.33316 2.02236C7.30655 0.703788 9.62662 -2.83022e-08 12 0L12 3C10.22 3 8.47991 3.52784 6.99987 4.51677C5.51983 5.50571 4.36627 6.91131 3.68508 8.55585C3.0039 10.2004 2.82567 12.01 3.17293 13.7558C3.5202 15.5016 4.37737 17.1053 5.63604 18.364C6.89471 19.6226 8.49836 20.4798 10.2442 20.8271C11.99 21.1743 13.7996 20.9961 15.4442 20.3149C17.0887 19.6337 18.4943 18.4802 19.4832 17.0001C20.4722 15.5201 21 13.78 21 12H24Z" fill="currentColor"></path></svg>
                        <span>Loading...</span>
                    </div>
                    <div id="request-content" class="pt-0">
                        <hr>
                        <div id="request-answer" class="pt-0"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#request-loader').hide();
            $('#request-content').hide();
            $('#playground-form, #run').on('submit', function(e) {
                e.preventDefault();
                if ($('#query').val() == '') {
                    alert('Please enter your request');
                    return false;
                } else {
                    $('#request-loader').show();
                    $('#request-content').hide();
                    $.post('{{ route('web::playground::send') }}', {
                        q: $('#query').val(),
                        model_id: $('#model').val(),
                        _token: '{{ csrf_token() }}'
                    }, function(j) {
                        if (j.result === 1) {
                            $('#request-loader').hide();
                            $('#request-content').show();
                            if (j.image) {
                                $('#request-answer').html('<img src="data:image/png;base64,' + j.image + '" class="img-fluid" />');
                            } else {
                                $('#request-answer').html(j.answer);
                            }
                        } else if (j.result == 2) {
                            alert('Error: ' + j.error);
                        } else {
                            alert('An error occured while sending or receiving the request!');
                        }
                    });
                }
            });
        });
    </script>
@endsection
