@extends('admin.layout')
@section('body')
    @include('success')
    <div class="row ">
        @if (session()->has('locale'))
            <div class="alert alert-danger">{{ session()->get('locale') }}</div>
        @endif
        <div class="alert alert-danger">{{ App::currentLocale() }}</div>

        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Products</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> Product Name </th>
                                    <th> Product Price </th>
                                    <th> Product quantity </th>
                                    <th> Product Image </th>
                                    <th> Actions </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>
                                            {{ $product->name }}
                                        </td>
                                        <td>
                                            {{ $product->price }}
                                        </td>
                                        <td>
                                            {{ $product->quantity }}
                                        </td>
                                        <td>
                                            <img src="{{ asset("storage/$product->image") }}"
                                                alt="{{ $product->name }}-image" />
                                        </td>
                                        <td>
                                            <a href="{{ url("products/show/$product->id") }}">
                                                <div class="btn btn-info">Show</div>
                                            </a>
                                            <a href="{{ url("products/edit/$product->id") }}">
                                                <div class="btn btn-success">Edit</div>
                                            </a>

                                            <form action="{{ url("products/delete/$product->id") }}" class="d-inline"
                                                method="POST">
                                                @csrf
                                                <button class="btn btn-danger" type="submit">Delete</button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class=" mt-3">
                {{ $products->links() }}

            </div>

        </div>
    </div>
@endsection
