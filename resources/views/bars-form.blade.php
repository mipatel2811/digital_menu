@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">                    
                    {!! Form::model($bar, $formAttributes) !!}

                        <div class="form-group">
                            {!! Form::label('name', 'Name') !!}
                            <div class="input-group">
                                {!! Form::text('name', null, ["class" => "form-control", "autofocus" => true, "required" => true, "id" => "name", "placeholder" => "Enter Bar Name"]) !!}
                            </div>
                            @error('name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            {!! Form::label('slug', 'Slug') !!}
                            <div class="input-group">
                                {!! Form::text('slug', null, ["class" => "form-control", "required" => true, "id" => 'slug', "placeholder" => "Enter Bar slug"]) !!}
                            </div>
                            @error('slug')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    {!! Form::label('logo', 'Logo') !!}
                                    <div class="input-group">
                                        {!! Form::file('logo', ["class" => "form-control", "id" => "logo", "accept" => "image/*"]) !!}
                                    </div>
                                    @error('logo')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    {!! Form::label('background_color', "Background Color") !!}
                                    <div class="input-group">
                                        {!! Form::text('background_color', null, ["class" => "form-control", "id" => "background_color", "placeholder" => "Choose the Background Color", "required" => true]) !!}
                                    </div>
                                    @error('background_color')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('description', "Description") !!}
                            <div class="input-group">
                                {!! Form::textarea('description', null, ["class" => "form-control", "id" => "description", "placeholder" => "Enter the Description here..."]) !!}
                            </div>
                            @error('description')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            {!! Form::label('user_id', "Select Owner") !!}
                            <div class="input-group">
                                {!! Form::select('user_id', $users, $bar?->user_id, ['class' => 'form-control select2', "required" => true, "placeholder" => "Select Bar Owner", "id" => "user_id"]) !!}
                            </div>
                            @error('user_id')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            {!! Form::label('images', 'Images') !!}
                            <div class="input-group">
                                {!! Form::file('images[]', ["class" => "form-control", "multiple" => true, "accept" => "image/*", "id" => "images"]) !!}
                            </div>
                            @error('images')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            {!! Form::label('location', "Location (lat, long)") !!}
                            <div class="input-group">
                                {!! Form::text('location', null, ["class" => "form-control", "placeholder" => "Enter coordinates here"]) !!}
                            </div>
                            @error('location')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            {!! Form::label('address', "Address") !!}
                            <div class="input-group">
                                {!! Form::text("address", null, ["class" => "form-control", "id" => "address", "required" => true, "placeholder" => "Enter Address"]) !!}
                            </div>
                            @error('address')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            {!! Form::label('city', "City") !!}
                            <div class="input-group">
                                {!! Form::text("city", null, ["class" => "form-control", "id" => "city", "required" => true, "placeholder" => "Enter City"]) !!}
                            </div>
                            @error('city')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            @if ($bar)
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

@section('scripts')

    <script>
        $(function() {
            $('#background_color').colorpicker();
            $('.select2').select2();
        });
    </script>
    
@endsection