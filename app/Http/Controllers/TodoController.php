<?php

namespace App\Http\Controllers;
use Auth;   
use Illuminate\Http\Request;

use App\Models\Todo;
use App\Models\User;
use App\Notifications\TodoAffected;


class TodoController extends Controller
{
    
    public $users;

    public function __construct(){
        $this->users = User::getAllUsers();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $users = $this->users;
        $data = Todo::where(['affectedto_id'=> $userId])->orderBy('id','desc')->paginate(10);
        //
        // $data = Todo::all()->reject(function($todo){
        //     return $todo->done == 0;
        // });
        return view('todos.index',compact('data','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
        // dd($request);
        $todo = new Todo();
        $todo->creator_id = Auth::user()->id;
        $todo->affectedto_id = Auth::user()->id;
        $todo->name = $request->name;
        $todo->description = $request->description;
        $todo->save();

        notify()->success("La todo <span class='badge badge-dark'>#$todo->id</span> a été créée");
        return redirect()->route('todos.index');
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
        $todo = Todo::find($id);
        return view('todos.edit',compact('todo'));
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
        $todo = Todo::find($id);
        if(!isset($request->done)){
            $request['done'] = 0;
        }
        $todo->update($request->all());

        notify()->success("La todo <span class='badge badge-dark'>#$todo->id</span> a bien mise a jour");
        return redirect()->route('todos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param   $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $todo = Todo::find($id)->delete();
        notify()->error("la todo <span class='badge badge-success'>#$todo</span> a été supprimé avec success");
        return back();
    }

    /**
     * Display all done list
     */

    public function done(){
        $users = $this->users;
        $data = Todo::where('done',1)->paginate(10);
        return view('todos.index',compact('data','users'));
    }

    /**
     * Display all undone list
     */

    public function undone(){
        $users = $this->users;
        $data = Todo::where('done',0)->paginate(10);
        return view('todos.index',compact('data','users'));
    }

     /**
     * change status of todo to done.
     *
     * @param  $todo
     * @return void
     */
    public function makedone(Todo $todo){
        $todo->done = 1;
        $todo->update();
        notify()->success("La todo <span class='badge badge-dark'>#$todo->id</span> a été terminée");
        return back();
    }

     /**
     * change status of todo to undone.
     *
     * @param  $todo
     * @return void
     */
    public function makeundone(Todo $todo){
        $todo->done = 0;
        $todo->update();
        notify()->success("La todo <span class='badge badge-dark'>#$todo->id</span> est à nouveau ouverte");

        return back();
    }

    /**
     * assigned a todo to an user.
     *
     * @param Todo $todo
     * @param User $user
     * @return \Illuminate\Http\Response
     */

    public function affectedto(Todo $todo, User $user){
        $todo->affectedto_id = $user->id;
        $todo->affectedby_id = Auth::user()->id;
        $todo->update();

        $user->notify(new TodoAffected($todo));

        return back();
    }

}
