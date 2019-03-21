<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (\Auth::check()) {
      $user = \Auth::user();
      $tasks = $user->Tasks()->paginate(25);
      return view('tasks.index',['tasks'=> $tasks,]);
    }
      return view('welcome');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    $tasks = new Task;

    return view('tasks.create', [
    'task' => $tasks,
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
    $this->validate($request, [
    'content' => 'required|max:191',
    ]);
    
    $task = new Task;
    $user = \Auth::user();
    $task->content =$request->content;
    $task->user_id =$user->id;
    $task->save();
    
    return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        if($task === NULL){
            return redirect('/');
        }
            if (\Auth::id() === $task->user_id) {
                return view('tasks.show', [
                'task' => $task,        
                ]);
            }
        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        if($task === NULL){
            return redirect('/');
        }
        
            if (\Auth::id() === $task->user_id) {
            return view('tasks.edit', [
            'task' => $task,
            ]);
        }
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
        $this->validate($request, [
            'content' => 'required|max:191',
        ]);
        
    $task = Task::find($id);

    $task->content = $request->content;
    $task->save();
    
    return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
    
        if (\Auth::id() === $task->user_id) {
            $task->delete();
            return redirect('/');
        }
            return back();
        }
    }
