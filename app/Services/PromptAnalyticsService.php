<?php

namespace App\Services;

use App\Enums\PromptStatus;
use App\Enums\PromptType;
use App\Models\PromptLog;
use Illuminate\Database\Eloquent\Collection;

class PromptAnalyticsService
{


    public function getTotalPromptsUsed(): int
    {
        return PromptLog::query()
            ->where("type", "!=", PromptType::EvaluatePrompt->value)
            ->count();
    }

    public function mostUsedPrompts(): Collection
    {
        return PromptLog::query()
            ->where("type", "!=", PromptType::EvaluatePrompt->value)
            ->selectRaw("type, count(*) as count")
            ->groupBy("type")
            ->orderByDesc("count")
            ->get();
    }

    public function averagePromptScores()
    {
        return PromptLog::query()
            ->where("type", "!=", PromptType::EvaluatePrompt->value)
            ->selectRaw("AVG(relevance_score) as relevance, AVG(clarity_score) as clarity, AVG(tone_score) as tone")
            ->first();
    }

    public function latestPromptSuggestions(): Collection
    {
        return PromptLog::query()
            ->where("type", "!=", PromptType::EvaluatePrompt->value)
            ->where("status", PromptStatus::Succeeded->value)
            ->select("type", "relevance_suggestion", "clarity_suggestion", "tone_suggestion")
            ->orderByDesc("created_at")
            ->limit(5)
            ->get();
    }
}
