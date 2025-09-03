<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiProductController extends Controller
{
    //

    public function all(){
        $products = Product::all();
        if(empty($products) ){
            return response()->json([
                "msg"=>"Products Not Found"
            ],404);
        }
        return ProductResource::collection($products);
    }

    public function show($id){
        $product = Product::find($id);

        if($product == null){
            return response()->json([
                "msg"=>"Product Not Found"
            ],404);
        }

        return new ProductResource($product);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            "name"=>"required|string|max:255",
            "desc"=>"required|string",
            "price"=>"required|numeric",
            "image"=>"required|image|mimes:png,jpg,jpeg",
            "quantity"=>"required|integer",
            "category_id"=>"required|exists:categories,id"
        ]);

        if($validator->fails()){
            return ApiProductController::jsonResponse(["errors"=>$validator->errors()],301);
        }

        $imagePath = Storage::putFile('products',$request->image);
        $product = Product::create([
            "name"=>$request->name,
            "desc"=>$request->desc,
            "price"=>$request->price,
            "quantity"=>$request->quantity,
            "image"=>$imagePath,
            "category_id"=>$request->category_id,
        ]);

        return ApiProductController::jsonResponse(["msg"=>"Product Added Successfully","product"=>$product],201);

    }


    public function update($id,Request $request){

        //validation

        $validator = Validator::make($request->all(),[
            "name"=>"required|string|max:255",
            "desc"=>"required|string",
            "price"=>"required|numeric",
            "image"=>"image|mimes:png,jpg,jpeg",
            "quantity"=>"required|integer",
            "category_id"=>"required|exists:categories,id"
        ]);

        if($validator->fails()){
            return ApiProductController::jsonResponse(["errors"=>$validator->errors()],301);
        }

        $product = Product::find($id);

        if($product == null){
            return ApiProductController::jsonResponse(["errors"=>["Product Not Found"]],404);
        }

        $imagePath = $product->image;

        if($request->has('image')){
            Storage::delete($imagePath);
            $imagePath = Storage::putFile("products",$request->image);
        }
        $product->update([
            "name"=>$request->name,
            "desc"=>$request->desc,
            "price"=>$request->price,
            "quantity"=>$request->quantity,
            "image"=>$imagePath,
            "category_id"=>$request->category_id,
        ]);

        return ApiProductController::jsonResponse(["msg"=>"Product Updated Successfully","product"=>$product],201);



    }

    public function delete($id){
        $product = Product::find($id);

        if($product == null){
            return ApiProductController::jsonResponse(["errors"=>["Product Not Found"]],404);
        }

        if($product->image !== null){
            Storage::delete($product->image);
        }

        $product->delete();

        return ApiProductController::jsonResponse(["msg"=>"Product deleted Successfully","product_id"=>$product->id],201);

    }





    private static function jsonResponse($res,$code){
        return response()->json($res,$code);
    }


}
