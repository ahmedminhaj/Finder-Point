@extends('layouts.app')

@section('content')
    <a href="/products" class="btn btn-primary">Go Back</a>
    <h1>{{$product->name}}</h1>
    <img style="width:50%" src="/storage/cover_image/{{$product->cover_image}}">
    <br>
    <br>
    <div>
        <h4>{!! $product->details !!}</h4>
        <h5>Type: {{$product->type}}, Price:{{$product->price}}</h5>

    </div>
    <hr>
    <small>Posted on: {{$product->created_at}} </small>
    <hr>
    @if(!Auth::guest())
        @if(Auth::user()->id == $product->user_id) 
            <a href="/products/{{$product->id}}/edit" class="btn btn-primary">Edit</a>

            {!! Form::open(['action' => ['ProductsController@destroy', $product->id], 'method' => 'POST', 'class' => 'pull-right']) !!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!! Form::close() !!}
        @endif
    @endif
@endsection