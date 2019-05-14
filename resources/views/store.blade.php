@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Your Store</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="/products/create" class="btn btn-primary">Add Product</a>
                    <hr>
                    <h3>Your Products</h3>
                    @if(count($products) > 0)
                        <table class="table table-striped">
                            <tr>
                                <th>Product name</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->type}}</td>
                                    <td>{{$product->price}}</td>
                                    <td><a href="/products/{{$product->id}}/edit" class="btn btn-primary">Edit</a></td>
                                    <td>
                                        {!! Form::open(['action' => ['ProductsController@destroy', $product->id], 'method' => 'POST', 'class' => 'pull-right']) !!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else 
                        <p>You have no Product</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
