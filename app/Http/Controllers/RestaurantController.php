<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function active($id){
        $record = Restaurant::findOrFail($id);
        if($record->is_active == 1){
            $record->is_active = 0;
            $record->save();
        }
        return back();
    }

    public function disactive($id){
        $record = Restaurant::findOrFail($id);
        if($record->is_active == 0){
            $record->is_active = 1;
            $record->save();
        }
        return back();
    }


    public function index(Request $request)
    {
            $records = Restaurant::where(function ($q) use ($request) {
                if ($request->input('name')) {

                    $q->where('name', 'LIKE', '%' . $request->name . '%');

                }
                if ($request->input('city_id')) {
                    $q->whereHas('block', function ($q2) use ($request) {
                        // search in restaurant region "Region" Model
                        $q2->whereCityId($request->city_id);
                    });
                }
                if ($request->has('is_active') && $request->is_active == 1) {
                    $q->where('is_active', 1);
                }
                if ($request->has('is_active') && $request->is_active == 0) {
                    $q->where('is_active', 0);
                }
            })->with('block.city')->latest()->paginate(20);
            //dd($records);
            return view('restaurants.index', compact('records'));

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $record = Restaurant::findOrFail($id);
        $record->delete();
        flash('Deleted!')->error();
        return back();
    }
}

