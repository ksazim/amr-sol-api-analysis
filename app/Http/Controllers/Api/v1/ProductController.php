<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Product;
use App\Models\ProductPrice;

use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function list()
    {
        try {
            $list = Product::with('prices')->paginate(10);
            return response()->json([
                'list' => $list,
                'status' => 200,
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'message' => 'Server Error !',
                'status' => 500,
            ]);
        }
    }

    public function create(Request $request)
    {
        // Validation 
        $validate = Validator::make($request->all(), [
            'name'        => 'required',
            'description' => 'required',
            'stock'       => 'required',
            'status'      => 'required'
        ]);

        if($validate->fails()) {
           return response()->json([
            'status' => 400,
            'errors' => $validate->errors()
           ]);
        }

        try {
            $prd_img = '';
            if($request->hasFile('prd_img')) {
               $prd_img = $this->handleFile($request->prd_img);
            }

            Product::create([
                'name'        => $request->name,
                'description' => $request->description,
                'prd_img'     => $prd_img,
                'sku'         => $this->generateSKU(),
                'cat'         => $request->cat,
                'stock'       => $request->stock,
                'status'      => $request->status
            ]);
    
            return response()->json([
                'status'   => 200,
                'message'  => 'Product Created Successfully !'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'   => 500,
                'message'  => $e
            ]);
        }
    }

    public function getById($id)
    {
        $product = Product::where('id', $id)->first();

        if(!$product) {
            return response()->json([
                'status'   => 404,
                'message'  => 'No Data Found !'
            ]);    
        }

        return response()->json([
            'status'   => 200,
            'data'     => $product
        ]);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'name'        => 'required',
            'description' => 'required',
            'stock'       => 'required',
            'status'      => 'required'
        ]);

        if($validate->fails()) {
           return response()->json([
            'status' => 400,
            'errors' => $validate->errors()
           ]);
        }

        try {
            $product = Product::findOrFail($id); // Get existing product or fail

            $prd_img = $product->prd_img; // default to old image

            if ($request->hasFile('prd_img')) {
                $prd_img = $this->handleFile($request->file('prd_img'));
            }

            $product->update([
                'name'        => $request->name,
                'description' => $request->description,
                'prd_img'     => $prd_img,
                'cat'         => $request->cat,
                'stock'       => $request->stock,
                'status'      => $request->status
            ]);

            return response()->json([
                'status'  => 200,
                'message' => 'Product Updated Successfully!'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'   => 500,
                'message'  => $e
            ]);
        }
    }

    public function delete($id)
    {
        $product = Product::find($id);

        if(!$product) {
            return response()->json([
                'status'   => 404,
                'message'  => 'No Data Found !'
            ]);    
        }

        $product->delete();

        return response()->json([
            'status'   => 200,
            'message'  => 'Data Deleted Successfully !'
        ]);
    }

    private function generateSKU()
    {
        return strtoupper(Str::random(8)); // e.g., 'A8K2LMQZ'
    }

    private function handleFile($file)
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = time() . '.' . $extension;
        $path = $file->storeAs('about', $fileName, 'private'); 
        return $path;
    }
}
