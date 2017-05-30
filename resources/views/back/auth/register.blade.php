

    <div class="col-md-4 col-md-offset-4">
        {!! Form::open(['url'=>'/auth/register']) !!}

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
    </div>

