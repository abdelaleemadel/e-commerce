@extends('admin.layout');

@section('body')
    @include('error')
    <form class="text-white" method="POST" action="{{ url('products') }}" enctype="multipart/form-data" data-bs-theme="dark">
        @csrf
        <div class="mb-3" data-bs-theme="dark">
            <label for="productName" class="form-label">Product Name:</label>
            <input value="{{ old('name') }}" name="name" type="text" class="form-control text-white" id="productName"
                aria-describedby="productName">
        </div>
        <div class="mb-3">
            <label for="productDesc" class="form-label">Product Description:</label>
            <textarea class="form-control text-white" name="desc" placeholder="desc" id="productDesc" rows="3">{{ old('desc') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="productPrice" class="form-label">Product Price:</label>
            <input value="{{ old('price') }}" type="text" name="price" inputmode="numeric"
                class="form-control text-white" id="productPrice" aria-describedby="productPrice">
        </div>
        <div class="mb-3">
            <label for="productQuantity" class="form-label">Product Quantity:</label>
            <input value="{{ old('quantity') }}" type="text" name="quantity" inputmode="numeric"
                class="form-control text-white" id="productQuantity" aria-describedby="productQuantity">
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select mb-3" id="category" name="category_id" aria-label="category select">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>


        <div class="mb-3">
            <label for="formFile" class="form-label">Product Image</label>
            <input name="image" class="form-control text-white" type="file" id="formFile">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
