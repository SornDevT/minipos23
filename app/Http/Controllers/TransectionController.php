<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transection;
use App\Models\Product; 
use App\Models\Bill;
use App\Models\Bill_list;

class TransectionController extends Controller
{
    //

    //add transection

    public function add(Request $request)
    {
        

        try{

            // Bill 
            $bill_id = 'B' . date('Ymd') . rand(100, 999);
            $bill = new Bill();
            $bill->bill_id = $bill_id;
            $bill->customer_name = $request->customer_name;
            $bill->customer_tel = $request->customer_tel;
            $bill->save();

            // add transection 

        foreach($request->listorder as $item) {

                    // create transection id 
                    $tran_id = 'TRN' . date('YmdHis') . rand(100, 999);

                    $transection = new Transection();
                    $transection->tran_id = $tran_id;
                    $transection->tran_type = 'income';
                    $transection->product_id = $item['id'];
                    $transection->qty = $item['qty'];
                    $transection->price = $item['price'];
                    $transection->detail = $item['name'];
                    $transection->save();

                    // update product stock minus 
                    $product = Product::find($item['id']);
                    if ($product) {
                        $product->qty = $product->qty - $item['qty'];
                        $product->save();
                    } 

                    // add to bill list
                    $bill_list = new Bill_list();
                    $bill_list->bill_id = $bill_id;
                    $bill_list->name = $item['name'];
                    $bill_list->qty = $item['qty'];
                    $bill_list->price = $item['price'];
                    $bill_list->save();


                }

                $success = true;
                $message = 'ເພີ່ມຂໍ້ມູນສຳເລັດ';


        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
            $bill_id = null;
        }
        $response = [
            'success' => $success,
            'message' => $message,
            'bill_id' => $bill_id,
        ];
        return response()->json($response, 201);

    }

    public function index()
    {
        $sort =  \Request::get('sort');
        $perpage = \Request::get('per_page');
        $month_type = \Request::get('month_type');
        $dmy = \Request::get('dmy');

        $m = explode('-', $dmy)[1];
        $y = explode('-', $dmy)[0];

        // get transection by month
        if($month_type === 'm') {
            
            $tran = Transection::orderBy('id', $sort)
                ->whereMonth('created_at', $m)
                ->whereYear('created_at', $y)
                ->paginate($perpage)
                ->toArray();

        } elseif($month_type === 'y') {
            
            $tran = Transection::orderBy('id', $sort)
                ->whereYear('created_at', $y)
                ->paginate($perpage)
                ->toArray();

        } 


        return array_reverse($tran);
    }
}
