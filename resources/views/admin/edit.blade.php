@extends('admin.layout');

@section('body')
    @include('error')
    <form class="text-white" method="POST" action="{{ url("products/update/$product->id") }}" enctype="multipart/form-data"
        data-bs-theme="dark">
        @csrf
        <div class="mb-3" data-bs-theme="dark">
            <label for="productName" class="form-label">Product Name:</label>
            <input value="{{ $product->name }}" name="name" type="text" class="form-control text-white"
                id="productName" aria-describedby="productName">
        </div>
        <div class="mb-3">
            <label for="productDesc" class="form-label">Product Description:</label>
            <textarea class="form-control text-white" name="desc" placeholder="desc" id="productDesc" rows="3">{{ $product->desc }}</textarea>
        </div>
        <div class="mb-3">
            <label for="productPrice" class="form-label">Product Price:</label>
            <input value="{{ $product->price }}" type="text" name="price" inputmode="numeric"
                class="form-control text-white" id="productPrice" aria-describedby="productPrice">
        </div>
        <div class="mb-3">
            <label for="productQuantity" class="form-label">Product Quantity:</label>
            <input value="{{ $product->quantity }}" type="text" name="quantity" inputmode="numeric"
                class="form-control text-white" id="productQuantity" aria-describedby="productQuantity">
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select mb-3" id="category" name="category_id" aria-label="category select">
                <option value="{{ $product->category->id }}" selected>{{ $product->category->name }}</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>


        <div class="mb-3">
            <label for="formFile" class="form-label">Product Image</label>
            <img src="{{ asset("storage/$product->image") }}" width="100px" alt="">
            <input name="image" class="form-control text-white" type="file" id="formFile">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
