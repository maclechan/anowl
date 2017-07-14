@extends('back.layout')
@section('content')

<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="widget yellow-bg p-lg text-center">
            <div class="m-b-md">
                <i class="fa fa-warning fa-4x"></i>
                <h1 class="m-xs">{{ $msg }}</h1>
                <h3 class="font-bold no-margins">{{ $content }}</h3>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT WRAPPER -->
<script>
    jQuery(document).ready(function() {
        //setTimeout('window.location.href = "{{url($action)}}"',3000);
    });
</script>
@endsection



