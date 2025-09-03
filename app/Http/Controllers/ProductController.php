<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //Get all products

    public function all(){
        $products = Product::paginate(5);
        return view('admin.allProducts')->with("products",$products);
    }

    // Show product
    public function show($id){
        $product = Product::findOrFail($id);
        return view('admin.show')->with("product",$product);
    }

    //Create Product
    public function create(){
        $categories = Category::all();
        return view("admin.create",compact("categories"));
    }

    public function store(Request $request){
        $data = $request->validate([
            "name" =>"required|string|max:255",
            "desc" => "required|string",
            "price" => "required|numeric",
            "quantity"=>"required|numeric",
            "image"=>"required|image|mimes:jpg,jpeg,png",
            "category_id" =>"required|exists:categories,id"
        ]);

        if($request->has("image")){
            $data['image'] = Storage::putFile("products",$data['image']);
        }

        Product::create($data);
        session()->flash("success","Product Added Successfully");

        return redirect(url("products"));
    }


    //Delete Product
    public function delete($id){
        $product = Product::findOrFail($id);
        Storage::delete($product['image']);
        $product->delete();
        session()->flash("success","Product Deleted Successfully");
        return redirect(url('products'));
    }


    // Edit Product
    public function edit($id){
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view("admin.edit",["product"=>$product,"categories"=>$categories]);
    }

     public function update($id, Request $request){

        $product = Product::findOrFail($id);
        $data = $request->validate([
            "name" =>"required|string|max:255",
            "desc" => "required|string",
            "price" => "required|numeric",
            "quantity"=>"required|numeric",
            "image"=>"image|mimes:jpg,jpeg,png",
            "category_id" =>"required|exists:categories,id"
        ]);

        if($request->has("image")){
            $data['image'] = Storage::putFile("products",$data['image']);
            Storage::delete($product['image']);
        }


        $product->update($data);
        session()->flash("success","Product updated Successfully");

        return redirect(url("products"));
    }
}
