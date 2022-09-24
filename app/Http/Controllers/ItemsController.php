<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Item,Order};
use Illuminate\Support\Facades\Validator;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (isset($_GET['id'])) {
            return view('admin.item', [
                'data' => Item::where('order_id', $_GET['id'])->get()
            ]);
        } else {
            return view('admin.item', [
                'data' => Item::all()
            ]);
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
            'name' => 'required',
            'price' => 'required',
            'qty' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['statusCode'=>401,'status'=>'error','message'=>'You got an error while validating the form.','errors'=>$validator->errors()], 401);
        }
        if (isset($_GET['id'])) {
            if (is_null(Order::where('id', $_GET['id'])->first())) {
                return redirect()->back()->with(['statusCode'=>401,'status'=>'error','message'=>'Data tidak ditemukan.'], 401);
            }
            Item::create([
                'name'=>$request->name,
                'price'=>$request->price,
                'qty'=>$request->qty,
                'order_id'=>$_GET['id'],
            ]);
        } else {
            if (is_null(Order::where('id', $request->order_id)->first())) {
                return redirect()->back()->with(['statusCode'=>401,'status'=>'error','message'=>'Data tidak ditemukan.'], 401);
            }
            Item::create([
                'name'=>$request->name,
                'price'=>$request->price,
                'qty'=>$request->qty,
                'order_id'=>$request->order_id,
            ]);
        }
        return redirect()->back()->with(['message'=>'Items berhasil ditambahkan','status'=>'success']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Items  $plant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'qty' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['statusCode'=>401,'status'=>'error','message'=>'You got an error while validating the form.','errors'=>$validator->errors()], 401);
        }

        Item::where('id', $id)->update([
            'name'=>$request->name,
            'price'=>$request->price,
            'qty'=>$request->qty,
        ]);
        return redirect()->back()->with(['message'=>'Items berhasil di edit','status'=>'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Items  $plant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Item::where('id', $id)->delete();
        return redirect()->back()->with(['message'=>'Items berhasil di delete','status'=>'success']);
    }
}
