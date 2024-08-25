<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\GroupChat;
use App\Models\ListGroupChat;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ChatController extends Controller
{
    // Ambil semua pesan chat
    public function index(Request $request)
{
    $ads_id = $request->input('ads_id');

    // Query to retrieve chat data along with user data based on ads_id, ordered by created_at in ascending order
    $chats = Chat::select('chats.*', 'users.id as user_id', 'users.name', 'users.image as profile') // Select additional user fields
        ->join('listgroupchats', 'listgroupchats.chat_id', '=', 'chats.id')
        ->join('groupchats', 'groupchats.id', '=', 'listgroupchats.groupchat_id')
        ->join('users', 'users.id', '=', 'listgroupchats.user_id')
        ->where('listgroupchats.ads_id', $ads_id)
        ->orderBy('chats.created_at', 'asc') // Order by created_at in ascending order
        ->get();
// dd($chats);
    // Return the chat data as a JSON response
    return response()->json($chats, 200);
}


    // Simpan pesan baru
    public function store(Request $request)
{
    // Validate the request
    // $this->validate($request, [
    //     'message' => 'nullable|string',
    //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    // ]);

    // Initialize groupchat_id
    $groupchat_id = 0;
    
    // Process image upload if available
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('chat_images', 'public');
    }
    
    // Get the authenticated user
    $user = Auth::user();
    
    // Check if GroupChat already exists for the given ads_id and user_id
    $cek = ListGroupChat::where('ads_id', $request->input('ads_id'))->where('user_id', $user->id)->first();
    if ($cek) {
        $groupchat_id = $cek->groupchat_id;
    } else {
        // Create a new GroupChat if it doesn't exist
        $groupChat = GroupChat::create([
            'user_id' => $user->id,
            'message' => $request->input('message'),
            'image' => $imagePath,
            'sent_at' => Carbon::now()
        ]);
        $groupchat_id = $groupChat->id;

        // Also create the ListGroupChat entry since it's a new GroupChat
       
    }
    
    // return false;
    // Save the message to the Chat model
    $chat = Chat::create([
        'user_id' => $user->id,
        'message' => $request->input('message'),
        'image' => $imagePath,
        'sent_at' => Carbon::now()
    ]);

    ListGroupChat::create([
        'groupchat_id' => $groupchat_id,
        'ads_id' => $request->input('ads_id'),
        'user_id' => $user->id,
        'chat_id' => $chat->id,
    ]);

    // Return the created chat as a JSON response
    return response()->json($chat, 201);
}

public function getGroupChats(Request $request)
    {
        $userId = $request->input('user_id');
        $adsId = $request->input('ads_id');

        $groupChats = GroupChat::select('groupchats.id', 'groupchats.user_id', 'groupchats.message', 'groupchats.image', 'groupchats.sent_at', 'groupchats.created_at')
            ->join('listgroupchats', 'groupchats.id', '=', 'listgroupchats.groupchat_id')
            ->join('ads', 'listgroupchats.ads_id', '=', 'ads.id')
            ->where('ads.user_id', $userId)
            ->where('listgroupchats.ads_id', $adsId)
            ->distinct('groupchats.id')
            ->orderBy('groupchats.created_at', 'asc')
            ->get();

        return response()->json($groupChats);
    }
}
