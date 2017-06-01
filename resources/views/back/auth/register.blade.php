<link href="{{ asset('assets/bootstrap-3.3.7/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet">

<link href="{{ asset('css/back/animate.css') }}" rel="stylesheet">
<link href="{{ asset('css/back/style.css') }}" rel="stylesheet">

    <div class="col-md-4 col-md-offset-4">
        {!! Form::open(['url'=>'/back/register']) !!}

            {!! Form::label('name','name:') !!}
            {!! Form::text('name',null,['class'=>'form-control']) !!}

            {!! Form::label('email','email:') !!}
            {!! Form::email('email',null,['class'=>'form-control']) !!}

            {!! Form::label('password','password:') !!}
            {!! Form::password('password',['class'=>'form-control']) !!}

            <!-- Password Field-->
            <div class="form-group">
                {!! Form::label('password_confirmation','Password_confirmation:') !!}
                {!! Form::password('password_confirmation',['class'=>'form-control']) !!}
            </div>

            {!! Form::submit('注册',['class'=>'btn btn-success form-control']) !!}
        {!! Form::close() !!}
        <p>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul style="color:red;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            </p>
    </div>

