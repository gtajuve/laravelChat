<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Message;
use App\Http\Requests\MessageRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Session;

class MessagesController extends Controller
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
        $data['messages']=$this->getLastDay();
        $data['message']= new Message();
        $data['method']='POST';
        return view('chat.index')->with('data',$data);
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
        $message['published_at']=Carbon::now();
        Auth::user()->messages()->create($message);
        \Session::flash('flash_message','New Message from  '.Auth::user()->name);

        return redirect('chat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data['messages']=$this->getAll();
        $data['message']=Message::findOrFail($id);
        $data['method']='PUT';
        return view('chat.index')->with('data',$data);
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
        \Session::flash('flash_message','Changed Message from  '.Auth::user()->name);
        return redirect('chat');
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
        $message->delete();
        flash(Auth::user()->name.' delete message');
        return redirect('chat');
    }

    protected function getLastDay(){
        return Message::oldest('published_at')->published()->get();
    }
}
