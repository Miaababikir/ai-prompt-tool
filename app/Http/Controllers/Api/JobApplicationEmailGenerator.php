<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\JobApplicationEmailGeneratorService;
use Illuminate\Http\Request;

class JobApplicationEmailGenerator extends Controller
{

    public function __construct(
        protected JobApplicationEmailGeneratorService $jobApplicationEmailGeneratorService
    )
    {
    }

    public function __invoke(Request $request)
    {
        $data = $request->validate([
            "prompt" => ["required", "string"],
        ]);

        try {
            $response = $this->jobApplicationEmailGeneratorService->generate($data["prompt"]);

            return $response;
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
            ], 500);
        }
    }
}
