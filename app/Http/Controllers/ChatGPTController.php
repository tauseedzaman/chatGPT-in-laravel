<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class ChatGPTController extends Controller
{
    public function index()
    {
        return view("chatGPT/index");
    }

    public function ask(Request $request)
    {
        $request->validate([
            'message' => "required|string"
        ]);

        $result = OpenAI::completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => $request->message . " the response should be only 100 chars",
        ]);

        return response()->json(["content" => $result['choices'][0]['text']]);
    }
}
