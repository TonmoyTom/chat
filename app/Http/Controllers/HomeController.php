<?php

namespace App\Http\Controllers;

use App\Events\MessageSend;
use App\Models\Message;
use App\Models\PrivateMessage;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public  function chat(){
        return view('chat');
    }

    public function allMessage(){
        $user =   Message::with('user')->get();
        return $user;
    }
    public function postMessage( Request  $request){
        $message =  Message::create([
            'user_id' => auth()->id(),
            'message' => $request->message
        ]);
        broadcast(new MessageSend($message->load('user')))->toOthers();
        return response()->json([
            'sucess' => "Message Send"
        ], 202);
    }

    public  function privateChat(){
        return view('private');
    }

    public function contact(){
        $user = User::where('id', '!=', auth()->id())->orderBy('id' , 'desc')->get();
        $count = PrivateMessage::select(\DB::raw('`from` as sender_id, count(`from`) as messages_count'))
            ->where('to', auth()->id())
            ->where('read', false)
            ->groupBy('from')
            ->get();

        $contacts = $user->map(function($contact) use ($count) {
            $contactUnread = $count->where('sender_id', $contact->id)->first();
            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;
            return $contact;
        });
        return $user;
    }

    public  function conversation($id){
        PrivateMessage::where('from', $id)->where('to', auth()->id())->update(['read' => true]);
       $messages =  PrivateMessage::with('fromContact')->where(function($q) use ($id) {
           $q->where('from', auth()->id());
           $q->where('to', $id);
       })->orWhere(function($q) use ($id) {
           $q->where('from', $id);
           $q->where('to', auth()->id());
       })->get();
        return response()->json($messages);
    }

    public  function conversationSend(Request $request){

        $message = PrivateMessage::create([
            'from' => auth()->id(),
            'to' => $request->contact_id,
            'message' => $request->message
        ]);
        broadcast(new \App\Events\DataSend($message));

        return response()->json($message);
    }
}
