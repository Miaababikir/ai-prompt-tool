<?php

namespace App\Http\Controllers;

use App\Services\PromptAnalyticsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct(
        protected PromptAnalyticsService $promptAnalyticsService
    )
    {
    }

    public function __invoke(Request $request)
    {

        $totalPromptsUsed = $this->promptAnalyticsService->getTotalPromptsUsed();

        $mostUsedPrompt = $this->promptAnalyticsService->mostUsedPrompts();

        $averagePromptScores = $this->promptAnalyticsService->averagePromptScores();

        $latestPromptSuggestions = $this->promptAnalyticsService->latestPromptSuggestions();

        return Inertia::render('Dashboard', [
            'totalPromptsUsed' => $totalPromptsUsed,
            'mostUsedPrompt' => $mostUsedPrompt,
            'averagePromptScores' => $averagePromptScores,
            'latestPromptSuggestions' => $latestPromptSuggestions,
        ]);
    }
}
