<?php

namespace App\Services;

use App\Dto\PromptMessage;
use App\Enums\PromptType;
use App\Exceptions\PromptFailedException;

class PromptEvaluatorService
{

    public function __construct(
        protected OpenAiService $openAiService
    )
    {
    }

    /**
     * @throws PromptFailedException
     */
    public function evaluate($prompt, $response, $context)
    {
        $systemContext = new PromptMessage(
            'developer',
            "You are an evaluator trained to assess AI-generated responses based on relevance, clarity, and tone. The system message provides context for the conversation and guides the AI's behavior. Users will provide input containing the old prompt, the system message (context), and the AI-generated response. Your task is to evaluate the response on a scale of 0 to 10 for each criterion: relevance measures how well the response addresses the given prompt and context, clarity measures how well the response is written and easy to understand, and tone measures how well the tone matches the intent and audience described in the context. Return your evaluation as a JSON object with the structure: {\"relevance\": [score from 0 to 10], \"clarity\": [score from 0 to 10], \"tone\": [score from 0 to 10]}. Example Input: Prompt: \"Explain how machine learning models are trained.\" System Message: \"The user is a beginner in programming and data science.\" Response: \"Machine learning models are trained using data. A process called training adjusts the model's parameters to minimize error on the given dataset.\" Example Output: {\"relevance\": 9, \"clarity\": 10, \"tone\": 8}."
        );

        $prompt = new PromptMessage(
            'user',
            "Prompt: \"$prompt\" System Message: \"$context\" Response: \"$response\""
        );

        $response = $this->openAiService->createPrompt($prompt, $systemContext, PromptType::EvaluatePrompt);

        $scores = json_decode($response['choices'][0]['message']['content']);

        return $scores;
    }

}
