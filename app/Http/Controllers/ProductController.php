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
            $sort = \Request::get('sort');
            $perpage = \Request::get('perpage');
            $category_id = \Request::get('category_id');
            $search = \Request::get('search');

       
            $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name')
            ->orderBy('products.id', $sort);


            if ($category_id!='all') {
                $products = $products->where('products.category_id', $category_id);
            }


            $products = $products->where(function ($query) use ($search) {
                $query->where('products.name', 'like', '%' . $search . '%')
                      ->orWhere('categories.name', 'like', '%' . $search . '%')
                      ->orWhere('products.price_buy', 'like', '%' . $search . '%');
            })
            ->paginate($perpage)
            ->toArray();


            return response()->json($products, 200);
   
    }

    public function add(Request $request)
    {
        try {

            // set path for image
            $imagePath = 'assets/img/products/';

            // check if image is uploaded
            if ($request->hasFile('image')) {
                // change image name to time() + extension
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                // move image to public path
                $image->move(public_path($imagePath), $imageName);
       
            } else {
                $imageName = null; // or set a default image name
            }


            $product = new Product();
            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->image = $imageName;
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

            // set path for image
            $imagePath = 'assets/img/products/';

            $product = Product::find($id);
            // return $request->image;

            // check if image is uploaded and check image from product
            if ($request->hasFile('image')) {

                // if image is uploaded, delete old image if exists
                if ($product->image && file_exists(public_path($imagePath . $product->image))) {
                    unlink(public_path($imagePath . $product->image)); // delete old image
                }

                // change image name to time() + extension
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                // move image to public path
                $image->move(public_path($imagePath), $imageName);
                $product->image = $imageName; // update image in product

            } else {
                // if no image is uploaded, keep the old image
                if($request->image){
                    $imageName = $product->image;

                } else{

                    // if image is uploaded, delete old image if exists
                    if ($product->image && file_exists(public_path($imagePath . $product->image))) {
                        unlink(public_path($imagePath . $product->image)); // delete old image
                    }

                    $imageName = null;
                }
                
            }


            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->image = $imageName;
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

             // set path for image
            $imagePath = 'assets/img/products/';

            $product = Product::find($id);

            // if image is uploaded, delete old image if exists
                    if ($product->image && file_exists(public_path($imagePath . $product->image))) {
                        unlink(public_path($imagePath . $product->image)); // delete old image
                    }

            // delete product
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
