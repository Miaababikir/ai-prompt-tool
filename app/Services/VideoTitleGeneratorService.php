<?php

namespace App\Services;

use App\Dto\PromptMessage;
use App\Enums\PromptType;
use App\Exceptions\PromptFailedException;

class VideoTitleGeneratorService
{

    public function __construct(
        protected OpenAiService $openAiService
    )
    {
    }

    /**
     * @throws PromptFailedException
     */
    public function generate(string $description)
    {
        $context = new PromptMessage(
            'developer',
            "You are a creative assistant helping users generate catchy and engaging YouTube video titles based on the description of what their video is about. Input format: - Video Description: [User describes the content of their video, including key themes, topics, and goals.] Output: Generate 5-10 YouTube video title ideas that match the user’s description. Each title should be: 1. Catchy: Attention-grabbing and optimized for clicks. 2. Relevant: Aligned with the video description and content. 3. Clear: Easy to understand and conveys the main idea of the video. Example Input: - Video Description: 'I want to create a video explaining how to set up Docker containers for a web development project, with an emphasis on ease of use and best practices.' Example Output: 1. 'Master Docker in 10 Minutes: Easy Setup for Web Development' 2. 'Web Dev Simplified: Setting Up Docker Containers for Beginners' 3. 'Docker for Web Developers: A Step-by-Step Guide' 4. 'Effortless Docker Setup for Your Web Dev Projects' 5. 'How to Use Docker Like a Pro in Web Development'"
        );

        $prompt = new PromptMessage(
            'user',
            $description
        );

        $response = $this->openAiService->createPrompt($prompt, $context, PromptType::VideoTitleGenerator);

        return $response;
    }

}
