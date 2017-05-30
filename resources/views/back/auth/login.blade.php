

    <div class="col-md-4 col-md-offset-4">
        {!! Form::open(['url'=>'/auth/login']) !!}
            {!! Form::label('email','email:') !!}
            {!! Form::text('name',null,['class'=>'form-control']) !!}

            {!! Form::label('password','密码:') !!}
            {!! Form::password('password',['class'=>'form-control']) !!}
        <input type="checkbox" name="remember"> Remember Me
            {!! Form::submit('登陆',['class'=>'btn btn-success form-control']) !!}
        {!! Form::close() !!}
    </div>

