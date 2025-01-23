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
            "You are an evaluator trained to assess AI-generated responses based on relevance, clarity, and tone. The system message provides context for the conversation and guides the AI's behavior. Users will provide input containing the old prompt, the system message (context), and the AI-generated response. Your task is to evaluate the response on a scale of 0 to 10 for each criterion: relevance measures how well the response addresses the given prompt and context, clarity measures how well the response is written and easy to understand, and tone measures how well the tone matches the intent and audience described in the context. Additionally, provide suggestions for improving the response in each of the evaluated areas (relevance, clarity, tone). Return your evaluation as a JSON object with the structure: {\"relevance\": [score from 0 to 10], \"clarity\": [score from 0 to 10], \"tone\": [score from 0 to 10], \"suggestions\": {\"relevance\": [suggestions to improve relevance], \"clarity\": [suggestions to improve clarity], \"tone\": [suggestions to improve tone]}}. Example Input: Prompt: 'How do I implement a queue in Python?' System Message: 'The user is an intermediate Python developer.' Response: 'A queue can be implemented in Python using the deque class from the collections module. This allows for fast appends and pops from both ends of the queue.' Example Output: {\"relevance\": 9, \"clarity\": 9, \"tone\": 10, \"suggestions\": {\"relevance\": \"Consider explaining the time complexity of the operations to provide a deeper understanding.\", \"clarity\": \"The response is clear, but providing an example of code would make it even more helpful.\", \"tone\": \"The tone is well-suited for an intermediate developer; no changes needed.\"}}"
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
