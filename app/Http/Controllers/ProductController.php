<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Assuming you have a Product model

class ProductController extends Controller
{
    //
    // created crud for product use try catch same as CategoryController
    public function index()
    {
       
            $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name')
            ->orderBy('products.id', 'asc')
            ->paginate(10)
            ->toArray();


            return response()->json($products, 200);
   
    }

    public function add(Request $request)
    {
        try {
            $product = new Product();
            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->image = $request->image;
            $product->qty = $request->qty;
            $product->price_buy = $request->price_buy;
            $product->price_sell = $request->price_sell;
            $product->save();

            $success = true;
            $message = 'ເພີ່ມຂໍ້ມູນສຳເລັດ';

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }
        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response, 201);
            
    }

    public function edit($id)
    {
       
         // get product by id try catch
        try{
            $product = Product::find($id);
            
            $success = true;
            $message = 'ດຶງຂໍ້ມູນສຳເລັດ';
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }
        $response = [
            'success' => $success,
            'message' => $message,
            'product' => $product,
        ];
        return response()->json($response, 200);
           
    }
    public function update(Request $request, $id)
    {
        try {
            $product = Product::find($id);
            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->image = $request->image;
            $product->qty = $request->qty;
            $product->price_buy = $request->price_buy;
            $product->price_sell = $request->price_sell;
            $product->save();

            $success = true;
            $message = 'ແກ້ໄຂຂໍ້ມູນສຳເລັດ';

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }
        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }


    public function delete($id)
    {
        try {
            $product = Product::find($id);
            $product->delete();

            $success = true;
            $message = 'ລຶບຂໍ້ມູນສຳເລັດ';

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }
        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }


}
