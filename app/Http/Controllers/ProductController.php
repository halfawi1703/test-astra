<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return ProductResource::collection($products);
    }

    public function detail($id)
    {
        $product = Product::findOrFail($id);

        return New ProductResource($product);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:225',
            'description' => 'required|max:225',
            'price' => 'required',
            'file' => 'required'
        ]);

        $image = null;
        if ($request->file) {
            $fileName = $this->generateRandomString();
            $extention = $request->file->extension();
            $image = $fileName.'.'.$extention;
            // validation
            Storage::putFileAs('image', $request->file, $image);
        }

        $request['image'] = $image;
        $product = Product::create($request->all());
        return New ProductResource($product);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:225',
            'description' => 'required|max:225',
            'price' => 'required',
            'file' => 'required'
        ]);

        $image = null;
        if ($request->file) {
            $fileName = $this->generateRandomString();
            $extention = $request->file->extension();
            $image = $fileName.'.'.$extention;
            // validation
            Storage::putFileAs('image', $request->file, $image);
        }

        $request['image'] = $image;
        $product = Product::findOrFail($id);
        $product->update($request->all());

        return New ProductResource($product);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return New ProductResource($product);
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
