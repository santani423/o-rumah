<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WhatsAppService;

class WhatsAppController extends Controller
{
    protected $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    public function send(Request $request)
    {
        
        // return response()->json($request->all());
        $request->validate([
            'phone' => 'required',
            'message' => 'required',
        ]);

        // return response()->json($request->all());
        $phoneNumber = $request->input('phone');
    
        $message = $request->input('message');
        $response = $this->whatsAppService->sendMessage($phoneNumber, $message);

        return response()->json($response);
    }
}
