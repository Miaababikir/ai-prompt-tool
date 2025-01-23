<?php

namespace App\Jobs;

use App\Services\PromptEvaluatorService;
use App\Services\PromptLogService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class EvaluatePrompt implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected int $promptLogId,
    )
    {
    }

    /**
     * Execute the job.
     */
    public function handle(PromptLogService $promptLogService, PromptEvaluatorService $evaluatorService): void
    {

        $promptLog = $promptLogService->find($this->promptLogId);

        if ($promptLog === null) {
            return;
        }

        try {
            $scores = $evaluatorService->evaluate($promptLog->prompt, $promptLog->response, $promptLog->context);

            $promptLog->update([
                "relevance_score" => $scores->relevance,
                "clarity_score" => $scores->clarity,
                "tone_score" => $scores->tone,
            ]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return;
        }
    }
}
