<?php

namespace App\Enums;

enum PromptType:string
{
    case VideoTitleGenerator = 'video_title_generator';
    case JobApplicationEmailGenerator = 'job_application_email_generator';
    case EvaluatePrompt = 'evaluate_prompt';
}
