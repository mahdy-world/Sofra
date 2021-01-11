<?php

namespace App\Http\Controllers;

use App\Models\Block;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $records = Block::paginate(20);
        return view('blocks.index', compact('records'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blocks.create');
    }

    public function store(Request $request)
    {
        //
        $rules = [
            'name' => 'required',
            'city_id' => 'required',
        ];

        $message = [
            'name.required' => 'Name Is Required',
            'city_id.required' => 'City Id is Required'
        ];
        $this->validate($request,$rules,$message);
        $record = Block::create($request->all());
        flash('Created!')->success();
        return redirect(route('blocks.index'));
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Block::findOrFail($id);
        return view('blocks.edit', compact('model'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $records = Block::findOrFail($id);
        $records->update($request->all());
        flash('Edited!')->success();
        return redirect(route('blocks.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Block::findOrFail($id);
        $record->delete();
        flash('Deleted!')->error();
        return back();
    }
}
