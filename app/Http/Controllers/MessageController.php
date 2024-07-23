<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *

     */
    public function store(storeMessageRequest $request)
    {
		$message = new Message();
		$message->body = $request['body'];
		$message->read = false;
		$message->user_id = auth()->id();
		$message->conversation_id = (int)$request['conversation_id'];
		$message->save();

		$conversation = $message->conversation;

		$user = User::findOrFail($conversation->user_id == auth()->id() ? $conversation->seconde_user_id: $conversation->user_id);
		$user->pushNotification(auth()->user()->name.' send you a message',$message->body,$message);
		return new MessageResource($message);
    }

    /**
     * Display the specified resource.
     *

     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *

     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *

     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.

     */
    public function destroy(Message $message)
    {
        //
    }
}
