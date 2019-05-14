@extends('layouts.app')

@section('content')
    <h1>Add Product</h1>
    {!! Form::open(['action' => 'ProductsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('name', 'Name')}}
            {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Product Name'])}}
        </div> 
        <div class="form-group">
            {{Form::label('type', 'Type')}}
            {{Form::text('type', '', ['class' => 'form-control', 'placeholder' => 'Product Type'])}}
        </div>
        <div class="form-group">
            {{Form::label('details', 'Details')}}
            {{Form::textarea('details', '', ['id' => 'article-ckeditor' , 'class' => 'form-control', 'placeholder' => 'Product Details'])}}
        </div>
        <div class="form-group">
            {{Form::label('price', 'Price')}}
            {{Form::text('price', '', ['class' => 'form-control', 'placeholder' => 'Product Price'])}}
        </div> 
        <div class="from-group">
            {{Form::file('cover_image')}}
        </div>
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}  
    {!! Form::close() !!}
    
@endsection