<?php

namespace App\Http\Controllers;


use App\Http\Resources\ConversationResource;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
	public function index()
	{


        $userId = Auth::id();

        // Fetch conversations involving the authenticated user and order by 'updated_at'
        $conversations = Conversation::where('user_id', $userId)
            ->orWhere('seconde_user_id', $userId)
            ->orderBy('updated_at', 'desc')
            ->get();

        // Sort conversations by the latest message's ID in descending order
        $sortedConversations = $conversations->sortByDesc(function ($conversation) {
            return optional($conversation->messages->last())->id;
        })->values();

        // Transform the conversations to an array
        $data = $sortedConversations->map(function ($conversation) use ($userId) {
            // Determine the other user in the conversation
            $otherUser = $userId == $conversation->user_id
                ? User::find($conversation->seconde_user_id)
                : User::find($conversation->user_id);

            // Transform messages manually if needed
            $messages = $conversation->messages->map(function ($message) {
                return [
                    'id' => $message->id,
                    'body' => $message->body,
                    'read' => $message->read,
                    'user_id' => $message->user_id,
                    'conversation_id'=>$message->conversation_id,
                    'created_at' => $message->created_at,
                    ];
            });
          $userdetails = User::find($conversation->user_id);
          $userdetails['password']=null;
            // Transform the conversation data
            return  [
                'user_id' => $userdetails,
                'id' => $conversation->id,
                'created_at' => $conversation->created_at,
                'messages' => $messages,
            ];
        });



        return response()->json([
            'data' => $data
        ]);

    }


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return void
     */
	public function create()
	{
		//
	}

	function makConversationAsReaded(Request $request): \Illuminate\Http\JsonResponse
    {
		$request->validate([
			'conversation_id'=>'required',
		]);

		$conversation = Conversation::findOrFail($request['conversation_id']);

		foreach ($conversation->messages as $message) {
			$message->update(['read'=>true]);
		}

		return response()->json('success',200);
	}
	/**
	 * Store a newly created resource in storage.
	 *

     */
	public function store(Request $request)
	{
		$request->validate([
			'user_id'=>'required',
			'message'=>'required'
		]);
		$conversation = Conversation::create([

			'user_id'=>auth()->user()->id,
			'seconde_user_id'=>$request['user_id']
		]);
		Message::create([

			'body'=>$request['message'],
			'user_id'=>auth()->user()->id,
			'conversation_id'=>$conversation->id,
			'read'=>false,
		]);
		return new ConversationResource($conversation);
	}

	/**
	 * Display the specified resource.
	 *

	 */
	public function show(Conversation $conversation)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *

	 */
	public function edit(Conversation $conversation)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *

	 */
	public function update(Request $request, Conversation $conversation)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *

	 */
	public function destroy(Conversation $conversation)
	{
		//
	}
}
