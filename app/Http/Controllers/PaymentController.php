<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Payment::paginate(20);
        return view('pays.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pays.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'restaurant_id' => 'required|exists:restaurants,id',
            'amount' => 'required|numeric',
            'note' => 'required'
        ];

        $message = [
            'restaurant_id.required' => 'Restaurant Is Required',
            'amount.required' => 'Amount Is Required',
            'note.required' => 'Note is Required'
        ];
        $this->validate($request,$rules,$message);

        $record = Payment::create($request->all());
        flash('Created!')->success();
        return redirect(route('pays.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
        $model = Payment::findOrFail($id);
        return view('pays.edit' , compact('model'));
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
        $record = Payment::findOrFail($id);
        $record->update($request->all());
        flash('Edited!')->success();
        return redirect(route('pays.index'));

        /**
         * Remove the specified resource from storage.
         *
         * @param int $id
         * @return \Illuminate\Http\Response
         */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Payment::findOrFail($id);
        $record->delete();
        flash('Deleted!')->error();
        return back();
    }
}
