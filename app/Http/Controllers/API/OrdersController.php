<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
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
        if (isset($_GET['filter'])) {
            $data = Order::where('order_code','LIKE','%'.$_GET['filter'].'%')->paginate(10);
        return response()->json(['statusCode'=>200,'message'=>'Data Order has been obtained.','data'=>$data], 200);
        } else {
            $data = Order::paginate(10);
        return response()->json(['statusCode'=>200,'message'=>'Data Order has been obtained.','data'=>$data], 200);
        }
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
        if($validator->fails()){
            return response()->json(['statusCode'=>401,'message'=>'You got an error while validating the form.','errors'=>$validator->errors()], 401);
        }
        $id = Order::create([
            'order_code'=>$request->order_code,
            'order_date'=>Carbon::now()
        ]);
        $data = Order::where('id', $id)->first();
        return response()->json(['statusCode'=>200,'message'=>'Data Order has been created.'], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Orders  $plant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'order_code' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['statusCode'=>401,'message'=>'You got an error while validating the form.','errors'=>$validator->errors()], 401);
        }

        Order::where('id',$id)->update([
            'order_code'=>$request->order_code,
        ]);
        return response()->json(['statusCode'=>200,'message'=>'Data Order has been updated.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Orders  $plant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Order::where('id',$id)->delete();
        return response()->json(['statusCode'=>200,'message'=>'Data Order has been deleted.'], 200);
    }
}
