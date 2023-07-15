@extends('layouts.admin')

@section('content')
    @php
        $category = [];
        $brands = [];
        $ingredients = [];
        foreach($terms as $term) {
            if($term->type == "category") {
                $category[$term->id] = $term->name;
            } 
            if($term->type == "ingredients") {
                $ingredients[$term->id] = $term->name;
            }
            if($term->type == 'brands') {
                $brands[$term->id] = $term->name;
            }
        }

        $bars = [];
        foreach($barsList as $bar) {
            $bars[$bar->id] = $bar->name;
        }

    @endphp

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">                    
                    {!! Form::model($item, $formAttributes) !!}
                                                
                        <div class="form-group">
                            {!! Form::label('name', "Name") !!}
                            <div class="input-group">
                                {!! Form::text("name", null, ["class" => "form-control", "id" => "name", "placeholder" => "Enter Item Name", "required" => true]) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('slug', "Slug") !!}
                            <div class="input-group">
                                {!! Form::text('slug', null, ["class" => "form-control", "id" => "slug", "placeholder" => "Enter Item slug", "required" => true]) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('bar_id', 'Select Bar') !!}
                            <div class="input-group">
                                {!! Form::select('bar_id', $bars, null, ["class" => "form-control select2"]) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('description', "Description") !!}
                            <div class="input-group">
                                {!! Form::textarea('description', null, ["class" => "form-control", "id" => 'description', "placeholder" => 'Enter Item Description here...']) !!}
                            </div>
                        </div>   
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    {!! Form::label('category', "Category") !!}
                                    <div class="input-group">                                        
                                        {!! Form::select("category", $category, null, ["class" => "form-control select2", "id" => "category", "data-placeholder" => "Select Category", "required" => true]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    {!! Form::label('brand', "Brand") !!}
                                    <div class="input-group">                                        
                                        {!! Form::select("brand", $brands, null, ["class" => "form-control select2", "id" => "brand", "data-placeholder" => "Select Brand", "required" => true]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('ingredients', "Ingredients") !!}
                            <div class="input-group">
                                {!! Form::select("ingredients[]", $ingredients, null, ["class" => "form-control select2", "id" => "ingredients", "data-placeholder" => "Select Ingredients", "multiple" => true, "required" => true]) !!}
                            </div>
                        </div>
                        

                        <div class="form-group">
                            {!! Form::label("Upload Media") !!}
                            {!! Form::hidden('media_type', "image") !!}
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs justify-content-around">
                              <li class="nav-item w-50 text-center">
                                <a class="nav-link active" data-toggle="tab" href="#media1" data-type="image">
                                    Image
                                </a>
                              </li>
                              <li class="nav-item w-50 text-center">
                                <a class="nav-link" data-toggle="tab" href="#media2" data-type="video">
                                    Video
                                </a>
                              </li>                              
                            </ul>
                          
                            <!-- Tab panes -->
                            <div class="tab-content media-type-container">
                              <div id="media1" class="tab-pane mt-2 active">
                                {!! Form::label('upload-image', "Upload Image") !!}
                                {!! Form::file('images[]', ["class" => "form-control", "id" => "upload-image", "multiple" => true, "accept" => "image/*"]) !!}
                              </div>
                              <div id="media2" class="tab-pane mt-2 fade">
                                {!! Form::label('upload-video', "Upload Video") !!}                                
                                {!! Form::file('video', ["class" => "form-control", "id" => "upload-video", "accept" => "video/*"]) !!}
                              </div>                              
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    {!! Form::label('price', "Price") !!}
                                    <div class="input-group">
                                        {!! Form::text('price', null, ["class" => "form-control", "id" => "price", "placeholder" => "Enter Price", "required" => true]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    {!! Form::label('sale_price', "Sale Price") !!}
                                    <div class="input-group">
                                        {!! Form::text('sale_price', null, ["class" => "form-control", "id" => "sale_price", "placeholder" => "Enter Sale Price", "required" => true]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="form-group">
                            @if ($item)
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
            $('.select2').select2();

            $('.form-group .nav-link').click((e) => {                
                $('input[name="media_type"]').val($(e.target).data('type'));                
            });
        });
    </script>
@endsection