<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use Carbon\Carbon;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.orders', [
            'data' => Item::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_code' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['statusCode'=>401,'status'=>'error','message'=>'You got an error while validating the form.','errors'=>$validator->errors()], 401);
        }
        Order::create([
            'order_code'=>$request->order_code,
            'order_date'=>Carbon::now(),
        ]);


        return redirect()->back()->with(['message'=>'Order berhasil ditambahkan','status'=>'success']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $plant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Order::where('id', $id)->update([
            'order_code'=>$request->order_code,
        ]);
        return redirect()->back()->with(['message'=>'Order berhasil di update','status'=>'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $plant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Order::where('id', $id)->delete();
        return redirect()->back()->with(['message'=>'Order berhasil di delete','status'=>'success']);
    }
}
