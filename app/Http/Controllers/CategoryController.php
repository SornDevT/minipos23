<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category; // Assuming you have a Category model

class CategoryController extends Controller
{
    //

    // created crud for category use try catch
    public function index()
    {
      
            $categories = Category::all();
            return response()->json($categories, 200);
  
    }

    public function add(Request $request)
    {
        try {

            $category = new Category();
            $category->name = $request->name;
            $category->save();

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
  
            $category = Category::find($id);
            return response()->json($category, 200);
          
    }

    public function update(Request $request, $id)
    {
        try {

            $category = Category::find($id);
            $category->name = $request->name;
            $category->save();

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

            $category = Category::find($id);
            $category->delete();

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
