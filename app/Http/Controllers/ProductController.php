<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function addProduct(Request $req)
    {
        $product = new Product;
        $product->title = $req->title;
        $product->description = $req->description;
        $product->price = $req->price;
        $product->save();
        return response()->json($product);
    }

    public function getProduct()
    {

        return response()->json(
            Product::latest()->get()
        );
    }

    public function singleProduct(string $id)
    {
        $product = Product::find($id);
        if (empty($product)) {
            return response()->json([
                'message' => 'product not found'
            ]);
        }
        return response()->json($product);
    }

    public function deleteProduct(string $id)
    {
        $product = Product::find($id);
        if (empty($product)) {
            return response()->json([
                'message' => 'product not found'
            ]);
        }
        $product->delete();
        return response()->json([
            'message' => 'product deleted successfully'
        ]);
    }

    public function updateProduct(Request $req)
    {
        $product = Product::find($req->id);
        if (empty($product)) {
            return response()->json([
                'message' => 'product not found'
            ]);
        }
        $product->title = $req->title;
        $product->description = $req->description;
        $product->price = $req->price;
        $product->save();
        return response()->json(['product' => $product, 'massage' => 'Updated!']);
    }
}
