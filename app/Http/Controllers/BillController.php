<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Bill_list;

class BillController extends Controller
{
    //
    public function print_bill($id)
    {

        $bill = Bill::where('bill_id', $id)->get();
        $bill_lists = Bill_list::where('bill_id', $id)->get();
        
        return view('Bill', compact('bill', 'bill_lists','id'));
    }
}
