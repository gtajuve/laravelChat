<?php

namespace App\Http\Middleware;

use Closure;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id= $request->id;
        $messagesOfUser=$request->user()->messages;
        foreach($messagesOfUser as $message){
            if($message->id==$id){
                return $next($request);
            }
        }

        return redirect('chat');

    }
}
