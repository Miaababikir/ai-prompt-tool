<?php

namespace App\Dto;

class PromptMessage
{

    public function __construct(
        public string $role,
        public string $content,
    )
    {
    }

}
