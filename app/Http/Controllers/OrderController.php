<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

        public function index(Request $request)
    {
        $records = Order::where(function($q) use($request){
            if ($request->order_id)
            {
                $q->where('id',$request->order_id);
            }
            if ($request->restaurant_id)
            {
                $q->where('restaurant_id',$request->restaurant_id);
            }
            if ($request->status)
            {
                $q->where('status',$request->status);
            }
            if ($request->from && $request->to)
            {
                $q->whereDate('created_at' , '>=' , $request->from);
                $q->whereDate('created_at' , '<=' , $request->to);
            }
        })->with('restaurant')->latest()->paginate(20);
        return view('orders.index',compact('records'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $records = Order::with('items')->find($id);
        return view('orders.show', compact('records'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}


