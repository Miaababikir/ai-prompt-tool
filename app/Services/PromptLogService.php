<?php

namespace App\Services;

use App\Dto\PromptMessage;
use App\Enums\PromptStatus;
use App\Enums\PromptType;
use App\Jobs\EvaluatePrompt;
use App\Models\PromptLog;

class PromptLogService
{

    public function log(
        PromptMessage $prompt,
        PromptMessage $context,
        PromptStatus  $status,
        PromptType    $type,
        string|null   $response = null
    ): void
    {
        if ($type->value === PromptType::EvaluatePrompt->value) {
            return;
        }

        $log = PromptLog::query()
            ->create([
                "type" => $type->value,
                "prompt" => $prompt->content,
                "context" => $context->content,
                "response" => $response,
                "status" => $status->value,
            ]);


        if ($status->value !== PromptStatus::Succeeded->value) {
            return;
        }

        EvaluatePrompt::dispatch($log->id);

    }

    public function find(int $promptLogId)
    {
        return PromptLog::query()
            ->find($promptLogId);
    }

}
