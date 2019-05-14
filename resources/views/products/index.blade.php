@extends('layouts.app')

@section('content')
    <h1>Products</h1>
    @if(count($products) > 0)
        @foreach($products as $product)
            <div class="jumbotron text-left">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img style="width:100%" src="/storage/cover_image/{{$product->cover_image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                            <h2><a href="/products/{{$product->id}}">{{$product->name}}</a></h2>
                            <h5>Type: {{$product->type}}, Price:{{$product->price}}</h5>
                            <small>Posted on: {{$product->created_at}} </small>            
                    </div>    
                </div>    
                
            </div>
        @endforeach
        {{$products->links()}}
    @else
    <p>NO Product</p>
    @endif
@endsection