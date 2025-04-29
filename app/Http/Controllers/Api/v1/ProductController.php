<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Product;
use App\Models\ProductPrice;

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

    public function craete()
    {
        $productImage = '';

        if($request->hasFile('photo')) {
            $productImage = $this->handleFile($request->photo);
        }



        return response()->json([
            'message' => 'Congratulations !'
        ]);
    }

    public function update()
    {
        return response()->json([
            'message' => 'Congratulations !'
        ]);
    }

    public function delete()
    {
        return response()->json([
            'message' => 'Congratulations !'
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
        $path = $file->storeAs('about', $fileName, 'private'); // Use 'local' if 'private' is not configured
        return $fileName;
    }
}
