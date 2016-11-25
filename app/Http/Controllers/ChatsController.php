<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
//use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use App\Message;
use App\Team;
use App\Http\Requests\MessageRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Session;
use Symfony\Component\HttpFoundation\Response;

class ChatsController extends Controller
{
    /**
     * MessagesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('editor',['only'=>'show','update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['teams']= Team::all();
        $data['messages']=$this->getLastDay();
        $data['message']= new Message();
        $data['method']='POST';
        return view('chatAjax.welcome')->with('data',$data);
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
    public function store(MessageRequest $request)
    {
        $message=$request->all();
        $teamsIds=$request->teams;
        $message['published_at']=Carbon::now();
        $data=Auth::user()->messages()->create($message);
        $data->teams()->attach($teamsIds);
        $data['name']=Auth::user()->name;
        \Session::flash('flash_message','New Message from  '.Auth::user()->name);

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['message']=Message::findOrFail($id);
        $teams= $data['message']->teams;
        foreach($teams as $team){
            $data['teams'][]=$team->id;
        }
//        $data['teams']=$teams;

        return response()->json($data);
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
    public function update(MessageRequest $request, $id)
    {
        $input=$request->all();
        $message=Message::findOrFail($id);
        $message->message=$input['message'];
//        echo '<pre>'.print_r($message->message,true).'</pre>';die;
        $message->update();
        $message->teams()->sync($input['teamsId']);
        \Session::flash('flash_message','Changed Message from  '.Auth::user()->name);
        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $message=Message::findOrFail($id);
        $message->teams()->detach();
        $message->delete();
        flash(Auth::user()->name.' delete message');
        return response()->json($message);
    }

    protected function getLastDay(){
        return Message::oldest('published_at')->published()->get();
    }
}
