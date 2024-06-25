<?php

namespace App\Http\Controllers\Api\Chat;


use App\Traits\ResponseTrait;
use OpenAI\Laravel\Facades\OpenAI;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenAI\Client as OpenAIClient;
use OpenAI\Exceptions\ErrorException;
use Illuminate\Support\Arr;

class ChatGptController extends Controller
{
    use ResponseTrait ;

    // todo sen question to chat open ai and return response
    protected $openai;

    public function __construct(OpenAIClient $openai)
    {
        $this->openai = $openai;
    }

    // todo send question to chat open ai and return response
    public function chat(Request $request)
    {
        $result = '';

        if ($request->title) {
            $messages = [
                ['role' => 'user', 'content' => 'suggest me 5 domain names from "'.$request->title.'" topic. simply give me domain names list with 1. 2. 3. 4. 5. '],
            ];

            try {
                $response = $this->openai->chat()->create([
                    'model' => 'gpt-3.5-turbo',
                    'messages' => $messages,
                ]);

                $result = Arr::get($response, 'choices.0.message.content', '');
            } catch (ErrorException $e) {
                if (strpos($e->getMessage(), 'You exceeded your current quota') !== false) {
                    return response()->json([
                        'error' => 'Quota exceeded. Please check your plan and billing details.'
                    ], 429);
                } else {
                    return response()->json([
                        'error' => 'An error occurred: ' . $e->getMessage()
                    ], 500);
                }
            }
        }

        return $this->returnData("ChatGPT", $result);
    }

}
