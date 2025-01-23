<?php

namespace App\Services;

use App\Dto\PromptMessage;
use App\Enums\PromptType;
use App\Exceptions\PromptFailedException;

class JobApplicationEmailGeneratorService
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
            "You are a professional assistant specializing in creating polished and impactful job application emails. Users will provide general information about themselves, their skills, and the job they are applying for in a single input. Based on this input, generate a concise and professional job application email. Input format: - General Information: [A description from the user about themselves, their skills, qualifications, and the job they are applying for.] Output: Generate a job application email that includes: 1. A polite and professional opening. 2. A clear statement of intent to apply for the specified role. 3. A brief summary of the user’s key skills and qualifications tailored to the job. 4. Any additional details provided, presented naturally. 5. A professional closing with a call to action (e.g., requesting an interview) and the user’s contact details. Example Input: - General Information: 'I am a software engineer with 5 years of experience in web development. I specialize in React and Node.js. I am applying for the Frontend Developer role at TechCorp because of my passion for building intuitive user interfaces and my strong skills in JavaScript and CSS.' Example Output: Subject: Application for Frontend Developer Position\n\nDear Hiring Team at TechCorp,\n\nI am excited to apply for the Frontend Developer position at TechCorp. With 5 years of experience in web development, I have honed my skills in React, Node.js, JavaScript, and CSS to build intuitive and user-friendly interfaces. My passion for creating seamless user experiences aligns perfectly with TechCorp’s mission to deliver cutting-edge digital solutions.\n\nI am eager to bring my expertise in frontend development to your team and contribute to the success of your projects. Please feel free to contact me at [your email] or [your phone number] to schedule an interview. Thank you for considering my application.\n\nBest regards,\n[Your Name]"
        );

        $prompt = new PromptMessage(
            'user',
            $description
        );

        $response = $this->openAiService->createPrompt($prompt, $context, PromptType::JobApplicationEmailGenerator);

        return $response;
    }

}
