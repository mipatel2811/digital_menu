@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">                    
                    {!! Form::model($user, $formAttributes) !!}
                        <div class="form-group">
                            {!! Form::label('name', 'Name') !!}
                            <div class="input-group">
                                {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => "Enter your name"]) !!}
                            </div>
                            @error('name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {!! Form::label('email', 'Email') !!}
                            <div class="input-group">
                                {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Enter your Email', 'disabled' => $user != null]) !!}
                            </div>
                            @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        @if (auth()?->user()->id == $user?->id || $user == NULL)
                            <div class="form-group">
                                {!! Form::label('password', 'Password') !!}
                                <div class="input-group">                                
                                    {!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'placeholder' => 'Enter your Password']) !!}
                                </div>
                                @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                {!! Form::label('password-confirm', 'Confirm Password') !!}
                                <div class="input-group">
                                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password-confirm', 'placeholder' => 'Confirm Password ']) !!}
                                </div>
                                @error('password_confirmation')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>                        
                        @endif

                        <div class="form-group">
                            {!! Form::label('image', 'Profile Image') !!}
                            <div class="input-group">
                                {!! Form::file('image', ['class' => 'form-control', 'id' => 'image']) !!}
                            </div>
                            @error('image')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            {!! Form::label('phone', 'Phone') !!}
                            <div class="input-group">
                                {!! Form::text('phone', null, ['class' => 'form-control', "placeholder" => "Enter Your Phone Number", 'id' => 'phone']) !!}
                            </div>
                            @error('phone')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            {!! Form::label('role_id', 'Select Role') !!}
                            <div class="input-group">
                                {!! Form::select('role_id', $roles, $user?->role_id, ['class' => 'form-control', 'placeholder' => 'Select User Role']) !!}
                            </div>
                            @error('role_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            {!! Form::label('approved', 'Approved') !!}
                            <div class="input-group">
                                {!! Form::select('approved', ['No', 'Yes'], $user?->approved, ['class' => 'form-control', 'placeholder' => 'Select User Status']) !!}
                            </div>
                            @error('approved')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                       
                        <div class="form-group">
                            @if ($user)
                                {!! Form::submit('Update', ['class' => "btn btn-success"]) !!}
                            @else 
                                {!! Form::submit('Create', ['class' => "btn btn-success"]) !!}
                            @endif
                        </div>
                        
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection