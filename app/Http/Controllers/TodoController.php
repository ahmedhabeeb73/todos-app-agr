<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos=Todo::all();
        return view('todos.index',compact('todos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
        'title'=>'required|min:4',
        'content'=>'required'
        ]);

        $todo=Todo::create([
           'title'=>request('title'),
           'content'=>request('content'),
         
        ]);

        $request->session()->flash('success','Todo created successfully');

        return redirect()->route('todos.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $todo=Todo::find($id);
        return view('todos.show',compact('todo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo=Todo::findOrFail($id);
        return view('todos.edit',compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $todo=Todo::findOrFail($id);

        $request->validate([
            'title'=>'required|min:4',
            'content'=>'required'
            ]);
    
            $todo->update([
               'title'=>request('title'),
               'content'=>request('content'),
               $todo->save()
             
            ]);
            session()->flash('success','Todo updated successfully');
            return redirect()->route('todos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $todo=Todo::findOrFail($id);
        $todo->delete();

        session()->flash('success','Todo deleted successfully');
        return redirect()->route('todos.index');
    }



    public function complate($id)
    {
        $todo=Todo::findOrFail($id);
        $todo->completed=true;
        $todo->save();
        session()->flash('success','Todo compated successfully');
        return redirect()->route('todos.index');
    }
}
