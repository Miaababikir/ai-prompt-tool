<?php

namespace App\Enums;

enum PromptStatus:string
{
    case Succeeded = 'succeeded';
    case Failed = 'failed';

}
