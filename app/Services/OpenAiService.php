<?php

namespace App\Services;

use App\Dto\PromptMessage;
use App\Enums\PromptStatus;
use App\Enums\PromptType;
use App\Exceptions\PromptFailedException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAiService
{

    private PendingRequest $client;

    public function __construct(
        protected PromptLogService $promptLogService
    )
    {
        $this->client = Http::baseUrl(config('services.openai.base_url'))
            ->withHeaders([
                "Authorization" => "Bearer " . config('services.openai.api_key'),
            ]);
    }

    /**
     * @throws PromptFailedException
     */
    public function createPrompt(PromptMessage $prompt, PromptMessage $context, PromptType $type)
    {
        try {
            $response = $this->client->post('/v1/chat/completions', [
                "model" => "gpt-4o-mini",
                "messages" => [
                    $context,
                    $prompt,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->promptLogService->log(
                $prompt,
                $context,
                PromptStatus::Failed,
                $type,
            );

            throw new PromptFailedException();
        }

        if ($response->failed()) {
            Log::error($response->body());

            $this->promptLogService->log(
                $prompt,
                $context,
                PromptStatus::Failed,
                $type,
            );

            throw new PromptFailedException();
        }

        $data = $response->json();

        $this->promptLogService->log(
            $prompt,
            $context,
            PromptStatus::Succeeded,
            $type,
            $data['choices'][0]['message']['content']
        );

        return $response->json();
    }

}
