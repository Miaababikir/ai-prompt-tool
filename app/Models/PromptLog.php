<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromptLog extends Model
{
    protected $fillable = [
        "type",
        "prompt",
        "context",
        "response",
        "status",
        "relevance_score",
        "clarity_score",
        "tone_score",
        "relevance_suggestion",
        "clarity_suggestion",
        "tone_suggestion",
    ];
}
