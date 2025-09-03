@extends('admin.layout');
@section('body')
    <h3>Product</h3>

    Product Name: {{ $product->name }} <br />
    Product price: {{ $product->price }} <br />
    Product Quantity: {{ $product->quantity }} <br />
    Product Desc: {{ $product->desc }} <br />
    Product Image:
    <img src="{{ asset("storage/$product->image") }}" width="200px" alt="">
@endsection
