<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ChatController extends Controller
{
    // Ambil semua pesan chat
    public function index()
    {
        // Ambil pesan yang paling terbaru
        $chats = Chat::with('user')->orderBy('sent_at', 'asc')->get();
        return response()->json($chats);
    }

    // Simpan pesan baru
    public function store(Request $request)
    {
        $this->validate($request, [
            'message' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Proses upload gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chat_images', 'public');
        }

        // // Simpan pesan ke dalam database
        $chat = Chat::create([
            'user_id' => [157, 160][array_rand([157, 160])], // Pilih antara 157 atau 160
            // 'user_id' => Auth::id(), // Uncomment jika ingin menggunakan Auth user_id
            'message' => $request->input('message'),
            'image' => $imagePath,
            'sent_at' => Carbon::now()
        ]);
        

        // return response()->json('', 201);
        return response()->json($chat, 201);
    }
}
