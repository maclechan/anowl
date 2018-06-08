@if (session('msg'))
    <script type="text/javascript">
        $(function () {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "progressBar": true,
                "preventDuplicates": true,
                "positionClass": "toast-bottom-center",
                "onclick": null,
                "showDuration": "400",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "5000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            toastr.{{ session('type') }}("{{ session('msg') }}!","{{ session('type') }} :");
        })
    </script>
@endif

@if ($errors->any())
{{--@if (count($errors) > 0)--}}
    <div class="col-lg-3">
        <div class="alert alert-danger alert-dismissable">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif