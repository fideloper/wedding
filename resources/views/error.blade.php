@extends('layout')

@section('content')
    <div class="container main-body">
        <div class="row" id="message-header">
            <div class="col-md-12">
                <div class="text-center">
                    <h1 class="title fancy">Whoops!</h1>
                    <p>{{ $error }}</p>
                </div>
            </div>
        </div>
    </div><!-- /.container -->
@endsection