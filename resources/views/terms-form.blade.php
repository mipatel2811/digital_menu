@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">                    
                    {!! Form::model($term, $formAttributes) !!}

                        {!! Form::hidden('type', strtolower($title)) !!}
                        <div class="form-group">
                            {!! Form::label('term-name', 'Name') !!}
                            <div class="input-group">
                                {!! Form::text('name', null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Add '.ucwords($title).' Name', "id" => 'term-name' ]) !!}
                            </div>
                            @error('name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            {!! Form::label('term-slug', 'Slug') !!}
                            <div class="input-group">
                                {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Add '.ucwords($title).' Slug', 'required' => true]) !!}
                            </div>
                            @error('slug')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            {!! Form::label('description', 'Description') !!}
                            <div class="input-group">
                                {!! Form::textarea('description', null, ["class" => "form-control", "placeholder" => "Enter Description here..."]) !!}
                            </div>
                            @error('description')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            @if ($term)
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