@extends('extman.layout')
@section('content')

<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="widget yellow-bg p-lg text-center">
            <div class="m-b-md">
                <i class="fas fa-exclamation-triangle fa-4x"></i>
                <h1 class="m-xs">{{ $msg }}</h1>
                <h3 class="font-bold no-margins">{{ $content }}</h3>
                <h3>
                    <a href="{{ url()->previous() }}" class="pull-right text-navy">
                        <i class="fas fa-arrow-alt-circle-left fa-2x"></i> 
                    </a>
                </h3>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT WRAPPER -->
@endsection



