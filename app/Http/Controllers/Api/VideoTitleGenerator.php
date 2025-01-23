<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\VideoTitleGeneratorService;
use Illuminate\Http\Request;

class VideoTitleGenerator extends Controller
{

    public function __construct(
        protected VideoTitleGeneratorService $videoTitleGeneratorService
    )
    {
    }

    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'prompt' => ['required', 'string'],
        ]);

        try {
            $response = $this->videoTitleGeneratorService->generate($data['prompt']);

            return $response;
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
            ], 500);
        }

    }
}
